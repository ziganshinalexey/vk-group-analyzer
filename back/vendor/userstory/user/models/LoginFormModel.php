<?php

namespace Userstory\User\models;

use RuntimeException;
use Userstory\ComponentBase\traits\ValidatorTrait;
use Userstory\ComponentHelpers\helpers\DateHelper;
use Userstory\User\components\AuthenticationComponent;
use Userstory\User\components\UserComponent;
use Userstory\User\entities\UserAuthActiveRecord;
use Userstory\User\traits\FactoryCommonTrait;
use yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\Connection;
use yii\db\Exception as DBException;
use yii\db\Schema;

/**
 * Class LoginFormModel.
 * Класс формы логина и проверки аутентификации.
 *
 * @property string  $login
 * @property string  $password
 * @property boolean $rememberMe
 * @property integer $rememberTerm
 * @property string  $captcha
 *
 * @package Userstory\User\forms
 */
class LoginFormModel extends Model
{
    use ValidatorTrait, FactoryCommonTrait;

    /**
     * Свойство для ввода логина пользователя.
     *
     * @var string|null
     */
    protected $login;

    /**
     * Свойство для ввода пароля пользователя.
     *
     * @var string|null
     */
    protected $password;

    /**
     * Поле установки долгой сессии юзера.
     *
     * @var boolean|null
     */
    protected $rememberMe;

    /**
     * Свойство узнанного закешированного юзера.
     *
     * @var UserAuthActiveRecord|null
     */
    protected $cachedUser;

    /**
     * Время в секундах, на которое запоминается юзер.
     *
     * @var integer
     */
    protected $rememberTerm = 3600 * 24 * 30;

    /**
     * Объект качпчи для авторизации.
     *
     * @var null|string
     */
    protected $captcha;

    /**
     * IP адрес клиента, который должен быть в int.
     *
     * @var integer|null
     */
    protected $ip;

    /**
     * Объект подключения к базе для учета ошибок логина.
     *
     * @var Connection|null
     */
    protected $captchaDB;

    /**
     * Количество попыток пользователя залогинится.
     *
     * @var integer|null
     */
    protected $loginTriesCount;

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
     * Метод возвращает пароль пользователя.
     *
     * @return string|null
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
     * Метод возвращает значение долгой сессии юзера.
     *
     * @return boolean|null
     */
    public function getRememberMe()
    {
        return $this->rememberMe;
    }

    /**
     * Метод задает значение долгой сессии юзера.
     *
     * @param boolean $rememberMe Значение для установки.
     *
     * @return static
     */
    public function setRememberMe($rememberMe)
    {
        $this->rememberMe = $rememberMe;
        return $this;
    }

    /**
     * Метод возвращает время в секундах, на которое запоминается юзер.
     *
     * @return integer
     */
    public function getRememberTerm()
    {
        return $this->rememberTerm;
    }

    /**
     * Метод задает время в секундах, на которое запоминается юзер.
     *
     * @param integer $rememberTerm Значение для установки.
     *
     * @return static
     */
    public function setRememberTerm($rememberTerm)
    {
        $this->rememberTerm = $rememberTerm;
        return $this;
    }

    /**
     * Метод возвращает значение капчи.
     *
     * @return string
     */
    public function getCaptcha()
    {
        return $this->captcha;
    }

    /**
     * Метод задает значение капчи.
     *
     * @param string $captcha Значение для установки.
     *
     * @return static
     */
    public function setCaptcha($captcha)
    {
        $this->captcha = $captcha;
        return $this;
    }

    /**
     * Определение правил валидации формы.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [
                ['captcha'],
                'required',
                'when' => function() {
                    return $this->isRequireCaptcha();
                },
            ],
            [
                'captcha',
                'captcha',
                'captchaAction' => $this->getCaptchaConfig('action'),
                'skipOnEmpty'   => true,
            ],
            [
                [
                    'login',
                    'password',
                ],
                'required',
            ],
            [
                'password',
                'validatePassword',
            ],
            [
                ['rememberMe'],
                'default',
                'value' => false,
            ],
            [
                ['rememberMe'],
                'filter',
                'filter' => function($value) {
                    return (bool)$value;
                },
            ],
            [
                ['rememberMe'],
                'safe',
            ],
        ];
    }

    /**
     * Определение наименования атрибутов.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return array_merge_recursive(parent::attributeLabels(), [
            'login'    => Yii::t('User.LoginForm', 'login', 'Логин'),
            'password' => Yii::t('User.LoginForm', 'password', 'Пароль'),
            'captcha'  => Yii::t('User.LoginForm', 'secure', 'Защита от перебора'),
        ]);
    }

    /**
     * Проверка пароля через валидацию формы.
     *
     * @param string $attribute Имя проверяемого свойства.
     *
     * @throws InvalidConfigException   Исключение, если не настроен компонент authenticationService.
     * @throws InvalidParamException    Исключение, если логин или пароль не верны (checkInnerUser).
     * @throws Exception                Исключение, если возникла ошибка при запросе к БД.
     * @throws RuntimeException         Исключение, если адаптер вернул неверный результат аутентификации.
     *
     * @return void
     */
    public function validatePassword($attribute)
    {
        /* @var AuthenticationComponent $authService */
        $authService = Yii::$app->authenticationService;
        $result      = $authService->setCredential($this->password)->setIdentity($this->login)->authenticate();

        if ($result->isValid()) {
            $this->cachedUser = $result->getIdentity();
        } else {
            $this->addError($attribute, 'Логин и/или пароль не верны.');
            try {
                $this->badLoginEvent();
            } catch (DBException $e) {
                $this->restoreCaptchaTable();
                $this->badLoginEvent();
            }
        }
    }

