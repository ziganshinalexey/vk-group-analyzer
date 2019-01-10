<?php

namespace Userstory\User\entities;

use Userstory\ComponentBase\traits\ModifierAwareTrait;
use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\User\queries\UserRecoveryQuery;
use yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class UserRecoveryActiveRecord.
 * Модель данных для самостоятельного востановления пароля пользрвателем.
 *
 * @property integer $profileId
 * @property string  $code
 *
 * @package Userstory\User\entities
 */
class UserRecoveryActiveRecord extends ActiveRecord
{
    use ModifierAwareTrait;

    /**
     * Длинна генерируемого кода для емаил, если нет переопределения в конфиге.
     */
    const DEFAULT_LENGTH_CODE_EMAIL = 32;

    /**
     * Длинна генерируемого кода для смс, если нет переопределения в конфиге.
     */
    const DEFAULT_LENGTH_CODE_SMS = 6;

    /**
     * Название таблицы в базе данных.
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%user_recovery}}';
    }

    /**
     * Правила и фильтрация полей перед сохранением.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'profileId',
                    'code',
                ],
                'required',
            ],
            [
                'profileId',
                'integer',
            ],
            [
                'code',
                'string',
            ],
        ];
    }

    /**
     * Генерация кода для восстановления пароля по емаил.
     *
     * @return string
     */
    public static function generateCodeEmail()
    {
        $lengthCode = ArrayHelper::getValue(Yii::$app->params, 'recovery.lengthCodeEmail', self::DEFAULT_LENGTH_CODE_EMAIL);
        return Yii::$app->security->generateRandomString($lengthCode);
    }

    /**
     * Генерация кода для восстановления пароля по телефону.
     *
     * @return string
     */
    public static function generateCodeSms()
    {
        $lengthCode = ArrayHelper::getValue(Yii::$app->params, 'recovery.lengthCodeSms', self::DEFAULT_LENGTH_CODE_SMS);
        return Yii::$app->security->generateRandomString($lengthCode);
    }

    /**
     * Создаём запись о восстановлении пароля.
     *
     * @param integer $profileId индификатор профиля пользователя.
     * @param string  $code      код для восстановления пароля.
     *
     * @return $this
     */
    public static function createRecovery($profileId, $code)
    {
        self::removeOldCode($profileId);

        $model            = new self();
        $model->profileId = $profileId;
        $model->code      = $code;
        $model->save();

        return $model;
    }

    /**
     * Удаление старых попыток восстановления пароля.
     *
     * @param integer $profileId индификатор профиля пользователя.
     *
     * @return integer
     */
    public static function removeOldCode($profileId)
    {
        return self::deleteAll(['profileId' => $profileId]);
    }

    /**
     * Создаём запись о восстановлении пароля через емаил.
     *
     * @param integer $profileId индификатор профиля пользователя.
     *
     * @return UserRecoveryActiveRecord
     */
    public static function createRecoveryEmail($profileId)
    {
        return self::createRecovery($profileId, self::generateCodeEmail());
    }

    /**
     * Создаём запись о восстановлении пароля через смс.
     *
     * @param integer $profileId индификатор профиля пользователя.
     *
     * @return UserRecoveryActiveRecord
     */
    public static function createRecoverySms($profileId)
    {
        return self::createRecovery($profileId, self::generateCodeSms());
    }

    /**
     * Получить значение кода восстановления пароля.
     *
     * @return null|string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Получить индификатор профиля пользователя.
     *
     * @return null|integer
     */
    public function getProfileId()
    {
        return $this->profileId;
    }

    /**
     * Связь с профилем пользователя.
     *
     * @return UserProfileActiveRecord|ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfileActiveRecord::class, ['id' => 'profileId']);
    }

    /**
     * Подключаем к выборке методы.
     *
     * @return UserRecoveryQuery
     */
    public static function find()
    {
        return new UserRecoveryQuery(static::class);
    }
}
