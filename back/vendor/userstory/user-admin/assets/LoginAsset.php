<?php

namespace Userstory\UserAdmin\assets;

use Userstory\ModuleAdmin\assets\AdminLteAsset;
use yii\web\AssetBundle;

/**
 * Класс пакета отображения админки (алрма логина).
 *
 * AdminLte AssetBundle
 */
class LoginAsset extends AssetBundle
{
    /**
     * Метод для предварительной инициализации объекта.
     *
     * @return void
     */
    public function init()
    {
        $this->sourcePath = '@vendor/userstory/user-admin/www/login';
        $this->css        = ['css/login.min.css'];
        $this->js         = ['js/login.min.js'];
        $this->depends    = [AdminLteAsset::class];

        parent::init();
    }
}
