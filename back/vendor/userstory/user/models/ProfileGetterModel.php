<?php

namespace Userstory\User\models;

use Userstory\User\interfaces\UserInterface;
use Userstory\User\queries\UserProfileQuery;
use yii;
use yii\base\InvalidConfigException;
use yii\base\Model;

/**
 * Класс ProfileGetterModel.
 * Отвечает за получение профиля по ИД.
 *
 * @package Userstory\User\models
 */
class ProfileGetterModel extends Model
{
    /**
     * Объект запроса для профиля пользователя.
     *
     * @var UserProfileQuery|null
     */
    protected $userProfileQuery;

    /**
     * Метод возвращает объект запроса для профиля пользователя.
     *
     * @return UserProfileQuery
     */
    public function getUserProfileQuery()
    {
        return $this->userProfileQuery;
    }

    /**
     * Метод устанавливает объект запроса для профиля пользователя.
     *
     * @param mixed $userProfileQuery Новое значение.
     *
     * @return static
     */
    public function setUserProfileQuery($userProfileQuery)
    {
        $this->userProfileQuery = $userProfileQuery;
        return $this;
    }

    /**
     * Метод получает профиль пользователя по его ИД.
     *
     * @param integer $profileId ИД профиля пользователя.
     * @param boolean $fromDb    получить только из базы.
     *
     * @return UserInterface
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем получения компонента кеша пользователей.
     */
    public function get($profileId, $fromDb = false)
    {
        if (! $fromDb) {
            $profileFromCache = Yii::$app->get('userProfileCache')->getById($profileId);
            if ($profileFromCache) {
                return $profileFromCache;
            }
        }

        /* @var UserInterface $result */
        $result = $this->getUserProfileQuery()->byId($profileId)->withSettings()->one();

        if ($result) {
            Yii::$app->get('userProfileCache')->set($result);
        }

        return $result;
    }

    /**
     * Метод получает профиль пользователя по его userName.
     *
     * @param string  $profileUserName Содержит userName профиля пользователя.
     * @param boolean $fromDb          получить только из базы.
     *
     * @return UserInterface
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем получения компонента кеша пользователей.
     */
    public function getByUserName($profileUserName, $fromDb = false)
    {
        if (! $fromDb) {
            $profileFromCache = Yii::$app->get('userProfileCache')->getByUserName($profileUserName);
            if ($profileFromCache) {
                return $profileFromCache;
            }
        }

        /* @var UserInterface $result */
        $result = $this->getUserProfileQuery()->byUserName($profileUserName)->withSettings()->one();

        if ($result) {
            Yii::$app->get('userProfileCache')->set($result);
        }

        return $result;
    }

    /**
     * Метод получает профиль пользователя по его email.
     *
     * @param string  $profileEmail Содержит email профиля пользователя.
     * @param boolean $fromDb       получить только из базы.
     *
     * @return UserInterface
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем получения компонента кеша пользователей.
     */
    public function getByEmail($profileEmail, $fromDb = false)
    {
        if (! $fromDb) {
            $profileFromCache = Yii::$app->get('userProfileCache')->getByEmail($profileEmail);
            if ($profileFromCache) {
                return $profileFromCache;
            }
        }

        /* @var UserInterface $result */
        $result = $this->getUserProfileQuery()->byEmail($profileEmail)->withSettings()->one();

        if ($result) {
            Yii::$app->get('userProfileCache')->set($result);
        }

        return $result;
    }

    /**
     * Метод получает профиль пользователя по его phone.
     *
     * @param string  $profilePhone Содержит phone профиля пользователя.
     * @param boolean $fromDb       получить только из базы.
     *
     * @return UserInterface
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем получения компонента кеша пользователей.
     */
    public function getByPhone($profilePhone, $fromDb = false)
    {
        if (! $fromDb) {
            $profileFromCache = Yii::$app->get('userProfileCache')->getByPhone($profilePhone);
            if ($profileFromCache) {
                return $profileFromCache;
            }
        }

        /* @var UserInterface $result */
        $result = $this->getUserProfileQuery()->byPhone($profilePhone)->withSettings()->one();

        if ($result) {
            Yii::$app->get('userProfileCache')->set($result);
        }

        return $result;
    }
}
