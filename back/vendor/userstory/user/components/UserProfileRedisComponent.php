<?php

namespace Userstory\User\components;

use Userstory\User\exceptions\UserProfileException;
use Userstory\User\interfaces\UserInterface;
use Userstory\User\interfaces\UserProfileCacheInterface;
use yii;
use yii\base\Component;
use yii\redis\Cache;

/**
 * Класс UserProfileMemcachedCache.
 * Кэш профилей пользователя в мемкэше.
 *
 * @package Userstory\User\components
 */
class UserProfileRedisComponent extends Component implements UserProfileCacheInterface
{
    const ONLINE_STATUS_CACHE_SALT     = 'user_online';
    const ID_PROFILE_CACHE_SALT        = 'id_prf';
    const USER_NAME_PROFILE_CACHE_SALT = 'usr_name_prf';
    const PHONE_PROFILE_CACHE_SALT     = 'phone_prf';
    const EMAIL_PROFILE_CACHE_SALT     = 'email_prf';
    const MULTI_COMMAND_KEY            = 'MULTI';
    const EXEC_COMMAND_KEY             = 'EXEC';

    /**
     * Длительность статуса онлайн.
     *
     * @var integer
     */
    protected $onlineDuration = 450;

    /**
     * Компонент, через который кладем или получаем данные.
     *
     * @var Cache|null
     */
    protected $cache;

    /**
     * Параметр, определяющий обязательность кэширования.
     *
     * @var boolean
     */
    protected $required = false;

    /**
     * Метод устанавливает значение параметра required.
     *
     * @param boolean $required Параметр, определяющий обязательность кэширования.
     *
     * @return void
     */
    public function setRequired($required)
    {
        $this->required = $required;
    }

    /**
     * Устанавливаем значение атрибуту.
     *
     * @param integer $val время в секундах.
     *
     * @return void
     */
    public function setOnlineDuration($val)
    {
        $this->onlineDuration = $val;
    }

    /**
     * Метод получает компонент, через который работаем с подсистемой кеша.
     *
     * @return Cache | null
     *
     * @throws UserProfileException Исключение генерируется в случае, если компонент кеша работает не через мемкеш.
     */
    protected function getCache()
    {
        if (null !== $this->cache) {
            return $this->cache;
        }
        if (! Yii::$app->cache || ! Yii::$app->cache instanceof Cache) {
            if ($this->required) {
                throw new UserProfileException('Yii::$app->cache must be instance of yii\caching\Cache');
            }
            return null;
        }
        $this->cache = Yii::$app->cache;
        return $this->cache;
    }

    /**
     * Метод получает профиль пользователя по его ИД.
     *
     * @param integer $profileId ИД интересующего профиля пользователя.
     *
     * @return UserInterface
     *
     * @throws UserProfileException Исключение генерируется в случае, если компонент кеша работает не через мемкеш.
     */
    public function getById($profileId)
    {
        if (null === ($cache = $this->getCache())) {
            return null;
        }
        $result = $cache->get(static::ID_PROFILE_CACHE_SALT . $profileId);
        if (! $result || ! $result instanceof UserInterface) {
            return null;
        }
        return $result;
    }

    /**
     * Метод получает список профилей пользователя по списку ИД.
     *
     * @param array $profileIdList Список ИД интересующих профилей пользователя.
     *
     * @return UserInterface[]
     *
     * @throws UserProfileException Исключение генерируется в случае, если компонент кеша работает не через мемкеш.
     */
    public function getByIdList(array $profileIdList)
    {
        if (null === ($cache = $this->getCache())) {
            return [];
        }
        foreach ($profileIdList as &$profileId) {
            $profileId = static::ID_PROFILE_CACHE_SALT . $profileId;
        }
        unset($profileId);
        $profileListFromCache = $cache->multiGet($profileIdList);
        if (! $profileListFromCache || ! is_array($profileListFromCache)) {
            return [];
        }
        $result = [];
        foreach ($profileListFromCache as $profile) {
            if ($profile instanceof UserInterface) {
                $result[$profile->id] = $profile;
            }
        }
        return $result;
    }

