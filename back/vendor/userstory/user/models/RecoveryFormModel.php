<?php

namespace Userstory\User\models;

use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\User\entities\UserAuthActiveRecord;
use Userstory\User\entities\UserProfileActiveRecord;
use Userstory\User\entities\UserRecoveryActiveRecord;
use yii;
use yii\base\InvalidParamException;
use yii\db\Exception;

/**
 * Класс формы восстановления пароля.
 * телефон в формате E.164.
 *
 * @property integer $recoverySend
 * @property string  $recoveryCode
 * @property integer $typeVerificationEmail
 * @property integer $typeVerificationSms
 *
 * @package Userstory\User\models
 */
class RecoveryFormModel extends AuthFormModel
{
    /**
     * Сценарий обработки формы ввода логина, емайла или номера телефона.
     */
    const SCENARIO_ENTER = 'scenario_enter';

    /**
     * Сценарий обработки формы смены пароля.
     */
    const SCENARIO_CHANGE = 'scenario_change';

    /**
     * Тип верификиции по емайл. Переопределяется, если подключен модуль verification.
     *
     * @var integer
     */
    protected $typeVerificationEmail = 1;

    /**
     * Тип верификиции по смс. Переопределяется, если подключен модуль verification.
     *
     * @var integer
     */
    protected $typeVerificationSms = 2;

    /**
     * Тип отправки емайл или смс.
     *
     * @var null|integer
     */
    protected $recoverySend;

    /**
     * Код для восстановления пароля.
     *
     * @var null|string
     */
    protected $recoveryCode;

    /**
     * Заголовок письма, отсылаемое при восстановлении пароля.
     *
     * @var null|string
     */
    protected $subjectEmail;

    /**
     * Шаблон письма, отсылаемое при восстановлении, формат HTML.
     *
     * @var null|string
     */
    protected $confirmEmailBodyHtml;

    /**
     * Шаблон письма, отсылаемое при восстановлении пароля, формат TEXT.
     *
     * @var null|string
     */
    protected $confirmEmailBodyText;

    /**
     * URL адрес на который необходимо зайти пользователю для смены пароля.
     *
     * @var null|string
     */
    protected $confirmEmailURL;

    /**
     * Пользователь для которого восстанавливаем пароль.
     *
     * @var null|UserAuthActiveRecord
     */
    protected $user;

    /**
     * Метод возвращает тип верификиции по емайл.
     *
     * @return integer
     */
    public function getTypeVerificationEmail()
    {
        return $this->typeVerificationEmail;
    }

    /**
     * Метод задает тип верификиции по емайл.
     *
     * @param integer $typeVerificationEmail Значение для установки.
     *
     * @return static
     */
    public function setTypeVerificationEmail($typeVerificationEmail)
    {
        $this->typeVerificationEmail = $typeVerificationEmail;
        return $this;
    }

    /**
     * Метод возвращает тип верификиции по смс.
     *
     * @return integer
     */
    public function getTypeVerificationSms()
    {
        return $this->typeVerificationSms;
    }

    /**
     * Метод задает тип верификиции по смс.
     *
     * @param integer $typeVerificationSms Значение для установки.
     *
     * @return static
     */
    public function setTypeVerificationSms($typeVerificationSms)
    {
        $this->typeVerificationSms = $typeVerificationSms;
        return $this;
    }

    /**
     * Указать Тип отправки емайл или смс.
     *
     * @return integer|null
     */
    public function getRecoverySend()
    {
        return $this->recoverySend;
    }

    /**
     * Получить Тип отправки емайл или смс.
     *
     * @param integer $value новое значение.
     *
     * @return static
     */
    public function setRecoverySend($value)
    {
        $this->recoverySend = $value;
        return $this;
    }

    /**
     * Инициализируем необходимые атрибуты.
     *
     * @return void
     */
    public function init()
    {
        parent::init();

        if (array_key_exists('verification', Yii::$app->components)) {
            $verification                = Yii::$app->components['verification']['class'];
            $userVerification            = $verification::$userVerificationClass;
            $this->typeVerificationEmail = $userVerification::TYPE_VERIFICATION_EMAIL;
            $this->typeVerificationSms   = $userVerification::TYPE_VERIFICATION_SMS;
        }
    }

