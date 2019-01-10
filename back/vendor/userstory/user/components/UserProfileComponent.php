<?php

namespace Userstory\User\components;

use Userstory\ComponentBase\traits\MultipleHandlersTrait;
use Userstory\ComponentHelpers\helpers\FileHelper;
use Userstory\User\entities\UserAuthActiveRecord;
use Userstory\User\exceptions\UserProfileException;
use Userstory\User\interfaces\UserInterface;
use Userstory\User\models\ProfileByIdListGetterModel;
use Userstory\User\models\ProfileGetterModel;
use Userstory\User\models\ProfileSaverModel;
use yii;
use yii\base\Component;
use yii\base\Event;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;

/**
 * Компонент профиля пользователя.
 *
 * @package Userstory\User\components
 */
class UserProfileComponent extends Component
{
    use MultipleHandlersTrait;

    const EVENT_AFTER_PROFILE_CREATE      = 'after_profile_create';
    const EVENT_AFTER_SELF_PROFILE_UPDATE = 'after_self_profile_update';

    const PROFILE_SAVER_MODEL_KEY    = 'profileSaverModel';
    const PROFILE_SETTINGS_MODEL_KEY = 'userProfileSettingsModel';
    const AUTH_MODEL_KEY             = 'userAuthModel';
    const PROFILE_MODEL_KEY          = 'userProfileModel';
    const PROFILE_SETTINGS_QUERY_KEY = 'userProfileSettingsQuery';
    const AUTH_QUERY_KEY             = 'userAuthQuery';
    const USER_PROFILE_QUERY_KEY     = 'userProfileQuery';

    /**
     * Массив с конфигурациями моделей профиля и авторизации.
     *
     * @var array
     */
    protected $validateRules = [];

    /**
     * Все ошибки после валидации моделей.
     *
     * @var array
     */
    protected $errors = [];

    /**
     * Список моделей, с которыми работает текущий компонент.
     *
     * @var array
     */
    protected $modelClasses = [];

    /**
     * Возвращаем значение атрибута.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Устанавливаем значение для атрибута.
     *
     * @param array $value значение для атрибута.
     *
     * @return static
     */
    public function setModelClasses(array $value)
    {
        $this->modelClasses = $value;
        return $this;
    }

    /**
     * Получаем объект модели профиля пользователя.
     *
     * @return mixed
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    protected function getProfileModel()
    {
        return Yii::createObject($this->modelClasses[self::PROFILE_MODEL_KEY]);
    }

    /**
     * Получаем объект модели авторизации пользователя.
     *
     * @return mixed
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    protected function getAuthModel()
    {
        return Yii::createObject($this->modelClasses[self::AUTH_MODEL_KEY]);
    }

    /**
     * Получаем объект модели настроек профиля пользователя.
     *
     * @return mixed
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    protected function getProfileSettingsModel()
    {
        return Yii::createObject($this->modelClasses[self::PROFILE_SETTINGS_MODEL_KEY]);
    }

    /**
     * Получаем объект построителя запросов для модели профиля пользователя.
     *
     * @return mixed
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-запроса.
     */
    protected function getUserProfileQuery()
    {
        return Yii::createObject($this->modelClasses[self::USER_PROFILE_QUERY_KEY], [$this->modelClasses[self::PROFILE_MODEL_KEY]]);
    }

    /**
     * Получаем объект построителя запросов для модели авторизации пользователя.
     *
     * @return mixed
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-запроса.
     */
    protected function getUserAuthQuery()
    {
        return Yii::createObject($this->modelClasses[self::AUTH_QUERY_KEY], [$this->modelClasses[self::AUTH_MODEL_KEY]]);
    }

    /**
     * Получаем объект построителя запросов для модели настроек профиля пользователя.
     *
     * @return mixed
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-запроса.
     */
    protected function getUserProfileSettingsQuery()
    {
        return Yii::createObject($this->modelClasses[self::PROFILE_SETTINGS_QUERY_KEY], [$this->modelClasses[self::PROFILE_SETTINGS_MODEL_KEY]]);
    }

    /**
     * Сохраняем в кэше статус онлайна пользователя.
     *
     * @param integer $profileId ид профиля.
     *
     * @return void
     */
    public function setOnline($profileId)
    {
        Yii::$app->userProfileCache->setOnline($profileId);
    }

