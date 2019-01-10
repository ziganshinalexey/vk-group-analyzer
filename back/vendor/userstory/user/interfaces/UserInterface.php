<?php

namespace Userstory\User\interfaces;

/**
 * Interface UserInterface
 * Интерфейс учетной записи.
 *
 * @SWG\Definition(
 *     type="object",
 *     definition="UserProfile",
 *     @SWG\Property(
 *          property="id",
 *          description="ИД профиля пользователя",
 *          type="string",
 *     ),
 *     @SWG\Property(
 *          property="firstName",
 *          description="Имя",
 *          type="string",
 *     ),
 *     @SWG\Property(
 *          property="lastName",
 *          description="Фамилия",
 *          type="string",
 *     ),
 *     @SWG\Property(
 *          property="secondName",
 *          description="Отчество",
 *          type="string",
 *     ),
 *     @SWG\Property(
 *          property="username",
 *          description="Юзернейм",
 *          type="string",
 *     ),
 *     @SWG\Property(
 *          property="email",
 *          description="Email",
 *          type="string",
 *     ),
 *     @SWG\Property(
 *          property="password",
 *          description="Пароль",
 *          type="string",
 *     ),
 *     @SWG\Property(
 *          property="confirmPassword",
 *          description="Пароль",
 *          type="string",
 *     ),
 *     @SWG\Property(
 *          property="phone",
 *          description="Телефон",
 *          type="string",
 *     ),
 *     @SWG\Items(),
 * )
 *
 * @package Userstory\User\interfaces
 */
interface UserInterface
{
    /**
     * Возвращает ИД пользователя.
     *
     * @return integer
     */
    public function getId();

    /**
     * Возвращает логин пользователя.
     *
     * @return string
     */
    public function getLogin();

    /**
     * Метод возвращает имя пользователя.
     *
     * @return string
     */
    public function getFirstName();

    /**
     * Возвращает фамилию пользователя.
     *
     * @return string
     */
    public function getLastName();

    /**
     * Возвращает отчество пользователя.
     *
     * @return string
     */
    public function getSecondName();

    /**
     * Возвращает адрес электронной почты.
     *
     * @return string
     */
    public function getEmail();

    /**
     * Метод возвращает номер телефона.
     *
     * @return integer
     */
    public function getPhone();

    /**
     * Метод возвращает пользовательское имя.
     *
     * @return string
     */
    public function getUserName();

    /**
     * Метод возвращает истину, если профиль активен.
     *
     * @return boolean
     */
    public function isActive();
}
