<?php

namespace Userstory\User\interfaces;

use Userstory\User\entities\UserAuthActiveRecord;

/**
 * Interface RoleServiceInterface
 * Интерфейс для сервиса получения групп пользователя.
 *
 * @package Userstory\User\interfaces
 */
interface RoleServiceInterface
{
    /**
     * Метод осуществляет поиск групп указанного пользователя.
     *
     * @param UserAuthActiveRecord $user    пользователь, группы которого необходимо получить.
     * @param array                $roleMap предзагруженная карта соответствия ['ldap_member' => [1, 2], 'ldap_staff' => [2, 3],].
     *
     * @return array
     */
    public function getIdentityRoles(UserAuthActiveRecord $user, array $roleMap);
}
