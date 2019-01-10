<?php

namespace Userstory\UserAdmin\controllers;

use Userstory\ComponentBase\controllers\AbstractController;
use Userstory\User\interfaces\AdapterInterface;
use Userstory\UserAdmin\traits\UserAdminComponentTrait;
use yii;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\captcha\CaptchaAction;
use yii\web\Response;

/**
 * Class LoginController.
 * Контроллер по умолчанию, используемый для аутентификации.
 *
 * @package Userstory\UserAdmin\controllers
 */
class LoginController extends AbstractController
{
    use UserAdminComponentTrait;

    /**
     * Возвращает массив экшенов.
     *
     * @return array
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class'     => CaptchaAction::class,
                'testLimit' => 1,
            ],
        ];
    }

    /**
     * Стандартное действие контроллера, используемое по умолчанию.
     *
     * @throws InvalidConfigException Исключение генерируется во внутренних вызовах.
     * @throws InvalidParamException  Исключение генерируется во внутренних вызовах.
     *
     * @return string|Response
     */
    public function actionIndex()
    {
        $model   = $this->getUserAdminComponent()->modelFactory->getLoginForm();
        $request = Yii::$app->request;

        if ($request->isPost && $model->load($request->post()) && $model->login()) {
            return $this->redirect(Yii::$app->user->getReturnUrl('/'));
        }

        return $this->defaultRender([
            'model' => $model,
            // 'tokenAuthAdapter' => $this->getTokenAuthAdapter(),
        ]);
    }

    /**
     * Метод получает адаптер авторизации по токену.
     *
     * @throws InvalidConfigException Исключение генерируется во внутренних вызовах.
     *
     * @return AdapterInterface|null
     */
    protected function getTokenAuthAdapter()
    {
        $authService = Yii::$app->get('authenticationService');

        if (! $authService) {
            return null;
        }

        return $authService->getAdapter('token');
    }
}
