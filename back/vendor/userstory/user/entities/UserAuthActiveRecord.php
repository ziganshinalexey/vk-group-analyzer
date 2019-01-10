<?php

namespace Userstory\User\entities;

use Userstory\ComponentBase\traits\ModifierAwareTrait;
use Userstory\ComponentBase\traits\ValidatorTrait;
use Userstory\User\components\AuthenticationComponent;
use yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;
use yii\db\ActiveQuery;

/**
 * Class UserAuthActiveRecord.
 * Базовый класс аутентификации.
 *
 * @property integer                 $id
 * @property string                  $authSystem
 * @property string                  $login
 * @property string                  $passwordHash
 * @property string                  $authKey
 * @property string                  $passwordResetToken
 * @property integer                 $profileId
 * @property UserProfileActiveRecord $profile
 *
 * @property string                  $password
 * @property string                  $confirmPassword
 * @property string                  $currentPassword
 *
 * @todo Необходимо добавить проверку возможности смены логина и/или пароля у внешних адаптеров аутентификации.
 *
 * @package Userstory\User\entities
 */
class UserAuthActiveRecord extends ActiveRecord implements IdentityInterface
{
    use ModifierAwareTrait, ValidatorTrait;

    /**
     * Новый пароль пользователя.
     *
     * @var string|null
     */
    protected $password;

    /**
     * Атрибут подтверждение пароля.
     *
     * @var string|null
     */
    protected $confirmPassword;

    /**
     * Текущий пароль пользователя. Необходим для смены пароля.
     *
     * @var string|null
     */
    protected $currentPassword;

    /**
     * Метод возвращает пароль пользователя.
     *
     * @return null|string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Метод задает пароль пользователя.
     *
     * @param string $password Значение для установки.
     *
     * @return static
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Метод возвращает подтверждение пароля.
     *
     * @return null|string
     */
    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    /**
     * Метод задает подтверждение пароля.
     *
     * @param string $confirmPassword Значение для установки.
     *
     * @return static
     */
    public function setConfirmPassword($confirmPassword)
    {
        $this->confirmPassword = $confirmPassword;
        return $this;
    }

    /**
     * Метод возвращает текущий пароль пользователя.
     *
     * @return null|string
     */
    public function getCurrentPassword()
    {
        return $this->currentPassword;
    }

    /**
     * Метод задает текущий пароль пользователя.
     *
     * @param null|string $currentPassword Значение для установки.
     *
     * @return static
     */
    public function setCurrentPassword($currentPassword)
    {
        $this->currentPassword = $currentPassword;
        return $this;
    }

    /**
     * Метод дополняет правила валидации.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge($this->rules2(), [
            [
                ['authSystem'],
                'default',
                'value' => 'default',
            ],
            [
                ['login'],
                'string',
                'max' => 50,
            ],
            [
                ['passwordHash'],
                'default',
                'value' => function($model) {
                    return Yii::$app->security->generatePasswordHash($model->password);
                },
            ],
            [
                'passwordHash',
                'required',
            ],
            [
                ['authKey'],
                'default',
                'value' => function() {
                    return Yii::$app->security->generateRandomString();
                },
            ],
            [
                'currentPassword',
                'changePasswordOnUpdate',
                'when' => function($model) {
                    return ! $model->isNewRecord;
                },
            ],
        ]);
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
                    'password',
                    'confirmPassword',
                ],
                'required',
                'when'       => function($model) {
                    return $model->isNewRecord && 'token' !== $model->authSystem;
                },
                'whenClient' => 'function() {
                    return false;
                }',
            ],
            [
                'login',
                'default',
                'value' => function($model) {
                    return null !== $model->profile ? $model->profile->email : null;
                },
            ],
            [
                'login',
                'unique',
                'targetClass' => static::class,
            ],
            [
                'password',
                'string',
                'min' => 6,
            ],
            [
                'confirmPassword',
                'compare',
                'compareAttribute' => 'password',
            ],
            [
                'login',
                'required',
            ],
        ];
    }

    /**
     * Если пользователь хочет сменить пароль через настройки, попадает сюда.
     *
     * @return void
     */
    public function changePasswordOnUpdate()
    {
        if (empty($this->currentPassword)) {
            return;
        }

        if (! $this->canChangeLogin()) {
            $this->addError('password', Yii::t('User.Auth.changePassword', 'Can not change password', [
                'defaultTranslation' => 'Вы не можете сменить пароль',
            ]));
            return;
        }

        if (! Yii::$app->get('authenticationService')->validatePassword($this->currentPassword, $this->passwordHash)) {
            $this->addError('currentPassword', Yii::t('User.Auth.changePassword', 'currentPassword', [
                'defaultTranslation' => 'Пароли не совпадают',
            ]));
            return;
        }

        $validateAttributeList = [
            'password',
            'confirmPassword',
        ];

        if ($this->password && $this->validate($validateAttributeList)) {
            $this->passwordHash = Yii::$app->security->generatePasswordHash($this->password);
        }
    }

