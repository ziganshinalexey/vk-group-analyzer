<?php

namespace Userstory\ModuleAdmin\assets;

use yii\base\Exception;
use yii\web\AssetBundle;

/**
 * Класс пакета отображения админки.
 *
 * AdminLte AssetBundle
 *
 * @since 0.1
 */
class AdminLteCSSAsset extends AssetBundle
{
    /**
     * Определение расположения исходников для пакета.
     *
     * @var string
     */
    public $sourcePath = '@vendor/userstory/module-admin/assetsSource/css';

    /**
     * Определение стилей для админки.
     * Ссылка изменена на кастомный css, для того, чтобы не было внешних зависимостей.
     *
     * @var array
     */
    public $css = ['adminlte.css'];

    /**
     * Определение яваскриптов для библиотеки.
     *
     * @var array
     */
    public $js = [];

    /**
     * Зависимости от других подключаемых модулей.
     *
     * @var array
     */
    public $depends = [JqueryAsset::class];

    /**
     * Шкура для отображения админки.
     *
     * @var string|bool Choose skin color, eg. `'skin-blue'` or set `false` to disable skin loading
     *
     * @see https://almsaeedstudio.com/themes/AdminLTE/documentation/index.html#layout
     */
    public $skin = '_all-skins';

    /**
     * Инициализация отображения админки.
     *
     * @throws Exception сам не понял в каком случае должно генерироваться.
     *
     * @return void
     */
    public function init()
    {
        // Append skin color file if specified.
        if ($this->skin) {
            if (( '_all-skins' !== $this->skin ) && ( strpos($this->skin, 'skin-') !== 0 )) {
                throw new Exception('Invalid skin specified');
            }

            $this->css[] = sprintf('skins/%s.min.css', $this->skin);
        }

        parent::init();
    }
}
