<?php

namespace Userstory\ComponentBase\controllers;

use Exception;
use ReflectionObject;
use Userstory\ComponentBase\interfaces\ControllerModelInterface;
use Userstory\ComponentBase\interfaces\ModelViewInterface;
use Userstory\ComponentBase\ModelView\DefaultView;
use yii;
use yii\base\Action;
use yii\base\Event;
use yii\base\Exception as BaseException;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\Controller as YiiController;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class AbstractController.
 * Базовый класс контроллера, позволяющий переопределить в конфигурационном файле layout и action-template для каждого действия в отдельности.
 *
 * @package Userstory\ComponentBase
 */
abstract class AbstractController extends YiiController
{
    const EVENT_US_BEFORE_ACTION = 'Userstory\ComponentBase\controllers\Controller::beforeAction';

    /**
     * Карта соответствия имени action и шаблона.
     *
     * @var array
     */
    protected $viewMap = [];

    /**
     * Карта соответствия имени layout и имени файла.
     *
     * @var array
     */
    protected $layoutMap = [];

    /**
     * Карта соответствия имени action с классом преобразователя.
     *
     * @var array
     */
    protected $modelViewMap = [];

    /**
     * Класс модели, с которой работает контроллер.
     *
     * @var ControllerModelInterface|mixed|null
     */
    protected $modelClass;

    /**
     * Свойство содержит имя действия контроллера, куда будет перенаправлен пользователь после после операции сохранения (CRUD).
     * Может принимать значения 'index', 'view', 'update'.
     *
     * @var string
     */
    protected $defaultRedirect = 'index';

    /**
     * Действия по-умолчанию доступные в контроллере.
     * "C" - создание, "R" - просмотр, "U" - обновление, "D" - удаление.
     *
     * @var string
     */
    protected $defaultActions = 'CRUD';

    /**
     * Сеттер инициализации карты соответствия между действиями и шаблонами.
     *
     * @param array $actionMap устанавливаемая карта соответствия действий с шаблонами.
     *
     * @return static
     */
    public function setViewMap(array $actionMap)
    {
        $this->viewMap = array_merge($this->viewMap, $actionMap);

        return $this;
    }

    /**
     * Сеттер инициализации карты соответствия между layout и файлами.
     *
     * @param array $layoutMap устанавливаемая карта соответствия действий с шаблонами.
     *
     * @return static
     */
    public function setLayoutMap(array $layoutMap)
    {
        $this->layoutMap = array_merge($this->layoutMap, $layoutMap);

        return $this;
    }

    /**
     * Анализирует текущий Action и определяет шаблон.
     *
     * @param string $defaultAction шаблон по умолчанию, если в карте шаблонов не найдено соответствия.
     *
     * @return string
     */
    protected function getTemplate($defaultAction = null)
    {
        $keys   = explode('/', $this->action->getUniqueId());
        $action = array_pop($keys);
        if (isset($this->viewMap[$action])) {
            return $this->viewMap[$action];
        }
        if (null !== $defaultAction) {
            return $defaultAction;
        }

        return $action;
    }

    /**
     * Анализирует текущий Action и возвращает соответствующий layout, установленный в карте соответствия.
     *
     * @param string $defaultLayout шаблон по умолчанию, если в карте шаблонов не найдено соответствия.
     *
     * @return string
     */
    protected function getLayoutTemplate($defaultLayout = null)
    {
        $keys   = explode('/', $this->action->getUniqueId());
        $action = array_pop($keys);
        if (isset($this->layoutMap[$action])) {
            return $this->layoutMap[$action];
        }
        if (null !== $defaultLayout) {
            return $defaultLayout;
        }

        return $this->layout;
    }

    /**
     * Определяет шаблон layout по карте соответствия и устанавливает его.
     *
     * @param string $defaultLayout шаблон по умолчанию, если в карте шаблонов не найдено соответствия.
     *
     * @return static
     */
    protected function setLayoutByAction($defaultLayout = null)
    {
        $this->layout = $this->getLayoutTemplate($defaultLayout);

        return $this;
    }

    /**
     * Метод устанавливает преднастроенные layout и шаблон действия, заданные параметрами соотвествия.
     *
     * @param mixed $params параметры рендеринга.
     *
     * @return string
     *
     * @throws yii\base\InvalidParamException вьюха не найдена.
     */
    public function defaultRender($params = null)
    {
        $this->setLayoutByAction();
        $view = $this->getTemplate();

        return parent::render($view, $this->getModelView()->setAction($this->action)->getViewData($params));
    }

    /**
     * Метод рендерит дефолтное представление без учета шаблона.
     *
     * @param mixed $params параметры рендеринга.
     *
     * @return string
     *
     * @throws yii\base\InvalidParamException вьюха не найдена.
     */
    public function defaultRenderPartial($params = null)
    {
        $view = $this->getTemplate();

        return parent::renderPartial($view, $this->getModelView()->setAction($this->action)->getViewData($params));
    }