    /**
     * Указать пользователя который восстанавливает пароль.
     *
     * @return null|UserAuthActiveRecord
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Получить пользователя который восстанавливает пароль.
     *
     * @param string $value новое значение.
     *
     * @return static
     */
    public function setUser($value)
    {
        $this->user = $value;
        return $this;
    }

    /**
     * Получить URL адрес на который необходимо зайти пользователю для смены пароля.
     *
     * @return string
     *
     * @throws InvalidParamException если Yii::$app->params не является массивом.
     */
    public function getConfirmEmailURL()
    {
        return ! empty($this->confirmEmailURL) ? $this->confirmEmailURL : ArrayHelper::getValue(Yii::$app->params, 'recovery.confirmEmailURL');
    }

    /**
     * Указать URL адрес на который необходимо зайти пользователю для смены пароля.
     *
     * @param string $value новое значение.
     *
     * @return static
     */
    public function setConfirmEmailURL($value)
    {
        $this->confirmEmailURL = $value;
        return $this;
    }

    /**
     * Получить Шаблон письма, формат TEXT.
     *
     * @return string
     *
     * @throws InvalidParamException если Yii::$app->params не является массивом.
     */
    public function getConfirmEmailBodyText()
    {
        if (empty($this->confirmEmailBodyText)) {
            $this->confirmEmailBodyText = ArrayHelper::getValue(Yii::$app->params, 'recovery.confirmEmailBodyText');
        }

        return $this->confirmEmailBodyText;
    }

    /**
     * Указать Шаблон письма, формат TEXT.
     *
     * @param string $value новое значение.
     *
     * @return static
     */
    public function setConfirmEmailBodyText($value)
    {
        $this->confirmEmailBodyText = $value;
        return $this;
    }

    /**
     * Получить Шаблон письма, формат HTML.
     *
     * @return string
     *
     * @throws InvalidParamException если Yii::$app->params не является массивом.
     */
    public function getConfirmEmailBodyHtml()
    {
        if (empty($this->confirmEmailBodyHtml)) {
            $this->confirmEmailBodyHtml = ArrayHelper::getValue(Yii::$app->params, 'recovery.confirmEmailBodyHtml');
        }

        return $this->confirmEmailBodyHtml;
    }

    /**
     * Указать Шаблон письма, формат HTML.
     *
     * @param string $value новое значение.
     *
     * @return static
     */
    public function setConfirmEmailBodyHtml($value)
    {
        $this->confirmEmailBodyHtml = $value;
        return $this;
    }

    /**
     * Получить Заголовок письма.
     *
     * @return string
     *
     * @throws InvalidParamException если Yii::$app->params не является массивом.
     */
    public function getSubjectEmail()
    {
        return ! empty($this->subjectEmail) ? $this->subjectEmail : ArrayHelper::getValue(Yii::$app->params, 'recovery.subjectEmail');
    }

    /**
     * Указать Заголовок письма.
     *
     * @param string $value новое значение.
     *
     * @return static
     */
    public function setSubjectEmail($value)
    {
        $this->subjectEmail = $value;
        return $this;
    }

    /**
     * Получить Код для восстановления пароля.
     *
     * @return null|string
     */
    public function getRecoveryCode()
    {
        return $this->recoveryCode;
    }

    /**
     * Указать Код для восстановления пароля.
     *
     * @param string|mixed $value новое значение.
     *
     * @return static
     */
    public function setRecoveryCode($value)
    {
        $this->recoveryCode = $value;
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
                'login',
                'required',
                'on' => self::SCENARIO_ENTER,
            ],
            [
                ['login'],
                'safe',
                'on' => self::SCENARIO_CHANGE,
            ],
            [
                'recoverySend',
                'filter',
                'filter' => function($value) {
                    return (int)$value ?: null;
                },
                'on'     => self::SCENARIO_CHANGE,
            ],
            [
                'recoveryCode',
                'string',
                'on' => self::SCENARIO_CHANGE,
            ],
            [
                'password',
                'string',
                'min' => 6,
                'max' => 255,
                'on'  => self::SCENARIO_CHANGE,
            ],
            [
                [
                    'password',
                    'passwordConfirm',
                ],
                'required',
                'on' => self::SCENARIO_CHANGE,
            ],
            [
                ['passwordConfirm'],
                'validateEqual',
                'params' => 'password',
                'on'     => self::SCENARIO_CHANGE,
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
        return [
            'login'                               => Yii::t('User.RecoveryForm.Attribute', 'id', 'Логин, email или номер телефона'),
            'password'                            => Yii::t('User.RecoveryForm.Attribute', 'password', 'Новый пароль'),
            'passwordConfirm'                     => Yii::t('User.RecoveryForm.Attribute', 'passwordConfirm', 'Повторите'),
            'recoveryCode'                        => Yii::t('User.RecoveryForm.Attribute', 'recoveryCode', 'Введите код'),
            'type' . $this->typeVerificationSms   => Yii::t('User.RecoveryForm.Attribute', 'typeSms', 'Отправить код на телефон'),
            'type' . $this->typeVerificationEmail => Yii::t('User.RecoveryForm.Attribute', 'typeEmail', 'Отправить код на email'),
        ];
    }