    /**
     * Инициация процесса аутентификации.
     *
     * @throws InvalidParamException неизвестный сценарий в validate.
     *
     * @return boolean
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? $this->rememberTerm : 0);
        }

        return false;
    }

    /**
     * Болванка хрен значет для чего...
     *
     * @return mixed
     */
    protected function getUser()
    {
        if (null === $this->cachedUser) {
            $this->cachedUser = Yii::$app->userAuth->getByLogin($this->login);
        }

        return $this->cachedUser;
    }

    /**
     * Создает базу данных и таблицу для captcha если её еще нет или удалена.
     *
     * @throws NotSupportedException Исключение, если драйвер не поддерживает данный тип.
     * @throws DBException           Исключение при создании таблицы в БД.
     *
     * @return void
     */
    protected function restoreCaptchaTable()
    {
        $captchaConfig = $this->getCaptchaConfig();

        if (! $captchaConfig['restoreDB']) {
            return;
        }

        $db = $this->getCaptchaDB();

        if (null === $db->schema->getTableSchema($captchaConfig['tableName'])) {
            $db->createCommand()->createTable($captchaConfig['tableName'], [
                'id'   => $db->getSchema()->createColumnSchemaBuilder(Schema::TYPE_PK),
                'ip'   => $db->getSchema()->createColumnSchemaBuilder(Schema::TYPE_INTEGER)->unsigned(),
                'time' => $db->getSchema()->createColumnSchemaBuilder(Schema::TYPE_INTEGER),
                'user' => $db->getSchema()->createColumnSchemaBuilder(Schema::TYPE_STRING, 50),
            ])->execute();
        }
    }

    /**
     * Добавляет в базу запись о неудачной попытке авторизации.
     *
     * @throws DBException исключение при добавлении записи.
     *
     * @return void
     */
    protected function badLoginEvent()
    {
        $captchaConfig = $this->getCaptchaConfig();

        if (! $captchaConfig['enable']) {
            return;
        }

        $command = $this->getQueryObject()->createCommand($this->getCaptchaDB());

        $command->insert($captchaConfig['tableName'], [
            'ip'   => $this->getIP(),
            'user' => $this->login,
            'time' => DateHelper::create()->getTimestamp(),
        ])->execute();

        // Если в базе ошибка - до сюда не дойдет
        if (null !== $this->loginTriesCount) {
            $this->loginTriesCount ++;
        }
    }

    /**
     * Делает запрос к базе и устанавливает количество попыток не удачной авторизации в loginTriesCount.
     *
     * @throws DBException              Исключение работы капчи.
     * @throws InvalidConfigException   Исключение работы капчи.
     *
     * @return void
     */
    protected function queryLoginTriesCount()
    {
        $captchaConfig = $this->getCaptchaConfig();

        $this->loginTriesCount = $this->getQueryObject()->select('*')->from($captchaConfig['tableName']);
        $this->loginTriesCount = $this->loginTriesCount->where(['ip' => $this->getIP()])->andWhere('time >= :framedTime', [
            'framedTime' => DateHelper::create()->getTimestamp() - $captchaConfig['timeFrame'],
        ])->count('*', $this->getCaptchaDB());
    }

    /**
     * Возвращает истину если необходимо поместить капчу на форму.
     *
     * @return boolean
     */
    public function isRequireCaptcha()
    {
        $captchaConfig = $this->getCaptchaConfig();

        if (! $captchaConfig['enable']) {
            return false;
        }

        if (null === $this->loginTriesCount) {
            try {
                $this->queryLoginTriesCount();
            } catch (DBException $e) {
                $this->restoreCaptchaTable();
                $this->loginTriesCount = 0;
            }
        }
        return $this->loginTriesCount >= $captchaConfig['failsNumber'];
    }

    /**
     * Возвращет подключение к базе из настроек капчи.
     *
     * @throws DBException              Исключение работы капчи.
     * @throws InvalidConfigException   Исключение неправильной настройки базы для капчи.
     *
     * @return Connection
     */
    protected function getCaptchaDB()
    {
        if (null !== $this->captchaDB) {
            return $this->captchaDB;
        }

        $this->captchaDB = Yii::$app->get($this->getCaptchaConfig('db'));
        $this->captchaDB->open();

        return $this->captchaDB;
    }

    /**
     * Метод задает IP адрес клиента.
     *
     * @param string $ip Значение для установки.
     *
     * @return static
     */
    public function setIp($ip)
    {
        $this->ip = ip2long($ip);
        return $this;
    }

    /**
     * Возвращает IP адрес клиента в виде числа int.
     *
     * @return integer
     */
    protected function getIP()
    {
        return $this->ip;
    }

    /**
     * Возвращает настройки капчи по ключу.
     *
     * @param string $name Имя ключа настроек.
     *
     * @return array|string
     */
    public function getCaptchaConfig($name = null)
    {
        /* @var UserComponent $component */
        $component = Yii::$app->userBase;
        $config    = $component->getCaptchaConfig();

        return $name ? $config[$name] : $config;
    }
}