    /**
     * Проверяем, онлайн ли пользователя.
     *
     * @param integer $profileId ид профиля.
     *
     * @return boolean
     */
    public function isOnline($profileId)
    {
        return Yii::$app->userProfileCache->isOnline($profileId);
    }

    /**
     * Метод находит все существующие профили.
     *
     * @return UserInterface[]
     */
    public function findAll()
    {
        $query = $this->getUserProfileQuery();
        return $query->all();
    }

    /**
     * Находим интересующий профиль пользователя по ID.
     *
     * @param integer $profileId Идентификатор интересующего профиля пользователя.
     * @param boolean $fromDb    получить только из базы.
     *
     * @return UserInterface
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-получателя профилей.
     */
    public function findById($profileId, $fromDb = false)
    {
        /* @var ProfileGetterModel $profileGetter */
        $profileGetter = Yii::createObject([
            'class'            => ProfileGetterModel::class,
            'userProfileQuery' => $this->getUserProfileQuery(),
        ]);

        return $profileGetter->get($profileId, $fromDb);
    }

    /**
     * Находим список интересующих профилей пользователей по списку ID.
     *
     * @param array   $profileIdList Список идентификатор интересующих профилей пользователя.
     * @param boolean $fromDb        получить только из базы.
     *
     * @return UserInterface[]
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-получателя профилей.
     */
    public function findListByIds(array $profileIdList, $fromDb = false)
    {
        /* @var ProfileByIdListGetterModel $profileGetter */
        $profileGetter = Yii::createObject([
            'class'            => ProfileByIdListGetterModel::class,
            'userProfileQuery' => $this->getUserProfileQuery(),
        ]);

        return $profileGetter->get($profileIdList, $fromDb);
    }

    /**
     * Находим интересующий профиль пользователя по UserName.
     *
     * @param string  $userName UserName интересующего профиля пользователя.
     * @param boolean $fromDb   получить только из базы.
     *
     * @return UserInterface
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-запроса.
     */
    public function findByUserName($userName, $fromDb = false)
    {
        /* @var ProfileGetterModel $profileGetter */
        if (! $userName) {
            return null;
        }

        $profileGetter = Yii::createObject([
            'class'            => ProfileGetterModel::class,
            'userProfileQuery' => $this->getUserProfileQuery(),
        ]);

        return $profileGetter->getByUserName(mb_strtolower($userName, 'UTF-8'), $fromDb);
    }

    /**
     * Находим профиль пользователя по почте.
     *
     * @param string  $email  почта пользователя.
     * @param boolean $fromDb получить только из базы.
     *
     * @return UserInterface
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-запроса.
     */
    public function findByEmail($email, $fromDb = false)
    {
        /* @var ProfileGetterModel $profileGetter */
        $profileGetter = Yii::createObject([
            'class'            => ProfileGetterModel::class,
            'userProfileQuery' => $this->getUserProfileQuery(),
        ]);

        return $profileGetter->getByEmail(mb_strtolower($email, 'UTF-8'), $fromDb);
    }

    /**
     * Находим профиль пользователя по номеру телефона.
     *
     * @param string  $phone  номер телефона.
     * @param boolean $fromDb получить только из базы.
     *
     * @return UserInterface
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-запроса.
     */
    public function findByPhone($phone, $fromDb = false)
    {
        /* @var ProfileGetterModel $profileGetter */
        if (! $phone) {
            return null;
        }

        $profileGetter = Yii::createObject([
            'class'            => ProfileGetterModel::class,
            'userProfileQuery' => $this->getUserProfileQuery(),
        ]);

        return $profileGetter->getByPhone($phone, $fromDb);
    }

    /**
     * Метод выполняет создание профиля пользователя.
     *
     * @param array $profileData Данные для создания профиля пользователя.
     *
     * @return null | UserInterface
     * @throws \Exception Исключение генерируется в случае проблемм с транзакциями.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-сохранятеля профилей.
     */
    public function create(array $profileData)
    {
        /* @var ProfileSaverModel $profileSaver */
        $profileSaver = Yii::createObject([
            'class'                => ProfileSaverModel::class,
            'authModel'            => $this->getAuthModel(),
            'profileModel'         => $this->getProfileModel(),
            'profileSettingsModel' => $this->getProfileSettingsModel(),
        ]);

        $profileSaver->on(ProfileSaverModel::EVENT_AFTER_CREATE, [
            $this,
            'profileCreateHandler',
        ]);

        return $this->saveProfile($profileSaver, $profileData);
    }