    /**
     * Выбор способа доставки кода для восстановления пароля.
     *
     * @return array|boolean
     *
     * @throws InvalidParamException если Yii::$app->params не является массивом.
     */
    public function option()
    {
        if (null !== $this->recoverySend) {
            $this->send();
            return true;
        }

        /* @var array|boolean $result */
        $result = $this->findLogin();

        if (! $result) {
            $result = $this->findEmail() ?: $this->findPhone();
        }

        if (false === $result) {
            $this->addError('login', 'Пользователь не найден.');
            return false;
        }

        if (empty($result)) {
            $this->addError('login', 'У вас не подтвержден ни email, ни номер телефона. Обратитесь к администратору.');
            return false;
        }

        if (1 < count($result)) {
            return [
                'user' => $this->user,
                'type' => $result,
            ];
        }

        $this->recoverySend = key($result);

        return $this->send();
    }

    /**
     * Поиск логина введенного пользователем.
     *
     * @return array|boolean
     */
    protected function findLogin()
    {
        $user = UserAuthActiveRecord::findOne(['login' => $this->login]);

        if (! $user) {
            return false;
        }

        $this->user = $user;

        // Если модуль verification не подключен :
        if (! array_key_exists('verification', Yii::$app->components)) {
            $type = $this->typeVerificationEmail;
            return [$type => $this->getAttributeLabel('type' . $type)];
        }

        // Иначе ...
        $result        = [];
        $verifications = $user->profile->getVerification()->getRecoveryTypes()->all();

        foreach ((array)$verifications as $verification) {
            if ($verification->isVerified()) {
                $result[$verification->type] = $this->getAttributeLabel('type' . $verification->type);
            }
        }

        return $result;
    }

    /**
     * Поиск емайла введенного пользователем.
     *
     * @return array|boolean
     */
    public function findEmail()
    {
        $profile = Yii::$app->userProfile->findByEmail($this->login);

        if (! $profile || ! $user = $profile->getAuth()->one()) {
            return false;
        }

        /* @var $profile UserProfileActiveRecord */
        $this->user = $user;
        $result     = [];

        // Если модуль verification не подключен :
        if (! array_key_exists('verification', Yii::$app->components)) {
            $type = $this->typeVerificationEmail;
            return [$type => $this->getAttributeLabel('type' . $type)];
        }

        // Иначе ...
        $verification = $profile->getVerification()->getRecoveryTypes()->andWhere(['profileId' => $profile->id]);
        $verification = $verification->andWhere(['type' => $this->typeVerificationEmail])->one();
        if ($verification && $verification->isVerified()) {
            $result[$verification->type] = $this->getAttributeLabel('type' . $verification->type);
        }

        return $result;
    }

    /**
     * Поиск номера телефона введенного пользователем.
     *
     * @return array|boolean
     */
    public function findPhone()
    {
        $phone = preg_replace('/\D+/', '', $this->login);

        if (! preg_match('/^\d+$/', $phone)) {
            return false;
        }

        $profile = UserProfileActiveRecord::findOne(['phone' => $phone]);

        if (! ( $profile && $user = $profile->getAuth()->one() )) {
            return false;
        }

        $this->user = $user;

        // Если модуль verification не подключен :
        if (! array_key_exists('verification', Yii::$app->components)) {
            $type = $this->typeVerificationSms;
            return [$type => $this->getAttributeLabel('type' . $type)];
        }

        // Иначе ...
        $result       = [];
        $verification = $profile->getVerification()->getRecoveryTypes()->andWhere(['profileId' => $profile->id]);
        $verification = $verification->andWhere(['type' => $this->typeVerificationSms])->one();

        if ($verification && $verification->isVerified()) {
            $result[$verification->type] = $this->getAttributeLabel('type' . $verification->type);
        }

        return $result;
    }