    /**
     * Метод формирует ответ пользователю в виде JSON данных.
     *
     * @param mixed  $params     данные для формирования тела.
     * @param string $jsonFormat формат данных.
     *
     * @return Response
     */
    public function renderJson($params = null, $jsonFormat = Response::FORMAT_JSON)
    {
        $response          = Yii::$app->response;
        $response->format  = $jsonFormat;
        $response->content = json_encode($this->getModelView()->setAction($this->action)->getJsonData($params, $jsonFormat), JSON_UNESCAPED_UNICODE);
        return $response;
    }

    /**
     * Метод формирует ошибочный ответ пользователю в виде JSON данных.
     *
     * @param string $reason     причина возникновения ошибки.
     * @param mixed  $detail     детальная информация по ошибке.
     * @param string $jsonFormat формат возвращаемых данных.
     *
     * @return Response
     */
    public function renderJsonError($reason, $detail = null, $jsonFormat = Response::FORMAT_JSON)
    {
        $params = [
            'status' => false,
            'error'  => $reason,
        ];
        if (null !== $detail) {
            $params['details'] = $detail;
        }
        return $this->renderJson($params, $jsonFormat);
    }

    /**
     * Метод генерирует глобальное событие.
     *
     * @param mixed $action выполняемое действие.
     *
     * @throws ForbiddenHttpException нет доступа.
     * @throws BadRequestHttpException неправильный запрос.
     *
     * @return boolean
     */
    public function beforeAction($action)
    {
        $event = new Event([
            'name'   => static::EVENT_US_BEFORE_ACTION,
            'sender' => $this,
            'data'   => $action,
        ]);
        $this->trigger(static::EVENT_US_BEFORE_ACTION, $event);

        $this->allowDefaultAction($action);

        return ! $event->handled && parent::beforeAction($action);
    }

    /**
     * Сеттер для определения карты.
     *
     * @param array $modelViewMap карта классов, определяющая преобразования данных.
     *
     * @return static
     */
    public function setModelViewMap(array $modelViewMap)
    {
        $this->modelViewMap = array_merge($this->modelViewMap, $modelViewMap);

        return $this;
    }

    /**
     * Получение объекта преобразователя по имение действия.
     *
     * @return ModelViewInterface
     */
    public function getModelView()
    {
        static $cacheModelView = [];

        $actionUID = $this->action->getUniqueId();
        if (isset($cacheModelView[$actionUID])) {
            return $cacheModelView[$actionUID];
        }

        $keys   = explode('/', $actionUID);
        $action = array_pop($keys);
        if (isset($this->modelViewMap[$action]) && class_exists($this->modelViewMap[$action])) {
            $className = $this->modelViewMap[$action];
            return $cacheModelView[$actionUID] = new $className();
        }

        $fullClassName  = get_called_class();
        $modelViewClass = preg_replace([
            '/\\\\controllers\\\\/',
            '/Controller$/',
        ], [
            '\\\\ModelView\\\\',
            'View',
        ], $fullClassName, 1);
        if (class_exists($modelViewClass)) {
            return $cacheModelView[$actionUID] = new $modelViewClass();
        }
        return $this->getDefaultModelView();
    }

    /**
     * Возвращает модел вью по умолчанию для контроллера.
     *
     * @return ModelViewInterface
     */
    protected function getDefaultModelView()
    {
        return new DefaultView();
    }

    /**
     * Функция, вызываемая AccessFilter в случае
     * если данный пользователель не имеет доступа к ресурсу.
     *
     * @param null|array $rule   Вызывашее правило.
     * @param Action     $action Текущий Экшн.
     *
     * @throws ForbiddenHttpException в случае если у пользователя нет прав на доступ к странице.
     * @throws NotFoundHttpException в случае если у пользователя нет прав на доступ к странице.
     *
     * @inherit
     *
     * @return void
     */
    public function defaultDenyCallback($rule, Action $action)
    {
        $user = Yii::$app->getUser();
        if ($user->getIsGuest()) {
            $user->loginRequired();
            return;
        }
        throw new NotFoundHttpException('Not Found');
    }

    /**
     * Перенаправляет на домашнюю страницу в случае
     * если данный пользователель не имеет доступа к ресурсу.
     *
     * @param null|array $rule   Вызывашее правило.
     * @param Action     $action Текущий Экшн.
     *
     * @inherit
     *
     * @return Response
     */
    public function goHomeDenyCallback($rule, Action $action)
    {
        return $action->controller->goHome();
    }

