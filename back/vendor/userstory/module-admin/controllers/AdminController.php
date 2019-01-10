<?php

namespace Userstory\ModuleAdmin\controllers;

use Userstory\ComponentBase\controllers\AbstractController;
use yii;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * Класс основного контролера админки.
 */
class AdminController extends AbstractController
{
    /**
     * Определение лейаута для контроллеров админки.
     *
     * @var string $layout
     */
    public $layout = 'main';

    /**
     * Роутинг для редиректа пользователя на форму аутентификации.
     *
     * @var array
     */
    public $defaultLoginUrl = ['/login'];

    /**
     * Метод инициализации контроллера.
     *
     * @return void
     */
    public function init()
    {
        parent::init();

        $loginUrl = Yii::$app->getModule('admin')->loginUrl;

        if (null === $loginUrl) {
            $loginUrl = $this->defaultLoginUrl;
        }

        Yii::$app->getUser()->loginUrl = $loginUrl;
    }

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
                        'actions' => [
                            'login',
                            'error',
                        ],
                        'allow'   => true,
                    ],
                    [
                        'actions' => [
                            'logout',
                            'index',
                        ],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Определение доступов до действия в контроллере.
     *
     * @return array
     */
    public function accessFilter()
    {
        return [
            'index' => 'Admin.Access',
        ];
    }

    /**
     * Стартовая страница контроллера.
     *
     * @throws InvalidParamException  Исключение генерируется во внутренних вызовах.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->defaultRender([
            'data' => [],
        ]);
    }

    /**
     * Болванка не стартового действия в контроллере.
     *
     * @throws InvalidParamException  Исключение генерируется во внутренних вызовах.
     *
     * @return string
     */
    public function actionFoobar()
    {
        return $this->render($this->getTemplate('index'), [
            'data' => ['foobar'],
        ]);
    }

    /**
     * Метод отображения и обработки формы аутентификации.
     *
     * @throws InvalidParamException  Исключение генерируется во внутренних вызовах.
     * @throws InvalidConfigException Исключение, если не задан loginUrl.
     *
     * @return string
     */
    public function actionLogin()
    {
        $loginUrl = Yii::$app->getModule('admin')->loginUrl;

        if (null !== $loginUrl) {
            return $this->redirect($loginUrl);
        }

        throw new InvalidConfigException();
    }

    /**
     * Метод реализующий logout завершает сессию пользователя.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(Yii::$app->user->getReturnUrl('/'));
    }
}