    /**
     * Отправка кода пользователю для восстановления пароля.
     *
     * @return boolean
     *
     * @throws InvalidParamException если Yii::$app->params не является массивом.
     */
    public function send()
    {
        if (! $this->user) {
            $this->findLogin();
        }

        if ($this->typeVerificationEmail === (int)$this->recoverySend) {
            if ($this->sendEmail()) {
                return true;
            }
            $this->addError('login', 'Системная ошибка, отправки email.');
        }

        if ($this->typeVerificationSms === (int)$this->recoverySend) {
            if ($this->sendSms()) {
                return true;
            }
            $this->addError('login', 'Системная ошибка, отправки sms.');
        }

        return false;
    }

    /**
     * Отправка кода на емайл пользователю.
     *
     * @throws Exception                Исключение, если не удалось сгенерировать случайную строку.
     * @throws InvalidParamException    Исключение, если Yii::$app->params не является массивом.
     *
     * @return boolean
     */
    protected function sendEmail()
    {
        $recovery           = UserRecoveryActiveRecord::createRecoveryEmail($this->user->profile->id);
        $this->recoverySend = $this->typeVerificationEmail;

        return Yii::$app->mailer->compose([
            'html' => $this->getConfirmEmailBodyHtml(),
            'text' => $this->getConfirmEmailBodyText(),
        ], [
            'profile' => $this->user->profile,
            'hash'    => $recovery->getCode(),
            'url'     => Yii::$app->getUrlManager()->createAbsoluteUrl([$this->getConfirmEmailURL()]),
            'urlHash' => Yii::$app->getUrlManager()->createAbsoluteUrl([
                $this->getConfirmEmailURL(),
                'hash' => $recovery->getCode(),
            ]),
        ])->setSubject($this->getSubjectEmail())->setTo($this->user->profile->getEmail())->send();
    }

    /**
     * Отправка кода на телефон пользователя.
     *
     * @throws Exception Исключение, если не удалось сгенерировать случайную строку.
     *
     * @return boolean
     */
    protected function sendSms()
    {
        $recovery           = UserRecoveryActiveRecord::createRecoverySms($this->user->profile->id);
        $this->recoverySend = $this->typeVerificationSms;
        $message            = sprintf('Ваш персональный код для восстановления пароля - %s', $recovery->getCode());

        return Yii::$app->sms->send($this->user->profile->getPhone(), $message);
    }

    /**
     * Сохранение нового пароля.
     *
     * @return boolean
     *
     * @throws Exception исключение при сохранении.
     * @throws InvalidParamException наследуемое исключение при валидировании модели.
     * @throws Exception ошибка транзакции.
     * @throws Exception неверно сформированный hash пароль.
     */
    public function updatePassword()
    {
        $recovery = UserRecoveryActiveRecord::find()->where(['code' => $this->recoveryCode])->one();

        if (! $recovery) {
            $this->addError('recoveryCode', 'Указан неверный код');
            return false;
        }

        if (! $this->validate()) {
            return false;
        }

        $auth                     = $recovery->getUserProfile()->one()->auth;
        $this->user               = array_shift($auth);
        $this->user->passwordHash = Yii::$app->security->generatePasswordHash($this->password);

        $connection  = Yii::$app->db;
        $transaction = $connection->beginTransaction();

        try {
            $this->user->save(false, ['passwordHash']);
            $recovery->removeOldCode($recovery->getProfileId());
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return true;
    }

    /**
     * Проверка правильности кода из урла.
     *
     * @return boolean
     */
    public function checkEmailRecoveryCode()
    {
        $model = UserRecoveryActiveRecord::findOne(['code' => $this->recoveryCode]);

        if ($model) {
            return true;
        }

        $this->recoveryCode = null;
        $this->addError('recoveryCode', 'Указан неверный код');

        return false;
    }
}
