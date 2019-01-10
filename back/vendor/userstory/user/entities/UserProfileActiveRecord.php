<?php

namespace Userstory\User\entities;

use Userstory\ComponentBase\traits\ModifierAwareTrait;
use Userstory\ComponentBase\traits\ValidatorTrait;
use Userstory\User\interfaces\UserInterface;
use yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\Db\Query;

/**
 * Class UserProfileActiveRecord.
 * Базовый классс для работы с профилем полльзователя.
 *
 * @property integer                        $id
 * @property string                         $firstName
 * @property string                         $lastName
 * @property string                         $secondName
 * @property string                         $username
 * @property string                         $email
 * @property integer                        $phone
 * @property string                         $lastActivity
 * @property boolean                        $isActive
 *
 * @property UserAuthActiveRecord[]         $auth
 * @property UserProfileSettingActiveRecord $additionalProperties
 * @property AuthAssignmentActiveRecord[]   $authAssignment
 * @property AuthRoleActiveRecord           $authRole
 *
 * @package Userstory\User\entities
 */
class UserProfileActiveRecord extends ActiveRecord implements UserInterface
{
    use ModifierAwareTrait, ValidatorTrait {
        ModifierAwareTrait::beforeSave as private beforeSaveModifier;
    }

    /**
     * Статичное свойство, в котором объявлен класс аутентификации.
     *
     * @var string
     */
    protected static $authClass = UserAuthActiveRecord::class;

    /**
     * Перегрузка геттера, для инициализации обязательных связанных данных.
     *
     * @param string|mixed $name Имя переменной.
     *
     * @return mixed
     */
    public function __get($name)
    {
        $value = parent::__get($name);

        if (null !== $value) {
            return $value;
        }

        switch (strtolower($name)) {
            case 'additionalproperties':
                $fieldset             = new UserProfileSettingActiveRecord();
                $fieldset->relationId = $this->id;
                $fieldset->save(false);
                return $fieldset;
        }

        return $value;
    }

    /**
     * Метод дополняет правила валидации.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge([
            [
                'email',
                'unique',
                'filter' => $this->id ? 'id!=' . $this->id : '',
            ],
            [
                'email',
                'filter',
                'filter' => 'mb_strtolower',
            ],
            [
                'username',
                'filter',
                'filter' => 'mb_strtolower',
                'when'   => function($model) {
                    return (bool)$model->username;
                },
            ],
            [
                'username',
                'unique',
                'filter' => $this->id ? 'id!=' . $this->id : '',
                'when'   => function($model) {
                    return (bool)$model->username;
                },
            ],
            [
                'phone',
                'unique',
                'filter' => $this->id ? 'id!=' . $this->id : '',
                'when'   => function($model) {
                    return (bool)$model->phone;
                },
            ],
        ], $this->rules2());
    }

    /**
     * Метод дополняет правила валидации.
     *
     * @return array
     */
    protected function rules2()
    {
        return [
            [
                [
                    'firstName',
                    'lastName',
                    'email',
                ],
                'required',
            ],
            [
                [
                    'firstName',
                    'lastName',
                    'secondName',
                ],
                'string',
                'max' => 50,
            ],
            [
                ['email'],
                'string',
                'max' => 100,
            ],
            [
                ['email'],
                'email',
            ],
            [
                ['phone'],
                'filter',
                'filter' => function($value) {
                    return preg_replace('/\D+/', '', $value);
                },
            ],
            [
                ['isActive'],
                'default',
                'value' => 1,
            ],
            [
                'phone',
                'string',
                'max' => 12,
            ],
        ];
    }

    /**
     * Метод определяет наименование полей модели.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'firstName'  => Yii::t('User.Profile.Attribute', 'firstName', 'Имя'),
            'lastName'   => Yii::t('User.Profile.Attribute', 'lastName', 'Фамилия'),
            'secondName' => Yii::t('User.Profile.Attribute', 'secondName', 'Отчество'),
            'phone'      => Yii::t('User.Profile.Attribute', 'phone', 'Телефон'),
            'isActive'   => Yii::t('User.Profile.Attribute', 'isActive', 'Активирован'),
            'username'   => Yii::t('User.Profile.Attribute', 'username', 'Имя пользователя'),
        ];
    }

    /**
     * Метод возвращает шаблон имени таблицы СУБД.
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%profile}}';
    }

    /**
     * Возвращает ИД профиля пользователя.
     *
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Возвращает логин пользователя. Профиль может не обладать информацией о логине пользователя.
     *
     * @return null
     */
    public function getLogin()
    {
        return null;
    }

    /**
     * Метод возвращает пользовательское имя.
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->username;
    }

    /**
     * Возвращает логин пользователя.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Возвращает фамилию пользователя.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Возвращает отчество пользователя.
     *
     * @return string
     */
    public function getSecondName()
    {
        return $this->secondName;
    }

