<?php

namespace Userstory\User\interfaces;

use Userstory\User\models\ResultModel;
use Userstory\User\entities\UserAuthActiveRecord;

/**
 * Interface AdapterInterface
 * Интерфейс классов адаптеров для аутентификации.
 *
 * @package Userstory\User\interfaces
 */
interface AdapterInterface
{
    /**
     * Метод производит проверку аутентификации пары identity/credential.
     *
     * @return ResultModel
     */
    public function authenticate();

    /**
     * Метод инициализирует identity.
     *
     * @param string $identity логин пользователя.
     *
     * @return static
     */
    public function setIdentity($identity);

    /**
     * Получение установленного значения identity.
     *
     * @return string
     */
    public function getIdentity();

    /**
     * Метод инициализирует credential.
     *
     * @param string $credential пароль пользователя.
     *
     * @return static
     */
    public function setCredential($credential);

    /**
     * Получение установленного значения credential.
     *
     * @return string
     */
    public function getCredential();

    /**
     * Метод проверяет актуальна ли информация пользователя.
     *
     * @param UserAuthActiveRecord $user проверяемый профиль пользователя.
     *
     * @return boolean
     */
    public function isActual(UserAuthActiveRecord $user);

    /**
     * Метод возвращает наименование адаптера.
     *
     * @return string
     */
    public function getName();
}
