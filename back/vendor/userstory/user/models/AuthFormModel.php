<?php

namespace Userstory\User\models;

use Userstory\User\components\AuthenticationComponent;
use Userstory\User\entities\UserAuthActiveRecord;
use Userstory\User\traits\FactoryCommonTrait;
use yii;
use yii\base\InvalidConfigException;
use yii\base\Model;

/**
 * Class AuthFormModel.
 * Класс формы для валидации введенных пользователем данных при изменения аутентификационной информации.
 *
 * @property string  $login
 * @property string  $authSystem
 * @property string  $passwordCurrent
 * @property string  $password
 * @property string  $passwordConfirm
 * @property string  $passwordHash
 * @property boolean $canChangeLogin
 * @property boolean $canChangePassword
 * @property integer $id
 *
 * @package Userstory\User\models
 */
class AuthFormModel extends Model
{
    use FactoryCommonTrait;

    /**
     * Логин пользователя в системе аутентификации authSystem.
     *
     * @var string|null
     */
    protected $login;

    /**
     * Свойство формы, хранящее систему аутентификации.
     *
     * @var string
     */
    protected $authSystem = 'default';

    /**
     * Свойство формы, для ввода текущего пароля пользователя.
     *
     * @var string|null
     */
    protected $passwordCurrent;

    /**
     * Свойство формы, для ввода пароля пользователя.
     *
     * @var string|null
     */
    protected $password;

    /**
     * Свойство формы, для повторного ввода пароля пользователя.
     *
     * @var string|null
     */
    protected $passwordConfirm;

    /**
     * Хэш пароля, на форме не используется, но необходим для передачи хэша в модель аутентификации.
     *
     * @var string|null
     */
    protected $passwordHash;

    /**
     * Свойство формы аутентификации, сообщающее: может ли пользователь изменить логин.
     *
     * @var boolean|null
     */
    protected $canChangeLogin;

    /**
     * Свойство формы аутентификации, сообщающее: может ли пользователь менять пароль.
     *
     * @var boolean|null
     */
    protected $canChangePassword;

    /**
     * Свойство формы, сообщающее какая именно аутентификационная пара БД редактируется в настоящее время.
     *
     * @var integer|null
     */
    protected $id;