    /**
     * Возвращает отображемое имя пользователя.
     *
     * @return string
     *
     * @deprecated Реализуем самостоятельно во фронте.
     */
    public function getDisplayName()
    {
        $names = [];
        if ($this->lastName) {
            $names[] = $this->lastName;
        }
        if ($this->firstName) {
            $names[] = $this->firstName;
        }
        if ($this->secondName) {
            $names[] = $this->secondName;
        }

        return implode(' ', $names);
    }

    /**
     * Метод возвращает номер телефона.
     *
     * @return integer
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Метод возвращает истину, если профиль активен.
     *
     * @return boolean
     */
    public function isActive()
    {
        return (bool)$this->isActive;
    }

    /**
     * Возвращает адрес электронной почты.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Геттер для связанных данных, следует использовать свойство auth.
     *
     * @return ActiveQuery
     */
    public function getAuth()
    {
        return $this->hasMany(static::$authClass, ['profileId' => 'id'])->indexBy('id')->inverseOf('profile');
    }

    /**
     * Геттер для связанных данных, следует использовать свойство additionalProperties.
     *
     * @return UserProfileSettingActiveRecord|ActiveQuery
     */
    public function getAdditionalProperties()
    {
        return $this->hasOne(UserProfileSettingActiveRecord::class, ['relationId' => 'id'])->inverseOf('profile');
    }

    /**
     * Геттер для получения связанных ролей для порофиля.
     *
     * @return AuthRoleActiveRecord[]|ActiveQuery
     */
    public function getAuthRole()
    {
        return $this
            ->hasMany(AuthRoleActiveRecord::class, ['id' => 'roleId'])
            ->viaTable(AuthAssignmentActiveRecord::tableName(), ['profileId' => 'id']);
    }

    /**
     * Геттер для получения связей с ролями для профиля.
     *
     * @return AuthAssignmentActiveRecord[]|ActiveQuery
     */
    public function getAuthAssignment()
    {
        return $this->hasMany(AuthAssignmentActiveRecord::class, ['profileId' => 'id']);
    }

    /**
     * Возвращает идентификатор роли.
     *
     * @param string $role Роль по которой необходимо искать.
     *
     * @return integer
     */
    public static function getRoleId($role = 'admin')
    {
        return AuthRoleActiveRecord::findOne(['name' => $role])->id;
    }

    /**
     * Возвращает количество пользователей с ролью $role.
     *
     * @param string $role Роль по которой необходимо искать.
     *
     * @throws InvalidConfigException Генерируется в родителе в случае, компонент authManager не существует.
     *
     * @return integer
     */
    public static function getActiveRoleCount($role = 'admin')
    {
        $qAaProfileId = Yii::$app->getDb()->quoteColumnName('aa.profileId');
        $qUpId        = Yii::$app->getDb()->quoteColumnName('up.id');

        $query = ( new Query() )->from(['up' => self::tableName()]);
        $query = $query->innerJoin(['aa' => AuthAssignmentActiveRecord::tableName()], sprintf('%s = %s', $qUpId, $qAaProfileId));

        return $query->where(['aa.roleId' => static::getRoleId($role)])->andWhere([
            'aa.isActive' => 1,
            'up.isActive' => 1,
        ])->count();
    }

    /**
     * Возвращает true если данный пользователь единственный с ролью admin.
     *
     * @throws InvalidConfigException Генерируется в родителе в случае, компонент authManager не существует.
     *
     * @return boolean
     */
    public function isLastAdmin()
    {
        $isAdmin = $this->getAuthAssignment()->andWhere(['roleId' => static::getRoleId()])->count() > 0;

        return $isAdmin && static::getActiveRoleCount() <= 1;
    }

    /**
     * Выполняется перед вызовом удаления модели.
     *
     * @throws InvalidConfigException Генерируется в родителе в случае, компонент authManager не существует.
     *
     * @return boolean
     */
    public function beforeDelete()
    {
        if ($this->isLastAdmin()) {
            return false;
        }

        return parent::beforeDelete();
    }

    /**
     * Выполняется перед вызовом сохранения модели.
     *
     * @param boolean $insert означает происходит вставка или сохранение значения.
     *
     * @return boolean
     */
    public function beforeSave($insert)
    {
        if (! $this->beforeSaveModifier($insert)) {
            return false;
        }

        $wasActive = array_key_exists('isActive', $this->oldAttributes) ? $this->oldAttributes['isActive'] : false;

        if (false === $insert && $wasActive && 1 !== (int)$this->isActive && $this->isLastAdmin()) {
            $this->addError('isActive', 'Невозможно отключить последнего, активного администратора.');
            return false;
        }

        return true;
    }

    /**
     * Получение связанных полей верификации.
     *
     * @return ActiveQuery
     */
    public function getVerification()
    {
        if (array_key_exists('verification', Yii::$app->components)) {
            $class = Yii::$app->components['verification']['class'];
            return $this->hasMany($class::$userVerificationClass, ['profileId' => 'id']);
        }

        return new ActiveQuery(static::class);
    }
}