    /**
     * Метод определяет наименование полей модели.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'login'           => Yii::t('User.Auth.Attribute', 'login', 'Логин'),
            'password'        => Yii::t('User.Auth.Attribute', 'password', 'Пароль'),
            'confirmPassword' => Yii::t('User.Auth.Attribute', 'confirmPassword', 'Подтверждение пароля'),
            'authSystem'      => Yii::t('User.Auth.Attribute', 'authSystem', 'Тип авторизации'),
        ];
    }

    /**
     * Возвращаем имя таблицы базы данных.
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%auth}}';
    }

    /**
     * Возвращает профиль пользователя.
     *
     * @throws InvalidConfigException Генерируется в родителе в случае, компонент authenticationService не существует.
     *
     * @return UserProfileActiveRecord|ActiveQuery
     */
    public function getProfile()
    {
        /* @var AuthenticationComponent $authenticationService */
        $authenticationService = Yii::$app->authenticationService;
        return $this->hasOne($authenticationService->userProfileClass, ['id' => 'profileId']);
    }

    /**
     * Получение данных пользователя из СУБД.
     *
     * @param integer $id идентификатор пользователя.
     *
     * @return static
     */
    public static function findIdentity($id)
    {
        /* @var static $user */
        if ($user = static::findOne($id)) {
            $user->profile->lastActivity = new Expression('now()');
            $user->profile->save(false, ['lastActivity']);
        }

        return $user;
    }

    /**
     * Заглушка метода интерфейса. Аутентификация по токену не предусмотрена.
     *
     * @param mixed       $token токен аутентификации.
     * @param string|null $type  тип токена.
     *
     * @inherit
     *
     * @return null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Возвращает ID пользователя, прошедшего аутентификацию.
     *
     * @return integer|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Возвращает логин пользователя, прошедшего аутентификацию.
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Возвращает ключ аутентификации.
     *
     * @return string
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * Проверка ключа, основанной на cookie аутентификации.
     *
     * @param string|mixed $authKey ключ для валидации.
     *
     * @return boolean
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Метод сообщает можно ли менять логин пользователя.
     *
     * @return boolean
     */
    public function canChangeLogin()
    {
        return 'default' === $this->authSystem;
    }

    /**
     * Метод сообщает, можно ли менять пароль пользователя.
     *
     * @return boolean
     */
    public function canChangePassword()
    {
        return 'default' === $this->authSystem;
    }

    /**
     * Генерирует токен сдля сброса пароля. Только генерирует и записывает поле объекта.
     *
     * @return void
     */
    public function generatePasswordResetToken()
    {
        $this->passwordResetToken = Yii::$app->security->generateRandomString(96);
    }

    /**
     * Метод выполняет действия перед валидацией.
     *
     * @return boolean
     */
    public function beforeValidate()
    {
        $this->login = mb_strtolower($this->login, 'UTF-8');
        return parent::beforeValidate();
    }
}
