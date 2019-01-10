<?php

namespace app\controllers;

use yii\base\InvalidConfigException;
use yii\httpclient\Exception;
use yii\web\Controller;
use yii\web\ErrorAction;

/**
 * Пример основоного контроллера системы.
 *
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * Свойство содержит необходимость рендера подложки.
     *
     * @var bool
     */
    public $layout = false;

    /**
     * Метод определяет конфигурацию экшенов текущего контроллера.
     *
     * @return array
     */
    public function actions()
    {
        return [
            'error' => ErrorAction::class,
        ];
    }

    /**
     * Основной экшен - дефолтный.
     *
     * @return string
     *
     * @throws Exception Не хочу ничего тут писать, все равно временно.
     * @throws InvalidConfigException Не хочу ничего тут писать, все равно временно.
     */
    public function actionIndex()
    {
        return $this->redirect(['/admin']);
    }
}
