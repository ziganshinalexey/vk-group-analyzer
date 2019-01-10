<?php

namespace Userstory\User\helpers;

use Userstory\User\entities\UserProfileActiveRecord;

/**
 * Вспомогательный класс для работы с профилем.
 */
class UserProfileHelper
{
    /**
     * Формирует полное ФИО профиля для отображения.
     *
     * @param UserProfileActiveRecord $profile Объект профиля.
     *
     * @return string
     */
    public static function formatFullName(UserProfileActiveRecord $profile)
    {
        return trim($profile->lastName . ' ' . $profile->firstName . ' ' . $profile->secondName);
    }
}
