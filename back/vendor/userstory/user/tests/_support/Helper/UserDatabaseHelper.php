<?php

declare( strict_types = 1 );

namespace Userstory\User\Tests\Helper;

use Codeception\Exception\ModuleException;
use Codeception\Module;
use Codeception\Module\Db;
use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\User\entities\AuthAssignmentActiveRecord;
use Userstory\User\entities\UserAuthActiveRecord;
use Userstory\User\entities\UserProfileActiveRecord;
use Userstory\User\entities\UserProfileSettingActiveRecord;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use yii;

/**
 * Class UserDatabaseHelper
 * Класс для работы с предусловиями пакета юзеров.
 *
 * @package Userstory\UserRest\tests\Helper
 */
class UserDatabaseHelper extends Module
{
    /**
     * Возвращает название таблицы профилей пользователя.
     *
     * @return string
     */
    protected function getUserProfileTableName(): string
    {
        return Yii::$app->db->schema->getRawTableName(UserProfileActiveRecord::tableName());
    }

    /**
     * Возвращает название таблицы аутентификации.
     *
     * @return string
     */
    protected function getAuthTableName(): string
    {
        return Yii::$app->db->schema->getRawTableName(UserAuthActiveRecord::tableName());
    }

    /**
     * Возвращает название таблицы для связи профиля с ролью.
     *
     * @throws InvalidConfigException Неправильно настроен конфиг.
     *
     * @return string
     */
    protected function getAssignmentTableName(): string
    {
        return Yii::$app->db->schema->getRawTableName(AuthAssignmentActiveRecord::tableName());
    }

    /**
     * Возвращает название таблицы дополнительных настроек профиля.
     *
     * @return string
     */
    protected function getProfileSettingsTableName(): string
    {
        return Yii::$app->db->schema->getRawTableName(UserProfileSettingActiveRecord::tableName());
    }

    /**
     * Добавляет юзера с переданными параметрами.
     *
     * @param string $login   Логин создаваемого пользователя.
     * @param array  $options Параметры создаваемого пользователя.
     *
     * @throws ModuleException Эксепш вызван модулем Дб.
     * @throws Exception Неверный формат пароля.
     *
     * @return int
     */
    public function createNewUser(string $login, array $options = []): int
    {
        if (ArrayHelper::getValue($options, 'password')) {
            $passwordHash = Yii::$app->security->generatePasswordHash($options['password']);
        } else {
            $passwordHash = '$2y$13$aR4VQ92DNVOz5E6Lw7265elRxO/HYbsty2QOADg3Q6VO9KJbXZpmW';
        }
        $roleId    = ArrayHelper::getValue($options, 'roleId', 1);
        $profileId = $this->addUserProfileEntity($options);
        $this->addAuthEntity($login, $passwordHash, $profileId);
        $this->addAssignmentTableName($roleId, $profileId);
        $this->addProfileSettingsEntity($profileId, $options);
        return $profileId;
    }

    /**
     * Создаем запись в таблице профиля.
     *
     * @param array $params Массив с параметрами пользователя.
     *
     * @throws ModuleException Эксепш вызван модулем Дб.
     *
     * @return int
     */
    public function addUserProfileEntity(array $params = []): int
    {
        $profileId = $this->getModuleDb()->haveInDatabase($this->getUserProfileTableName(), [
            'firstName'    => ArrayHelper::getValue($params, 'firstName', 'John'),
            'lastName'     => ArrayHelper::getValue($params, 'lastName', 'Smith'),
            'secondName'   => ArrayHelper::getValue($params, 'secondName', 'Иванович'),
            'email'        => ArrayHelper::getValue($params, 'email', 'test@mail.com'),
            'phone'        => ArrayHelper::getValue($params, 'phone', '71111111111'),
            'lastActivity' => null,
            'isActive'     => ArrayHelper::getValue($params, 'isActive', 1),
            'creatorId'    => '1',
        ]);
        return $profileId;
    }

