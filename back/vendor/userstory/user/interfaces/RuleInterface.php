<?php

namespace Userstory\User\interfaces;

/**
 * Interface RuleInterface
 * Интерфейс класса для реализации методов проверки полномочий у пользователя.
 *
 * @package Userstory\User\interfaces
 */
interface RuleInterface
{
    /**
     * Метод проверяет обладает ли пользователь полномочием относительно указанного контекста.
     *
     * @param integer $profileId  идентификатор профиля пользователя.
     * @param string  $permission проверяемое полномочие.
     * @param mixed   $context    контекст, относительно которого проверяет полномочие.
     *
     * @return boolean
     */
    public function isGranted($profileId, $permission, $context = null);

    /**
     * Метод возвращает список проверяемых полномочий.
     *
     * @return string
     */
    public function getPermissionList();

    /**
     * Метод устанавливает список проверяемых полномочий.
     *
     * @param string|array $permissionList список полномочий.
     *
     * @return static
     */
    public function setPermissionList($permissionList);
}
