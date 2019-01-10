<?php

namespace Userstory\ModuleAdmin;

use yii\base\Module;

/**
 * Класс модуля админки.
 * Расширяет функционал стандартного класса USModule для нужд администраторского раздела.
 */
class AdminModule extends Module
{
    /**
     * Настройки route для установки адреса аутентификации по умолчанию.
     *
     * @var mixed|null
     */
    public $loginUrl;
}