    /**
     * Создаем запись в таблице аутентификации.
     *
     * @param string $login        Логин пользователя.
     * @param string $passwordHash Хэш пароля для записи в таблицу.
     * @param int    $profileId    Идентификатор профиля пользователя.
     *
     * @throws ModuleException Эксепш вызван модулем Дб.
     *
     * @return void
     */
    public function addAuthEntity(string $login, string $passwordHash, int $profileId): void
    {
        $this->getModuleDb()->haveInDatabase($this->getAuthTableName(), [
            'authSystem'         => 'default',
            'login'              => $login,
            'passwordHash'       => $passwordHash,
            'authKey'            => 'GHjk2H70A1rG7vrhydnHy66eiKtFdm4O',
            'passwordResetToken' => null,
            'creatorId'          => '1',
            'profileId'          => $profileId,
        ]);
    }

    /**
     * Создаем запись в таблице ассоциации ролей и пользователей.
     *
     * @param int $roleId    Привязываемая к профилю роль.
     * @param int $profileId Профиль которому назначается роль.
     *
     * @throws ModuleException Эксепш вызван модулем Дб.
     * @throws InvalidConfigException Неправильно настроен конфиг.
     *
     * @return void
     */
    public function addAssignmentTableName(int $roleId, int $profileId): void
    {
        $this->getModuleDb()->haveInDatabase($this->getAssignmentTableName(), [
            'roleId'    => $roleId,
            'profileId' => $profileId,
            'isActive'  => 1,
            'creatorId' => '1',
        ]);
    }

    /**
     * Создаем запись в таблице настроек профиля.
     *
     * @param int   $profileId Идентификатор профиля.
     * @param array $options   Настройки профиля.
     *
     * @throws ModuleException Эксепш вызван модулем Дб.
     *
     * @return void
     */
    public function addProfileSettingsEntity(int $profileId, array $options = []): void
    {
        $birthday       = ArrayHelper::getValue($options, 'birthday', null);
        $education      = ArrayHelper::getValue($options, 'education', null);
        $employmentDate = ArrayHelper::getValue($options, 'employmentDate', null);
        $this->getModuleDb()->haveInDatabase($this->getProfileSettingsTableName(), [
            'relationId' => $profileId,
            'fieldsetId' => 1,
            'dataJson'   => Json::encode([
                'city'           => null,
                'personalSnils'  => '',
                'photo'          => null,
                'company'        => '',
                'employmentDate' => $employmentDate,
                'birthday'       => $birthday,
                'position'       => '',
                'personalInn'    => '',
                'education'      => $education,
            ]),
            'creatorId'  => '1',
        ]);
    }

    /**
     * Метод, проверяющий наличие записи в таблице профилей.
     *
     * @param array $criteria Параметры поиска в таблице.
     *
     * @throws ModuleException Эксепш вызван модулем Дб.
     *
     * @return void
     */
    public function seeInProfileTable(array $criteria): void
    {
        $this->getModuleDb()->seeInDatabase($this->getUserProfileTableName(), $criteria);
    }

    /**
     * Метод, возвращающий значение поля из таблицы профилей.
     *
     * @param string $column   Колонка, значение которой желаем получить.
     * @param array  $criteria Параметры поиска в таблице.
     *
     * @todo Косяк в кодесепшене, после выхода фикса сделать чтобы метод возвращал всю строку из таблицы.
     *
     * @throws ModuleException Эксепш вызван модулем Дб.
     *
     * @return mixed
     */
    public function grabFromProfileTable(string $column, array $criteria)
    {
        return $this->getModuleDb()->grabFromDatabase($this->getUserProfileTableName(), $column, $criteria);
    }

    /**
     * Возвращает модуль кодесепшена ДБ.
     *
     * @throws ModuleException
     *
     * @return Module|Db
     */
    public function getModuleDb(): Db
    {
        return $this->getModule('Db');
    }
}
