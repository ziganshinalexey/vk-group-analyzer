<?php

namespace Userstory\ComponentApiServer\controllers;

use yii;
use Userstory\ComponentApiServer\actions\AbstractApiAction;
use yii\web\Controller;
use yii\web\BadRequestHttpException;
use yii\base\Action;
use Userstory\ComponentHelpers\helpers\ArrayHelper;
use yii\base\InlineAction;
use yii\helpers\Inflector;
use yii\base\InvalidConfigException;
use yii\web\Response;
use yii\base\InvalidRouteException;

/**
 * Class BaseApiController.
 * Базовый контроллер для обработки поступающих API запросов.
 *
 * @package Userstory\ComponentApiServer\controllers
 */
class BaseApiController extends Controller
{
    /**
     * Префикс всех Rest действий.
     *
     * @var string
     */
    protected $actionPrefix = 'rest-';

    /**
     * Свойство хранит набор доступных Rest действий.
     *
     * @var array
     */
    protected $actions = [];

    /**
     * Метод для предварительной инициализации контроллера.
     *
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->setRestActions();
    }

    /**
     * Метод устанавливает Rest действия на основе данных из ApiServer.
     *
     * @return void
     */
    protected function setRestActions()
    {
        $actions = Yii::$app->apiServer->getControllerActions($this->id);

        foreach ($actions as $actionName) {

            $action = [
                'class'        => InlineAction::class,
                'id'           => $actionName,
                'controller'   => $this,
                'actionMethod' => Inflector::id2camel(str_replace($this->actionPrefix, $this->actionPrefix . 'action-', $actionName)),
            ];

            $this->setActions($actionName, $action);
        }
    }

    /**
     * Переопределенный метод для создания нового действия текущего контроллера.
     *
     * @param string $id Идентификатор действия.
     *
     * @throws InvalidConfigException Исключение в случае неправильной передачи параметров при создании объекта.
     *
     * @return Action
     */
    public function createAction($id)
    {
        $actionMap = $this->actions();

        if (0 === strpos($id, $this->actionPrefix) && isset($actionMap[$id])) {
            return Yii::createObject($actionMap[$id], [
                $id,
                $actionMap[$id]['controller'],
                $actionMap[$id]['actionMethod'],
            ]);
        }

        return parent::createAction($id);
    }

    /**
     * Сеттер задает возможные Rest действия.
     *
     * @param string $name   Имя нового действия.
     * @param mixed  $action Объект действия.
     *
     * @return static
     */
    public function setActions($name, $action)
    {
        $this->actions[$name] = $action;

        return $this;
    }

    /**
     * Метод возвращает список внешних действий.
     *
     * @return array
     */
    public function actions()
    {
        /* @var array $actions */
        $actions = Yii::$app->apiServer->getFormattedActions();

        return ArrayHelper::merge(parent::actions(), $this->actions, $actions);
    }

    /**
     * Переопределенный метод для формирование списка параметров, применимых к запрошенному действию контроллера.
     *
     * @param Action|mixed $action Запрошенное действие.
     * @param array|mixed  $params Передаваемые параметры.
     *
     * @throws BadRequestHttpException Исключение в случае отсутствующих или неверных параметров.
     *
     * @return array
     */
    public function bindActionParams($action, $params)
    {
        if (0 === strpos($action->id, $this->actionPrefix) || $action instanceof AbstractApiAction) {
            return $params;
        }

        return parent::bindActionParams($action, $params);
    }

    /**
     * Метод запускает пользовательское действие.
     *
     * @param string $type        Тип пользователского действия.
     * @param array  $routeParams Список параметров роута.
     * @param array  $queryParams Список параметров строки запроса.
     *
     * @throws InvalidRouteException Ислючение, если роут пользовательского действия не найден.
     *
     * @return Response
     */
    protected function runUserAction($type, array $routeParams = [], array $queryParams = [])
    {
        list ($actionName, $actionParams) = Yii::$app->apiServer->getUserAction($type, $routeParams);

        return $this->runAction($actionName, [
            $actionParams,
            $queryParams,
        ]);
    }

    /**
     * Метод запускает пользовательское действие.
     *
     * @param string $type        Тип пользователского действия.
     * @param array  $routeParams Список параметров роута.
     * @param array  $queryParams Список параметров строки запроса.
     *
     * @throws InvalidRouteException Ислючение, если роут пользовательского действия не найден.
     *
     * @return Response
     */
    protected function runOptionAction($type, array $routeParams = [], array $queryParams = [])
    {
        list ($actionName, $actionParams) = Yii::$app->apiServer->getUserAction($type, $routeParams);
        $actionParams = ['method' => 'getOptions'];
        return $this->runAction($actionName, [
            $actionParams,
            $queryParams,
        ]);
    }
}
