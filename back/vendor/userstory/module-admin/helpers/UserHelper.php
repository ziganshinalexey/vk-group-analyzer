<?php

namespace Userstory\ModuleAdmin\helpers;

use Exception;
use yii;

/**
 * Class UserHelper.
 * Класс хелпера для помощи в работе с пользователями в админке.
 *
 * @package Userstory\ModuleAdmin\helpers
 */
class UserHelper
{
    const DEFAULT_DISPLAY_NAME = 'User';

    /**
     * Метод возвращает имя пользователя для вывода в админке.
     * Если не подключен пакет пользователей - выводится дефолтное имя.
     *
     * @return string
     */
    public static function getDisplayName()
    {
        $user = Yii::$app->user;

        try {
            return $user->identity->profile->getDisplayName();
        } catch (Exception $e) {
            return self::DEFAULT_DISPLAY_NAME;
        }
    }
}
