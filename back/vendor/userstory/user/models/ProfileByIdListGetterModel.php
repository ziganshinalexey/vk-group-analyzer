<?php

namespace Userstory\User\models;

use Userstory\User\interfaces\UserInterface;
use Userstory\User\queries\UserProfileQuery;
use yii;
use yii\base\InvalidConfigException;
use yii\base\Model;

/**
 * Класс ProfileByIdListGetterModel.
 * Отвечает за получение списка профилей пользователя по переданному списку ИД.
 *
 * @package Userstory\User\models
 */
class ProfileByIdListGetterModel extends Model
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
     * Метод получает список профилей пользователя по списку ИД.
     *
     * @param array   $profileIdList Список ИД профилей пользователя.
     * @param boolean $fromDb        получить только из базы.
     *
     * @return UserInterface[]
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем получения компонента кеша пользователей.
     */
    public function get(array $profileIdList, $fromDb = false)
    {
        $uncachedProfileIdList = $profileIdList;

        if (! $fromDb) {
            $profileList           = Yii::$app->get('userProfileCache')->getByIdList($profileIdList);
            $uncachedProfileIdList = array_flip(array_diff_key(array_flip($profileIdList), $profileList));
            if (0 === count($uncachedProfileIdList)) {
                return $profileList;
            }
        } else {
            $profileList = [];
        }

        $profileListFromDb = $this->getUserProfileQuery()->byIdList($uncachedProfileIdList)->withSettings()->all();

        if ($profileListFromDb) {
            Yii::$app->get('userProfileCache')->multiSet($profileListFromDb);
            foreach ($profileListFromDb as $profile) {
                $profileList[$profile->id] = $profile;
            }
        }

        return $profileList;
    }
}