    /**
     * Метод возвращает логин пользователя.
     *
     * @return string|null
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Метод задает логин пользователя.
     *
     * @param string $login Значение для установки.
     *
     * @return static
     */
    public function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }

    /**
     * Метод возвращает систему аутентификации.
     *
     * @return string
     */
    public function getAuthSystem()
    {
        return $this->authSystem;
    }

    /**
     * Метод задает систему аутентификации.
     *
     * @param string $authSystem Значение для установки.
     *
     * @return static
     */
    public function setAuthSystem($authSystem)
    {
        $this->authSystem = $authSystem;
        return $this;
    }

    /**
     * Метод возвращает текущий пароль.
     *
     * @return string|null
     */
    public function getPasswordCurrent()
    {
        return $this->passwordCurrent;
    }

    /**
     * Метод задает текущий пароль.
     *
     * @param string $passwordCurrent Значение для установки.
     *
     * @return static
     */
    public function setPasswordCurrent($passwordCurrent)
    {
        $this->passwordCurrent = $passwordCurrent;
        return $this;
    }

    /**
     * Метод возвращает новый пароль.
     *
     * @return string|null
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Метод задает новый пароль.
     *
     * @param string|null $password Значение для установки.
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
    public function getPasswordConfirm()
    {
        return $this->passwordConfirm;
    }

    /**
     * Метод задает подтверждение пароля.
     *
     * @param string $passwordConfirm Значение для установки.
     *
     * @return static
     */
    public function setPasswordConfirm($passwordConfirm)
    {
        $this->passwordConfirm = $passwordConfirm;
        return $this;
    }

    /**
     * Метод возвращает хэш пароля.
     *
     * @return string
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
     * Метод возвращает может ли пользователь изменить логин.
     *
     * @return boolean
     */
    public function getCanChangeLogin()
    {
        return $this->canChangeLogin;
    }

    /**
     * Метод задает может ли пользователь изменить логин.
     *
     * @param boolean $canChangeLogin Значение для установки.
     *
     * @return static
     */
    public function setCanChangeLogin($canChangeLogin)
    {
        $this->canChangeLogin = $canChangeLogin;
        return $this;
    }

    /**
     * Метод возвращает может ли пользователь изменить пароль.
     *
     * @return string
     */
    public function getCanChangePassword()
    {
        return $this->canChangePassword;
    }

    /**
     * Метод задает может ли пользователь изменить пароль.
     *
     * @param boolean $canChangePassword Значение для установки.
     *
     * @return static
     */
    public function setCanChangePassword($canChangePassword)
    {
        $this->canChangePassword = $canChangePassword;
        return $this;
    }

    /**
     * Метод возвращает значение аутентификационной пары БД, которая редактируется в настоящее время.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Метод задает значение аутентификационной пары БД, которая редактируется в настоящее время.
     *
     * @param integer $id Значение для установки.
     *
     * @return static
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Определение наименования атрибутов.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return array_merge_recursive(parent::attributeLabels(), [
            'login'           => Yii::t('User.AuthForm', 'login', 'Логин'),
            'passwordCurrent' => Yii::t('User.AuthForm', 'passwordCurrent', 'Текущий пароль'),
            'password'        => Yii::t('User.AuthForm', 'password', 'Пароль'),
            'passwordConfirm' => Yii::t('User.AuthForm', 'passwordConfirm', 'Повторите пароль'),
        ]);
    }

    /**
     * Метод класс, определяющий правила валидации формы.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [
                ['login'],
                'required',
            ],
            [
                ['login'],
                'validateLoginUnique',
            ],
            [
                ['passwordCurrent'],
                'required',
                'whenClient' => 'function (attribute, value) {return false;}',
                'when'       => function($model) {
                    return ! empty($model->password) || ! empty($model->passwordConfirm);
                },
            ],
            [
                ['passwordCurrent'],
                'validateCurrentPassword',
            ],
            [
                [
                    'password',
                    'passwordConfirm',
                ],
                'required',
                'whenClient' => 'function (attribute, value) {return false;}',
                'when'       => function($model) {
                    /* @var static $model */
                    return ! empty($model->passwordCurrent) && ! $model->hasErrors('passwordCurrent');
                },
            ],
            [
                ['password'],
                'string',
                'min' => 6,
                'max' => 255,
            ],
            [
                ['passwordConfirm'],
                'validateEqual',
                'params' => 'password',
            ],
        ];
    }

    /**
     * Проверка на совпадение пароля и подтверждения.
     *
     * @param string $attribute Проверяемое свойство формы.
     * @param mixed  $params    Параметры проверка.
     *
     * @return void
     */
    public function validateEqual($attribute, $params)
    {
        if ($this->{$attribute} !== $this->{$params}) {
            $this->addError($attribute, 'Введенные пароли не совпадают');
        }
    }

    /**
     * Метод осуществляет проверку текущего пароля пользователя.
     *
     * @param string $attribute проверяемый атрибут.
     *
     * @throws InvalidConfigException не настроен компонент authenticationService.
     * @return boolean
     */
    public function validateCurrentPassword($attribute)
    {
        /* @var AuthenticationComponent $authService */
        $authService = Yii::$app->authenticationService;
        $result      = $authService->getAdapter('default')->setCredential($this->$attribute)->setIdentity($this->login)->authenticate();

        if (! $result->isValid()) {
            $this->addError($attribute, 'Текущий пароль указан не верно');
        }

        return $result->isValid();
    }

    /**
     * Метод проверки уникальности указанного логина.
     *
     * @param string $attribute проверяемый атрибут.
     *
     * @return boolean
     */
    public function validateLoginUnique($attribute)
    {
        $condition = $this->getExpression(sprintf('lower(%s) = :system', Yii::$app->db->quoteColumnName('authSystem')));
        $query     = UserAuthActiveRecord::find()->andWhere($condition, ['system' => $this->authSystem]);
        $query     = $query->andWhere($this->getExpression('lower(login) = lower(:login)'), ['login' => $this->$attribute]);

        if (null !== $this->id) {
            $query->andWhere($this->getExpression('id <> :id'), ['id' => $this->id]);
        }

        $result = $query->exists();

        if ($result) {
            $this->addError($attribute, 'Указанный логин существует, выберите другой');
            return false;
        }

        return true;
    }
}