    /**
     * Метод получает профиль пользователя по его юзернейму.
     *
     * @param string $userName Юзернейм интересующего профиля пользователя.
     *
     * @return UserInterface
     */
    public function getByUserName($userName)
    {
        if (null === ($cache = $this->getCache())) {
            return null;
        }
        $profileId = $cache->get(static::USER_NAME_PROFILE_CACHE_SALT . $userName);
        return $this->getById($profileId);
    }

    /**
     * Метод получает профиль пользователя по его емейлу.
     *
     * @param string $email Емейл интересующего профиля пользователя.
     *
     * @return UserInterface
     */
    public function getByEmail($email)
    {
        if (null === ($cache = $this->getCache())) {
            return null;
        }
        $profileId = $cache->get(static::EMAIL_PROFILE_CACHE_SALT . $email);
        return $this->getById($profileId);
    }

    /**
     * Метод получает профиль пользователя по его телефону.
     *
     * @param string $phone Телефон интересующего профиля пользователя.
     *
     * @return UserInterface
     */
    public function getByPhone($phone)
    {
        if (null === ($cache = $this->getCache())) {
            return null;
        }
        $profileId = $cache->get(static::PHONE_PROFILE_CACHE_SALT . $phone);
        return $this->getById($profileId);
    }

    /**
     * Метод кладет профиль пользователя в кеш.
     *
     * @param UserInterface $userProfile Профиль пользователя, который нужно положить в кеш.
     *
     * @return boolean
     *
     * @throws UserProfileException Исключение генерируется в случае, если компонент кеша работает не через мемкеш.
     */
    public function set(UserInterface $userProfile)
    {
        if (null === ($cache = $this->getCache())) {
            return false;
        }
        Yii::$app->redis->executeCommand(static::MULTI_COMMAND_KEY);
        $cache->set(static::ID_PROFILE_CACHE_SALT . $userProfile->id, $userProfile);
        $cache->set(static::EMAIL_PROFILE_CACHE_SALT . $userProfile->getEmail(), $userProfile->id);
        if (null !== $userProfile->getPhone()) {
            $cache->set(static::PHONE_PROFILE_CACHE_SALT . $userProfile->getPhone(), $userProfile->id);
        }
        return ! in_array(false, Yii::$app->redis->executeCommand(static::EXEC_COMMAND_KEY), true);
    }

    /**
     * Метод кладет список профилей пользователя в кеш.
     *
     * @param UserInterface[] $userProfileList Список профилей пользователя, который нужно положить в кеш.
     *
     * @return boolean
     *
     * @throws UserProfileException Исключение генерируется в случае, если компонент кеша работает не через мемкеш.
     */
    public function multiSet(array $userProfileList)
    {
        if (null === ($cache = $this->getCache())) {
            return false;
        }
        $profilesForCaching       = [];
        $profilesEmailForCaching  = [];
        $profileUsrNameForCaching = [];
        $profilesPhoneForCaching  = [];
        foreach ($userProfileList as $profile) {
            if (! $profile instanceof UserInterface) {
                continue;
            }
            $profilesForCaching[static::ID_PROFILE_CACHE_SALT . $profile->id]                 = $profile;
            $profilesEmailForCaching[static::EMAIL_PROFILE_CACHE_SALT . $profile->getEmail()] = $profile->id;
            if (null !== $profile->getUserName()) {
                $profileUsrNameForCaching[static::USER_NAME_PROFILE_CACHE_SALT . $profile->getUserName()] = $profile->id;
            }
            if (null !== $profile->getPhone()) {
                $profilesPhoneForCaching[static::PHONE_PROFILE_CACHE_SALT . $profile->getPhone()] = $profile->id;
            }
        }
        Yii::$app->redis->executeCommand(static::MULTI_COMMAND_KEY);
        $cache->multiSet($profilesForCaching);
        $cache->multiSet($profilesEmailForCaching);
        $cache->multiSet($profileUsrNameForCaching);
        $cache->multiSet($profilesPhoneForCaching);
        return ! in_array(false, Yii::$app->redis->executeCommand(static::EXEC_COMMAND_KEY), true);
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
        if (null === ($cache = $this->getCache())) {
            return;
        }
        $cache->set(static::ONLINE_STATUS_CACHE_SALT . $profileId, true, $this->onlineDuration);
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
        if (null === ($cache = $this->getCache())) {
            return false;
        }
        return (bool)$cache->get(static::ONLINE_STATUS_CACHE_SALT . $profileId);
    }
}
