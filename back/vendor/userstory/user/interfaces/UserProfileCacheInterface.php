<?php

namespace Userstory\User\interfaces;

/**
 * Интерфейс UserProfileCacheInterface.
 * Интерфейс для компонента кеша пользователя.
 *
 * @package Userstory\User\interfaces
 */
interface UserProfileCacheInterface
{
    /**
     * Метод получает профиль пользователя по его ИД.
     *
     * @param integer $profileId ИД интересующего профиля пользователя.
     *
     * @return UserInterface
     */
    public function getById($profileId);

    /**
     * Метод получает список профилей пользователя по списку ИД.
     *
     * @param array $profileIdList Список ИД интересующих профилей пользователя.
     *
     * @return UserInterface[]
     */
    public function getByIdList(array $profileIdList);

    /**
     * Метод получает профиль пользователя по его юзернейму.
     *
     * @param string $userName Юзернейм интересующего профиля пользователя.
     *
     * @return UserInterface
     */
    public function getByUserName($userName);

    /**
     * Метод получает профиль пользователя по его емейлу.
     *
     * @param string $email Емейл интересующего профиля пользователя.
     *
     * @return UserInterface
     */
    public function getByEmail($email);

    /**
     * Метод получает профиль пользователя по его телефону.
     *
     * @param string $phone Телефон интересующего профиля пользователя.
     *
     * @return UserInterface
     */
    public function getByPhone($phone);

    /**
     * Метод кладет профиль пользователя в кеш.
     *
     * @param UserInterface $userProfile Профиль пользователя, который нужно положить в кеш.
     *
     * @return boolean
     */
    public function set(UserInterface $userProfile);

    /**
     * Метод кладет список профилей пользователя в кеш.
     *
     * @param UserInterface[] $userProfileList Список профилей пользователя, который нужно положить в кеш.
     *
     * @return boolean
     */
    public function multiSet(array $userProfileList);

    /**
     * Сохраняем в кэше статус онлайна пользователя.
     *
     * @param integer $profileId ид профиля.
     *
     * @return void
     */
    public function setOnline($profileId);

    /**
     * Проверяем, онлайн ли пользователя.
     *
     * @param integer $profileId ид профиля.
     *
     * @return boolean
     */
    public function isOnline($profileId);
}
