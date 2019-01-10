<?php

namespace Userstory\User\operations;

use Userstory\User\components\AuthorizationComponent;
use Userstory\User\entities\UserAuthActiveRecord;
use Userstory\User\entities\UserProfileActiveRecord;
use Userstory\User\traits\FactoryCommonTrait;
use yii;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;
use yii\db\Connection;
use yii\db\Exception as DbException;
use yii\db\Expression;
use yii\db\Query;
use yii\di\Instance;

/**
 * Class AuthorizationOperation.
 * Класс операций для компонента авторизации пользователей.
 *
 * @package Userstory\User\operations
 */
class AuthorizationOperation extends BaseObject
{
    use FactoryCommonTrait;

    const AUTH_ROLE_TABLE_KEY            = 'authRole';
    const AUTH_ASSIGNMENT_TABLE_KEY      = 'authAssignment';
    const AUTH_ROLE_MAP_TABLE_KEY        = 'authRoleMap';
    const AUTH_ROLE_PERMISSION_TABLE_KEY = 'authRolePermission';

    /**
     * Свойство для взаимодействия с СУБД.
     *
     * @var Connection|mixed
     */
    protected $db = 'db';

    /**
     * Список имен таблиц хранящих права и разрешения пользователей.
     *
     * @var array
     */
    protected $tables = [
        self::AUTH_ROLE_TABLE_KEY            => '{{%auth_role}}',
        self::AUTH_ASSIGNMENT_TABLE_KEY      => '{{%auth_assignment}}',
        self::AUTH_ROLE_MAP_TABLE_KEY        => '{{%auth_role_map}}',
        self::AUTH_ROLE_PERMISSION_TABLE_KEY => '{{%auth_role_permission}}',
    ];

    /**
     * Метод возвращает имя таблицы по ее типу.
     *
     * @param string $type Тип таблицы.
     *
     * @return string
     */
    public function getTable($type)
    {
        return $this->tables[$type];
    }

    /**
     * Сеттер для установки соединения с СУБД, заданного из конфигурации.
     *
     * @param mixed $db инициированное соединение с СУБД.
     *
     * @return static
     */
    public function setDb($db)
    {
        $this->db = $db;
        return $this;
    }

    /**
     * Инициализатор сервиса авторизации.
     *
     * @throws InvalidConfigException Исключение генерируется во внутренних вызовах.
     *
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->db = Instance::ensure($this->db, Connection::class);
    }

    /**
     * Метод возвращает компонент авторизации.
     *
     * @return AuthorizationComponent|mixed
     */
    protected function getAuthorizedComponent()
    {
        return Yii::$app->authManager;
    }

    /**
     * Метод возвращает построитель запросов для список идентифкаторов ролей, членом которых должен быть пользователь.
     *
     * @param integer $profileId       Идентификатор профиля пользователя.
     * @param string  $roleMapTable    Название таблицы маппинга ролей.
     * @param string  $assignmentTable Название таблицы назначений ролей.
     *
     * @return Query
     */
    public function getOuterRolesQuery($profileId, $roleMapTable, $assignmentTable)
    {
        /*
         * Запрос осуществляет выборку карты соответствия ролей пользователя,
         * из выборки исключаются те роли, членом которых пользователь уже является.
         */
        $selectFields = [
            'authSystem' => new Expression('m.{{authSystem}}'),
            'roleId'     => new Expression('m.{{roleId}}'),
            'roleOuter'  => new Expression('m.{{roleOuter}}'),
        ];

        return $this->getQueryObject()
                    ->select($selectFields)
                    ->from(['p' => UserProfileActiveRecord::tableName()])
                    ->innerJoin(['a' => UserAuthActiveRecord::tableName()], 'a.{{profileId}} = p.id AND a.{{authSystem}} <> \'default\'')
                    ->innerJoin(['m' => $roleMapTable], 'm.{{authSystem}} = a.{{authSystem}}')
                    ->leftJoin(['r' => $assignmentTable], 'r.{{profileId}} = p.id AND r.{{roleId}} = m.{{roleId}}')
                    ->where(new Expression('p.id = :PROFILE_ID'), ['PROFILE_ID' => $profileId])
                    ->andWhere(new Expression('r.id IS NULL'))
                    ->orderBy([
                        'm.{{authSystem}}' => SORT_ASC,
                        'm.{{roleId}}'     => SORT_ASC,
                        'm.{{roleOuter}}'  => SORT_ASC,
                    ]);
    }

