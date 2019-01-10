<?php

namespace Userstory\UserAdmin\controllers;

use Userstory\ComponentBase\controllers\AbstractController;
use yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;

/**
 * Class ProfileController.
 * Контроллер управления профилем пользователя.
 *
 * @package Userstory\UserAdmin\controllers
 */
class ProfileController extends AbstractController
{
    /**
     * Метод определяет поведения контроллера.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Метод отображает просмотр профиля пользователя.
     *
     * @throws InvalidParamException Исключение генерируется во внутренних вызовах.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->defaultRender([
            'userProfile' => Yii::$app->user->getIdentity()->profile,
        ]);
    }
}