    /**
     * Метод выполняет обновление текущего профиля пользователя.
     *
     * @param array $profileData Данные для создания профиля пользователя.
     *
     * @return null | UserInterface
     * @throws \Exception Исключение генерируется в случае проблемм с транзакциями.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-сохранятеля профилей.
     */
    public function updateCurrent(array $profileData)
    {
        /* @var ProfileSaverModel $profileSaver */
        /* @var UserAuthActiveRecord $auth */
        $auth = Yii::$app->user->getIdentity();

        if (! $auth) {
            return null;
        }

        $profileSaver = Yii::createObject([
            'class'                => ProfileSaverModel::class,
            'authModel'            => $auth,
            'profileModel'         => $auth->profile,
            'profileSettingsModel' => $auth->profile->additionalProperties,
        ]);

        $profileSaver->on(ProfileSaverModel::EVENT_AFTER_SELF_UPDATE, [
            $this,
            'profileUpdateSelfHandler',
        ]);

        return $this->saveProfile($profileSaver, $profileData);
    }

    /**
     * Метод выполняет действия для созранения профиля пользователя. Если профиля нет в системе - он будет создан.
     *
     * @param ProfileSaverModel $profileSaver Объект сохранятель профиля.
     * @param array             $profileData  Данные для сохранения профиля.
     *
     * @return null | UserInterface
     * @throws \Exception Исключение генерируется в случае проблемм с транзакциями.
     */
    protected function saveProfile(ProfileSaverModel $profileSaver, array $profileData)
    {
        $profileSaver->load($profileData);

        if (null === ($profile = $profileSaver->save())) {
            $this->errors = $profileSaver->getErrors();
            return null;
        }

        if (! $profile instanceof UserInterface) {
            throw new UserProfileException('$profile must be instance of UserInterface');
        }

        return $profile;
    }

    /**
     * Обработчик события создания нового профиля.
     *
     * @param Event $event Объект произошедшего события.
     *
     * @return void
     */
    public function profileCreateHandler(Event $event)
    {
        if (! $event->sender instanceof ProfileSaverModel) {
            $event->handled = true;
            return;
        }

        $event->handled = $this->triggerSaveProfileEvent(self::EVENT_AFTER_PROFILE_CREATE, $event->sender);
    }

    /**
     * Обработчик события изменения текущего профиля.
     *
     * @param Event $event Объект произошедшего события.
     *
     * @return void
     */
    public function profileUpdateSelfHandler(Event $event)
    {
        if (! $event->sender instanceof ProfileSaverModel) {
            $event->handled = true;
            return;
        }

        $event->handled = $this->triggerSaveProfileEvent(self::EVENT_AFTER_SELF_PROFILE_UPDATE, $event->sender);
    }

    /**
     * Метод генерирует события, связанные с изменением профиля.
     *
     * @param string            $eventName    Название события, которое нужно сгенерировать.
     * @param ProfileSaverModel $profileSaver Объект сохранятель профиля.
     *
     * @return boolean
     */
    protected function triggerSaveProfileEvent($eventName, ProfileSaverModel $profileSaver)
    {
        $event         = new Event();
        $event->sender = $profileSaver->getAuthModel();

        $this->trigger($eventName, $event);

        return $event->handled;
    }

    /**
     * Получаем правила валидации атрибутов установленные в конфиге.
     *
     * @param string $className название класса, для которого получаем правила.
     *
     * @return array
     *
     * @throws InvalidParamException Исключение генерируется елси указан неверный алиас к файлу.
     */
    public function getValidateRules($className)
    {
        if (! array_key_exists($className, $this->validateRules)) {
            return [];
        }

        // Если это массив - просто отдаем.
        if (is_array($this->validateRules[$className])) {
            return $this->validateRules[$className];
        }

        // Если файл - подключаем и отдаем правила.
        if (FileHelper::isFile($this->validateRules[$className])) {
            return require Yii::getAlias($this->validateRules[$className]);
        }

        return [];
    }

    /**
     * Устанавливаем значение для атрибута.
     *
     * @param array $val значение для установки.
     *
     * @return static
     */
    public function setValidateRules(array $val)
    {
        $this->validateRules = $val;
        return $this;
    }
}