    /**
     * Метод возвращает список идентифкаторов ролей, членом которых должен быть пользователь.
     *
     * @param integer $profileId Идентификатор пользователя.
     * @param Query   $query     Подготовленный объект построителя запросов.
     *
     * @return array
     */
    public function getOuterRoles($profileId, Query $query)
    {
        $authComponent = $this->getAuthorizedComponent();
        $roleMap       = [];

        foreach ($query->all($this->db) as $row) {
            $roleMap[$row['authSystem']][$row['roleOuter']][] = $row['roleId'];
        }

        $roles = [
            [],
        ];

        foreach ($roleMap as $authSystem => $map) {
            $adapter = $authComponent->getRoleServiceAdapter($authSystem);
            if (null === $adapter) {
                continue;
            }

            $user = UserAuthActiveRecord::findOne([
                'profileId'  => $profileId,
                'authSystem' => $authSystem,
            ]);

            $roles[] = $adapter->getIdentityRoles($user, $map);
        }

        $roles = array_merge(...$roles);

        return array_unique($roles);
    }

    /**
     * Метод добавляет роли пользователя.
     *
     * @param integer $profileId Идентификатор профиля пользователя.
     * @param array   $roleIds   Идентификаторы ролей для добавления.
     *
     * @throws DbException Исключение генерируется во внутренних вызовах.
     *
     * @return void
     */
    public function addOuterRoles($profileId, array $roleIds)
    {
        if (empty($roleIds)) {
            return;
        }

        $authAssignmentTable = $this->getTable(self::AUTH_ASSIGNMENT_TABLE_KEY);
        $rows                = [];

        foreach ($roleIds as $roleId) {
            $rows[] = [
                'roleId'    => $roleId,
                'profileId' => $profileId,
            ];
        }

        $this->db->createCommand()->batchInsert($authAssignmentTable, [
            'roleId',
            'profileId',
        ], $rows)->execute();
    }

    /**
     * Метод возвращает список всех разрешений по всем ролям пользователя.
     *
     * @param integer $profileId Идентификатор профиля пользователя.
     *
     * @return array
     */
    public function getUserPermissions($profileId)
    {
        $query               = $this->getQueryObject();
        $authRoleTable       = $this->getTable(self::AUTH_ROLE_TABLE_KEY);
        $authPermissionTable = $this->getTable(self::AUTH_ROLE_PERMISSION_TABLE_KEY);
        $authAssignmentTable = $this->getTable(self::AUTH_ASSIGNMENT_TABLE_KEY);

        // Запрос осуществляет выборку всех полномочий по всем ролям пользователя.
        $query->select([
            'p.{{permission}}',
            'isGlobal' => new Expression('max(p.{{isGlobal}})'),
        ])->from(['a' => $authAssignmentTable])->where([
            'profileId' => $profileId,
            'isActive'  => 1,
        ])->innerJoin(['r' => $authRoleTable], 'r.id = a.{{roleId}}');

        $query->innerJoin(['p' => $authPermissionTable], 'p.{{roleId}} = r.id')->groupBy('p.{{permission}}');

        $permissions = [];
        foreach ($query->all($this->db) as $row) {
            $permissions[$row['permission']] = $row['isGlobal'];
        }

        return $permissions;
    }

    /**
     * Метод добавляет разрешения для неавторизованного пользователя.
     *
     * @param array $permissions Список разрешений для обновления.
     *
     * @return void
     */
    public function updateUnauthorizedUserPermissions(array &$permissions)
    {
        $query               = $this->getQueryObject();
        $guestRole           = $this->getAuthorizedComponent()->guestRole;
        $authRoleTable       = $this->getTable(self::AUTH_ROLE_TABLE_KEY);
        $authPermissionTable = $this->getTable(self::AUTH_ROLE_PERMISSION_TABLE_KEY);

        // Запрос осуществляет выборку всех полномочий по всем ролям пользователя.
        $query->select([
            'p.{{permission}}',
            'isGlobal' => new Expression('max(p.{{isGlobal}})'),
        ])->from(['r' => $authRoleTable])->where([
            'name' => $guestRole,
        ])->innerJoin(['p' => $authPermissionTable], 'p.{{roleId}} = r.id')->groupBy('p.{{permission}}');

        foreach ($query->all($this->db) as $row) {
            $permissions[$row['permission']] = $row['isGlobal'];
        }
    }
}