    /**
     * Перенаправляет на предыдущую страницу в случае
     * если данный пользователель не имеет доступа к ресурсу.
     *
     * @param null|array $rule   Вызывашее правило.
     * @param Action     $action Текущий Экшн.
     *
     * @inherit
     *
     * @return Response
     */
    public function goBackDenyCallback($rule, Action $action)
    {
        return $action->controller->goBack();
    }

    /**
     * Сеттер для установки ассоциированного класса модели контроллера.
     *
     * @param string $class Класс модели.
     *
     * @return void
     */
    public function setModelClass($class)
    {
        $this->modelClass = $class;
    }

    /**
     * Сеттер для установки редиректа по-умолчанию для CRUD операций.
     *
     * @param string $redirect Имя экшена редиректа.
     *
     * @return void
     */
    public function setDefaultRedirect($redirect)
    {
        $this->defaultRedirect = $redirect;
    }

    /**
     * Геттер установки редиректа по-умолчанию для CRUD операций.
     *
     * @return string
     */
    public function getDefaultRedirect()
    {
        return $this->defaultRedirect;
    }

    /**
     * Сеттер для установки доступных действий по-умолчанию для текущего контроллера.
     * 'CRUD' - создание, просмотр, редактирование, удаление.
     *
     * @param string $actions Действия по-умолчанию.
     *
     * @return void
     */
    public function setDefaultActions($actions)
    {
        $this->defaultActions = $actions;
    }

    /**
     * Метод возвращает модель ассоциированного класса.
     *
     * @param mixed $config Конфигурация или идентификатор модели.
     *
     * @return ControllerModelInterface|object
     *
     * @throws InvalidConfigException Исключение в случае, если при получении модели была передана неправильная конфигурация.
     * @throws NotFoundHttpException Если модель не найдена.
     */
    protected function getModel($config = null)
    {
        if (null === $config) {
            // Если задано имя ассоциированого класса - возвращаем его объект.
            if (null !== $this->modelClass) {
                return Yii::createObject(['class' => $this->modelClass]);
            }
        } else {
            // Если конфигурация содержит модель класса-потомка ActiveRecord.
            if (isset($config['model'])) {
                /* @var Model $baseModel */
                $baseModel  = $config['model'];
                $reflection = new ReflectionObject($baseModel);
                $class      = $reflection->getName();
                /* @var Model $model */
                $model = Yii::createObject($class);
                $model->setAttributes($baseModel->getAttributes(), false);
                return $model;
            }

            // Если передан идентификатор модели для поиска.
            return $this->findModel($config);
        }

        // Если конфигурация не распознана.
        throw new InvalidConfigException('The controller\'s configuration doesn\'t contain the necessary parameters.');
    }

    /**
     * Метод возвращает адрес редиректа для дефолтных экшенов в случае успеха.
     *
     * @param ControllerModelInterface|mixed $model Текущая модель.
     *
     * @throws NotSupportedException Исключение, если экшн редиректа не поддерживается.
     *
     * @return array
     */
    protected function getSuccessRedirect($model = null)
    {
        $allowActions = [
            'index',
            'view',
            'update',
        ];
        if (! in_array($this->defaultRedirect, $allowActions, true)) {
            throw new NotSupportedException('The action ' . $this->defaultRedirect . ' is not supported as default action ID');
        }

        $pk       = $this->getModelPrimaryKey();
        $redirect = [$this->defaultRedirect];

        if ('index' !== $this->defaultRedirect && null !== $model) {
            $redirect[$pk] = $model->{$pk};
        }

        return $redirect;
    }

    /**
     * Метод возвращает первичный ключ для ассоциированной модели.
     *
     * @return string
     */
    protected function getModelPrimaryKey()
    {
        $class       = $this->modelClass;
        $primaryKeys = $class::primaryKey();
        return $primaryKeys[0];
    }

    /**
     * Метод возвращает массив параметров для передачи в метод рендера.
     *
     * @param ControllerModelInterface|mixed $model Модель c данными.
     *
     * @return array
     */
    protected function getRenderParams($model)
    {
        return [
            'model' => $model,
        ];
    }

    /**
     * Действие по-умолчанию для создания новой записи.
     *
     * @param mixed $config Конфигурация.
     *
     * @return Response|string
     *
     * @throws InvalidConfigException неверная конфигурация для поиска модели.
     * @throws NotSupportedException экшен для редиректа не поддерживается.
     * @throws NotFoundHttpException если модель не найдена.
     * @throws yii\base\InvalidParamException вьюха не найдена.
     */
    protected function defaultCreate($config = null)
    {
        $model = $this->getModel($config);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect($this->getSuccessRedirect($model));
        }

