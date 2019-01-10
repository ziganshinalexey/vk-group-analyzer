<?php

namespace Userstory\User\models;

use Exception;
use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\User\components\UserComponent;
use Userstory\User\entities\UserAuthActiveRecord;
use Userstory\User\entities\UserProfileActiveRecord;
use Userstory\User\entities\UserProfileSettingActiveRecord;
use Userstory\User\interfaces\UserInterface;
use yii;
use yii\base\InvalidConfigException;
use yii\base\Model;

/**
 * Класс ProfileSaverModel.
 * Отвечает за сохранение профиля, настроек профиля и авторизации.
 *
 * @package Userstory\User\models
 */
class ProfileSaverModel extends Model
{
    /**
     * Событае после успешного создания нового пользователя.
     */
    const EVENT_AFTER_CREATE = 'after_create';

    /**
     * Событае после успешного обновления данных пользователя.
     */
    const EVENT_AFTER_SELF_UPDATE = 'after_update';

    /**
     * Модель авторизации для сохранения.
     *
     * @var UserAuthActiveRecord|null
     */
    protected $authModel;

    /**
     * Модель профиля для сохранения.
     *
     * @var UserInterface|null
     */
    protected $profileModel;

    /**
     * Модель настроек профиля для сохранения.
     *
     * @var UserProfileSettingActiveRecord|null
     */
    protected $profileSettingsModel;

    /**
     * Метод возвращает модель авторизации.
     *
     * @return UserAuthActiveRecord
     */
    public function getAuthModel()
    {
        return $this->authModel;
    }

    /**
     * Метод устанаваливает модель авторизации.
     *
     * @param UserAuthActiveRecord $authModel Новое значение.
     *
     * @return static
     */
    public function setAuthModel(UserAuthActiveRecord $authModel)
    {
        $this->authModel = $authModel;
        return $this;
    }

    /**
     * Метод возвращает модель профиля пользователя.
     *
     * @return UserInterface
     */
    public function getProfileModel()
    {
        return $this->profileModel;
    }

    /**
     * Метод устанаваливает модель профиля пользователя.
     *
     * @param UserInterface $profileModel Новое значение.
     *
     * @return static
     */
    public function setProfileModel(UserInterface $profileModel)
    {
        $this->profileModel = $profileModel;
        return $this;
    }

    /**
     * Метод возвращает модель натсроек профиля пользователя.
     *
     * @return UserProfileSettingActiveRecord
     */
    public function getProfileSettingsModel()
    {
        return $this->profileSettingsModel;
    }

    /**
     * Метод устанаваливает модель настроек профиля пользователя.
     *
     * @param UserProfileSettingActiveRecord $profileSettingsModel Новое значение.
     *
     * @return static
     */
    public function setProfileSettingsModel(UserProfileSettingActiveRecord $profileSettingsModel)
    {
        $this->profileSettingsModel = $profileSettingsModel;
        return $this;
    }

    /**
     * Метод выполняет загрузку данных для операции сохранения.
     *
     * @param mixed $data     Данные, которые нужно загрузить.
     * @param mixed $formName Неиспользующийся параметр.
     *
     * @return void
     *
     * @inherit
     *
     * @throws InvalidConfigException Исключение генерируется если пытаемся залодить какой-то кривой класс.
     */
    public function load($data, $formName = null)
    {
        $this->loadAuth($data)->loadProfile($data)->loadProfileSettings($data);
    }

    /**
     * Метод выполняет сохранение профиля.
     *
     * @return null|UserInterface
     *
     * @throws Exception Исключение генерируется в случае проблемм с транзакциями.
     */
    public function save()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            /* @var UserProfileActiveRecord $profile */
            /* @var UserProfileSettingActiveRecord $profileSettings */
            /* @var UserAuthActiveRecord $auth */

            $auth                        = $this->getAuthModel();
            $profile                     = $this->getProfileModel();
            $profileSettings             = $this->getProfileSettingsModel();
            $isInsert                    = $profile->isNewRecord;
            $result                      = $profile->save();
            $auth->profileId             = $profile->id;
            $result                      = $result && $auth->save();
            $profileSettings->relationId = $profile->id;
            $result                      = $result && $profileSettings->save();

            if (! $result) {
                $this->addErrors(ArrayHelper::merge($profile->errors, $auth->errors, $profileSettings->errors));
                $transaction->rollBack();
                return null;
            }

            $triggeredEventName = $isInsert ? self::EVENT_AFTER_CREATE : self::EVENT_AFTER_SELF_UPDATE;
            if (! $this->triggerEventByName($triggeredEventName)) {
                $this->addError('', Yii::t('User.ProfileSaver', 'After save event unexpected error', [
                    'defaultTranslation' => 'Непредвиденная ошибка',
                ]));
                $transaction->rollBack();
                return null;
            }

            $profile = Yii::$app->userProfile->findById($profile->id, true);
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        Yii::$app->get('userProfileCache')->set($profile);

        return $profile;
    }

    /**
     * Метод генерирует события, связанные с сохранением профиля.
     *
     * @param string $eventName Название события, которое нужно сгенерировать.
     *
     * @return boolean
     */
    protected function triggerEventByName($eventName)
    {
        /* @var UserComponent $component */
        $component = Yii::$app->userBase;
        $event     = $component->modelFactory->getEvent();

        $this->trigger($eventName, $event);

        return ! $event->handled;
    }

    /**
     * Загружаем данными модель авторизации.
     *
     * @param array $attributes массив данных с формы.
     *
     * @return static
     *
     * @throws InvalidConfigException Исключение генерируется если пытаемся залодить несуществующий класс авторизации.
     */
    protected function loadAuth(array $attributes)
    {
        if (! $this->getAuthModel()) {
            throw new InvalidConfigException('$this->authModel can not be null');
        }

        if (array_key_exists($this->getAuthModel()->formName(), $attributes) || ! $this->getAuthModel()->load($attributes)) {
            $this->getAuthModel()->setAttributes($attributes);
        }

        return $this;
    }

    /**
     * Загружаем данными модель профиля.
     *
     * @param array $attributes массив данных с формы.
     *
     * @return static
     *
     * @throws InvalidConfigException Исключение генерируется если пытаемся залодить несуществующий класс профиля.
     */
    protected function loadProfile(array $attributes)
    {
        if (! $this->getProfileModel()) {
            throw new InvalidConfigException('$this->profileModel can not be null');
        }

        if (! array_key_exists($this->getProfileModel()->formName(), $attributes) || ! $this->getProfileModel()->load($attributes)) {
            $this->getProfileModel()->setAttributes($attributes);
        }

        return $this;
    }

    /**
     * Загружаем данными модель дополнительных настроек.
     *
     * @param array $attributes массив данных с формы.
     *
     * @return static
     *
     * @throws InvalidConfigException Исключение генерируется если пытаемся залодить несуществующий класс профиль-сеттингсов.
     */
    protected function loadProfileSettings(array $attributes)
    {
        if (! $this->getProfileSettingsModel()) {
            throw new InvalidConfigException('$this->profileSettingsModel can not be null');
        }

        if (! array_key_exists($this->getProfileSettingsModel()->formName(), $attributes) || ! $this->getProfileSettingsModel()->load($attributes)) {
            $this->getProfileSettingsModel()->setAttributes($attributes);
        }

        return $this;
    }
}