        return $this->defaultRender($this->getRenderParams($model));
    }

    /**
     * Действие по-умолчанию для обновления существующей записи.
     *
     * @param mixed $config Конфигурация или идентификатор модели.
     *
     * @return Response|string
     *
     * @throws InvalidConfigException неправильный конфиг для поиска модели.
     * @throws NotSupportedException экшен для редиректа не поддерживается.
     * @throws NotFoundHttpException если модель не найдена.
     * @throws yii\base\InvalidParamException вьюха не найдена.
     */
    protected function defaultUpdate($config)
    {
        $model = $this->getModel($config);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect($this->getSuccessRedirect($model));
        }

        return $this->defaultRender($this->getRenderParams($model));
    }

    /**
     * Действие по-умолчанию для удаления существующей записи.
     *
     * @param mixed $config Конфигурация или идентификатор модели.
     *
     * @return Response
     *
     * @throws InvalidConfigException неверный конфиг для поиска модели.
     * @throws NotSupportedException экшен для редиректа не поддерживается.
     * @throws yii\db\StaleObjectException бросается при optimistic locking + изменении записи в бд другим юзером
     * или экземпляром модели в промежутке между получением из базы и удалением.
     * @throws NotFoundHttpException если модель не найдена.
     * @throws Exception ошибка при удалении.
     * @throws BaseException ошибка при откате транзакции или неизвестная ошибка при удалении.
     */
    protected function defaultDelete($config)
    {
        $model = $this->getModel($config);
        if ($model->delete() === false) {
            throw new BaseException('Не удалось удалить запись.');
        }

        return $this->redirect($this->getSuccessRedirect($model));
    }

    /**
     * Действие по-умолчанию: вывод всех записей ассоциированного класса.
     *
     * @return string
     *
     * @throws yii\base\InvalidParamException вьюха не найдена.
     */
    public function actionIndex()
    {
        $class        = $this->modelClass;
        $dataProvider = new ActiveDataProvider([
            'query' => $class::find(),
        ]);

        return $this->defaultRender([
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Действие по-умолчанию: создание новой записи для ассоциированного класса.
     *
     * @return Response
     *
     * @throws InvalidConfigException неверная конфигурация для поиска модели.
     * @throws NotSupportedException экшен для редиректа не поддерживается.
     * @throws NotFoundHttpException если модель не найдена.
     * @throws yii\base\InvalidParamException вьюха не найдена.
     */
    public function actionCreate()
    {
        return $this->defaultCreate();
    }

    /**
     * Действие по-умолчанию: обновление записи для ассоциированного класса.
     *
     * @param integer $id Идентификатор модели.
     *
     * @return Response
     *
     * @throws InvalidConfigException неправильный конфиг для поиска модели.
     * @throws NotSupportedException экшен для редиректа не поддерживается.
     * @throws NotFoundHttpException если модель не найдена.
     * @throws yii\base\InvalidParamException вьюха не найдена.
     */
    public function actionUpdate($id)
    {
        return $this->defaultUpdate($id);
    }

    /**
     * Действие по-умолчанию: удаление записи для ассоциированного класса.
     *
     * @param integer $id Идентификатор модели.
     *
     * @return Response
     *
     * @throws InvalidConfigException неверный конфиг для поиска модели.
     * @throws NotSupportedException экшен для редиректа не поддерживается.
     * @throws yii\db\StaleObjectException бросается при optimistic locking + изменении записи в бд другим юзером
     * или экземпляром модели в промежутке между получением из базы и удалением.
     * @throws NotFoundHttpException если модель не найдена.
     * @throws BaseException ошибка при откате транзакции.
     * @throws Exception ошибка при удалении.
     */
    public function actionDelete($id)
    {
        return $this->defaultDelete($id);
    }

    /**
     * Метод проверяет является ли текущий экшн действием по-умолчанию и доступен ли он для выполнения.
     * 'CRUD' - доступны все операции, 'CR**' - доступно только просмотр и создание.
     *
     * @param Action|mixed $action Выполняемое действие.
     *
     * @throws ForbiddenHttpException Исключение, если запрошенный экшн по-умолчанию не доступен в текущем контроллере.
     *
     * @return void
     */
    protected function allowDefaultAction($action)
    {
        $allowActions = [
            'index',
            'create',
            'update',
            'delete',
        ];

        if (! in_array($action->id, $allowActions, true)) {
            return;
        }

        $actionText = $action->id;
        if ('index' === $action->id) {
            $actionText = 'read';
        }

        if (strpos($this->defaultActions, ucfirst($actionText[0])) === false) {
            throw new ForbiddenHttpException('The default action is not available!');
        }
    }

    /**
     * Метод возвращает модель по идентификатору или выбрасывает исключение в противном случае.
     *
     * @param integer $id Идентификатор для поиска.
     *
     * @throws NotFoundHttpException  Исключение, если модель с таким id не найдена.
     *
     * @return mixed
     */
    protected function findModel($id)
    {
        $class = $this->modelClass;
        if (null !== ($model = $class::findOne($id))) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
