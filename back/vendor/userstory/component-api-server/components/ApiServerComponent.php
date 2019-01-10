<?php

namespace Userstory\ComponentApiServer\components;

use Error as GlobalError;
use Exception as GlobalException;
use Throwable;
use Userstory\ComponentApiServer\actions\AbstractApiAction;
use Userstory\ComponentApiServer\interfaces\ApiActionInterface;
use Userstory\ComponentApiServer\models\rest\Error;
use Userstory\ComponentApiServer\models\rest\Response as ApiResponse;
use Userstory\ComponentApiServer\traits\GetterSetterTrait;
use Userstory\ComponentHelpers\helpers\ArrayHelper;
use yii;
use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\base\Exception;
use yii\base\ExitException;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\base\InvalidRouteException;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\web\Application;
use yii\web\HttpException;
use yii\web\JsonResponseFormatter;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

/**
 * Class ApiServerComponent.
 * Класс компонента для обработки поступающих API запросов.
 *
 * @property AbstractApiAction $action
 *
 * @package Userstory\ComponentApiServer\components
 */
class ApiServerComponent extends Component implements BootstrapInterface
{
    use GetterSetterTrait;

    const EVENT_API_REQUEST       = 'apiRequest';
    const EVENT_API_BEFORE_PARSE  = 'beforeParseRequest';
    const EVENT_API_BEFORE_ACTION = 'beforeRunAction';

    /**
     * Формат, в котором будет отдаваться ответ.
     * На данный момент поддерживается два формата ответа:
     * Response::FORMAT_JSON
     * Response::FORMAT_XML.
     *
     * @var string
     */
    protected $responseFormat = Response::FORMAT_JSON;

    /**
     * Конфигурация API действий.
     *
     * @var array
     */
    protected $actions = [];

    /**
     * Паттерн перехвата API запросов.
     *
     * @var string
     */
    protected $apiPattern = '/^(.{0,3}\/?)api\//';

    /**
     * Список параметров, используемых в правилах компонента.
     *
     * @var array
     */
    protected $ruleItems = [
        'version'     => 'v\d+(\.\d+)*',
        'language'    => '(ru|en)',
        'resource'    => '[a-zA-Z-]+[0-9]*',
        'subresource' => '[a-zA-Z-]+[0-9]*',
        'action'      => '[a-zA-Z-]+[0-9]*',
        'id'          => '\d+',
        'sid'         => '\d+',
        'selfId'      => 'self',
    ];

    /**
     * Список параметров паттерна, которые используются для формирования названия пользовательского действия.
     *
     * @var array
     */
    protected $userActionIdentity = [
        'version',
        'resource',
        'subresource',
        'action',
    ];

    /**
     * API паттерны возможных действий и соответствующие им действия контроллера.
     * Регулярное выражение должно соответствовать строке идущей за строкой "api/".
     * Правила, находящиеся в $rules будут объединены с правилами, находящимися в $defaultRules и
     * будут добавлены в начало результирующего списка правил.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * API паттерны возможных действий и соответствующие им действия контроллера по умолчанию.
     * Регулярное выражение должно соответствовать строке идущей за строкой "api/".
     * Правила, находящиеся в $defaultRules будут объединены с правилами, находящимися в $rules и
     * будут добавлены в конец результирующего списка правил.
     *
     * @var array
     */
    protected $defaultRules = [];

    /**
     * Кэш операции объединения правил из $rules и $defaultRules.
     *
     * @var array
     */
    protected $allRulesCache = [];

    /**
     * API паттерны возможных системных действий и соответствующие им действия контроллера.
     * Регулярное выражение должно соответствовать строке идущей за строкой "api/".
     * Все системные правила должны использовать контроллер "system".
     *
     * @var array
     */
    protected $systemRules = [];

    /**
     * Свойство хранит объект ответа на запрос.
     *
     * @var ApiResponse|null
     */
    protected $response;

    /**
     * Свойство хранит метод по умолчанию.
     *
     * @var string
     */
    protected $defaultMethod = '';

    /**
     * Свойство хранит хеддеры по-умолчанию.
     *
     * @var array|null
     */
    protected $defaultHeaders;

    /**
     * Объект текущего АПИ экшена.
     *
     * @var AbstractApiAction|null
     */
    protected $action;

    /**
     * Список апи действий с особым url.
     *
     * @var array
     */
    protected $specialActionList = [];

    /**
     * Метод предварительной инициализации компонента.
     *
     * @param Application|mixed $app Объект приложения.
     *
     * @return void
     */
    public function bootstrap($app)
    {
        $jsonFormatter = $app->response->formatters[Response::FORMAT_JSON];
        $jsonFormatter = is_array($jsonFormatter) ? $jsonFormatter : [];

        $app->response->formatters[Response::FORMAT_JSON] = ArrayHelper::merge($jsonFormatter, [
            'class'       => JsonResponseFormatter::class,
            'prettyPrint' => YII_DEBUG,
        ]);

        $app->on(Application::EVENT_BEFORE_REQUEST, [
            $this,
            'parseRequest',
        ]);
    }

    /**
     * Метод устанавливает формат ответа.
     *
     * @param string $responseFormat Новый формат ответа.
     *
     * @return static
     */
    public function setResponseFormat($responseFormat)
    {
        $this->responseFormat = $responseFormat;
        return $this;
    }

    /**
     * Сеттер для установки API правил.
     * Используется обратный порядок правил, чтобы пользовательские правила срабатывали раньше правил компонента.
     *
     * @param array $rules Паттерны для установки.
     *
     * @return static
     */
    public function setRules(array $rules = [])
    {
        $this->rules = ArrayHelper::merge($this->rules, array_reverse($rules));
        $this->clearRulesCache();

        return $this;
    }

    /**
     * Сеттер для установки API правил по умолчанию.
     * Используется обратный порядок правил, чтобы пользовательские правила срабатывали раньше правил компонента.
     *
     * @param array $rules Паттерны для установки.
     *
     * @return static
     */
    public function setDefaultRules(array $rules = [])
    {
        $this->defaultRules = ArrayHelper::merge($this->defaultRules, $rules);
        $this->clearRulesCache();

        return $this;
    }

    /**
     * Сеттер для установки системных правил.
     *
     * @param array $rules Правила для установки.
     *
     * @return static
     */
    public function setSystemRules(array $rules = [])
    {
        $this->systemRules = ArrayHelper::merge($this->systemRules, $rules);

        return $this;
    }

    /**
     * Сеттер для установки параметров API паттернов.
     *
     * @param array $items Параметры для установки.
     *
     * @return static
     */
    public function setRuleItems(array $items = [])
    {
        $this->ruleItems = ArrayHelper::merge($this->ruleItems, $items);

        return $this;
    }

    /**
     * Сеттер для установки параметров паттернов, которые формируют название пользователского действия.
     *
     * @param array $userActionIdentity Параметры для установки.
     *
     * @return static
     */
    public function setUserActionIdentity(array $userActionIdentity = [])
    {
        $this->userActionIdentity = ArrayHelper::merge($this->userActionIdentity, $userActionIdentity);

        return $this;
    }

    /**
     * Сеттер для установки класса APi ответа.
     *
     * @param mixed $response Данные для установки.
     *
     * @throws InvalidConfigException Исключение в случае неверных параметров при создании объекта.
     *
     * @return static
     */
    public function setResponse($response)
    {
        $class  = '';
        $params = [];

        if (is_array($response) && isset($response['class'])) {
            $class  = $response['class'];
            $params = $response;
            unset($params['class']);
        } elseif (is_scalar($response)) {
            $class  = $response;
            $params = [];
        }

        if (ApiResponse::class !== $class && ! $class instanceof ApiResponse) {
            throw new InvalidConfigException('The response class is not instance of Api Response');
        }

        $this->response = Yii::createObject($class, $params);

        return $this;
    }

    /**
     * Метод возвращает класс ответа на запрос.
     *
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Метод обработчик глобального события APPLICATION::BEFORE_REQUEST.
     *
     * @return void
     *
     * @throws ExitException Исключение в случае завершения работы приложения.
     * @throws MethodNotAllowedHttpException Генерирует, если метод не поддерживается.
     */
    protected function parseRequest()
    {
        $request = Yii::$app->request;
        $route   = $request->pathInfo;
        $params  = $request->queryParams;

        if (! preg_match($this->apiPattern, $route) && ! $this->specialUrlExists($route)) {
            return;
        }

        /* @var static $apiServer */
        $apiServer = Yii::$app->apiServer;
        /* @var ApiResponse $response */
        $response   = $apiServer->response;
        $statusCode = 200;

        try {
            $this->trigger(static::EVENT_API_BEFORE_PARSE);
            list($controllerRoute, $controllerParams) = $apiServer->getControllerData($route, $params);
            $this->addDefaultHeaders(Yii::$app->response);
            $actionResponse = Yii::$app->runAction($controllerRoute, $controllerParams);
            if ($actionResponse instanceof ApiResponse) {
                $response = $actionResponse;
            } else {
                $response->setData($actionResponse);
            }
        } catch (InvalidRouteException $e) {
            $statusCode = 404;
            $message    = YII_DEBUG ? $e->getMessage() : 'Unable to resolve request ' . Html::decode(Yii::$app->request->pathInfo);
            $response->addError($e->getCode(), $e->getName(), $message);
        } catch (GlobalException $e) {
            $statusCode = $this->processException($response, $e);
        } catch (GlobalError $e) {
            $statusCode = $this->processException($response, $e);
        }

        if (200 !== $statusCode) {
            Yii::$app->response->statusCode = $statusCode;
        }

        Yii::$app->response->format = $this->getResponseFormat($response);
        Yii::$app->response->data   = $response->jsonSerialize();
        $this->trigger(self::EVENT_API_REQUEST);
        Yii::$app->response->send();
        Yii::$app->end();
    }

    /**
     * Метод обрабатывает глобальные ошибки и возвращает HTTP код возврата.
     *
     * @param ApiResponse $response  Объект текущего АПИ ответа.
     * @param Throwable   $exception Объект текущего исключения.
     *
     * @return int
     */
    protected function processException(ApiResponse $response, Throwable $exception)
    {
        $statusCode = 400;
        $code       = $exception->getCode();
        $title      = $exception->getMessage();
        $detail     = $exception->getFile() . ' (' . $exception->getLine() . ')';

        if ($exception instanceof HttpException) {
            $statusCode = $exception->statusCode;
            $title      = $exception->getName();
        } elseif ($exception instanceof Exception) {
            $title = $exception->getName();
        } elseif ($exception instanceof GlobalException || $exception instanceof GlobalError) {
            $title = $exception->getMessage();
        }

        if (YII_ENV_PROD) {
            $statusCode = 500;
            $code       = Error::INTERNAL_ERROR;
            $title      = Error::INTERNAL_ERROR_TEXT;
            $detail     = '';
            Yii::error($exception->getMessage() . "\n" . $exception->getTraceAsString());
        }

        $response->addError($code, $title, $detail);

        return $statusCode;
    }

    /**
     * Метод проверяет соответствие пути в специльных значениях.
     *
     * @param string $route входной пути.
     *
     * @return boolean
     *
     * @throws MethodNotAllowedHttpException Генерирует, если метод не поддерживается.
     */
    protected function specialUrlExists($route)
    {
        foreach ($this->getSpecialActionList() as $specialRoute => $actionClass) {
            $specialRoute = preg_replace('/\/' . mb_strtolower($this->getMethod(), 'UTF-8') . '\//', '/$1', $specialRoute);
            if ($route === $specialRoute) {
                return true;
            }
        }
        return false;
    }

    /**
     * Метод возвращает формат, в который должен быть завернут ответ.
     *
     * @param ApiResponse $response Объект ответа экшена.
     *
     * @return string
     */
    protected function getResponseFormat(ApiResponse $response)
    {
        if (null !== $response->getFormat()) {
            return $response->getFormat();
        }
        return $this->responseFormat;
    }

    /**
     * Метод возвращает данные для запуска действия контроллера для передачи обработки запроса.
     *
     * @param string $route       Запрошенный роут.
     * @param array  $queryParams Дополнительные параметры запроса.
     *
     * @throws InvalidRouteException         Исключение, если роут обработчика не найден.
     * @throws InvalidParamException         Исключение при неверных параметрах доступа к элементу массива.
     * @throws MethodNotAllowedHttpException Исключение, если не был передан метод запроса.
     * @throws ServerErrorHttpException      Исключение, если правила не прошли предварительную проверку.
     *
     * @return array
     */
    public function getControllerData($route, array $queryParams = [])
    {
        // Обновляем роут, удаляя api в начале строки.
        $route = preg_replace($this->apiPattern, '', trim($route, '/'));
        $route = trim($route, '/');
        $this->preBuildRules();

        $rules  = $this->buildRules();
        $method = $this->getMethod();

        $controllerRoute  = '';
        $controllerParams = [];

        foreach ($rules as $rule) {
            if ('OPTIONS' === $method && preg_match($rule['regex'], $route, $matches)) {
                $controllerRoute           = 'api-server/rest-options';
                $controllerParams['route'] = $this->getRouteParams($route, $rule['pattern']);
                break;
            }
            if (preg_match($rule['regex'], $route, $matches) && in_array($method, $rule['methods'], true)) {
                $controllerRoute           = $rule['route'];
                $controllerParams['route'] = $this->getRouteParams($route, $rule['pattern']);
                $controllerParams['query'] = $this->getQueryParams($queryParams);
                break;
            }
        }
        if ($this->specialUrlExists($route)) {
            $controllerRoute           = 'api-server/rest-' . mb_strtolower($method, 'UTF-8');
            $controllerParams['route'] = [
                'resource' => static::getFormattedValue(preg_replace('/(\S*)\/(\S*)/', '$1', $route)),
                'action'   => preg_replace('/(\S*)\/(\S*)/', '$2', $route),
            ];
        }
        if (empty($controllerRoute)) {
            throw new InvalidRouteException('The requested api route not found!');
        }
        return [
            $controllerRoute,
            $controllerParams,
        ];
    }

    /**
     * Метод возвращает метод текущего запроса.
     *
     * @throws MethodNotAllowedHttpException Исключение, если не был передан метод запроса.
     *
     * @return string
     */
    public function getMethod()
    {
        if (Yii::$app->request->getIsOptions()) {
            return 'OPTIONS';
        }
        $method = Yii::$app->request->getHeaders()->get('X-HTTP-Method-Override');
        if (! empty($method)) {
            return $method;
        }
        $method = Yii::$app->request->getMethod();
        if (! empty($method)) {
            return $method;
        }
        $method = $this->getDefaultMethod();
        if (empty($method)) {
            throw new MethodNotAllowedHttpException('The requested method not allowed or unknown');
        }
        return $method;
    }

    /**
     * Метод строит конечные правила проверки на основе заданных правил (rules) и элементов правил (ruleItems).
     *
     * @return array
     */
    public function buildRules()
    {
        $items = [];

        foreach ($this->ruleItems as $name => $pattern) {
            $items['<' . $name . '>'] = '(' . $pattern . ')';
        }

        $rules           = [];
        $rulePatternList = $this->getAllRules();

        foreach ($rulePatternList as $rule => $route) {
            $rule = trim(preg_replace('/\s+/', '', $rule));

            list($methods, $rulePattern) = $this->parseRule($rule);

            $buildedRule = '/^' . preg_replace('/\//', '\/', strtr($rulePattern, $items)) . '$/';

            $rules[] = [
                'original' => $rule,
                'regex'    => $buildedRule,
                'methods'  => $methods,
                'pattern'  => $rulePattern,
                'route'    => $route,
            ];
        }

        return $rules;
    }

    /**
     * Метод объединяет списки правил $this->rule и $this->defaultRules по следующему принципу:
     * Берется список $this->rule и в него добавляются несуществующие паттерны из $this->defaultRules.
     * Таким образом достигается следующий эфект:
     * Дефолтные правила добавляются в самый конец списка правил и работают в последнюю очередь.
     * Если дефолтное правило было переопределено, оно будет работать в переопределенному виде.
     *
     * @return array
     */
    protected function getAllRules()
    {
        if (is_array($this->allRulesCache) && 0 !== count($this->allRulesCache)) {
            return $this->allRulesCache;
        }

        $this->allRulesCache = $this->rules;
        foreach ($this->defaultRules as $pattern => $action) {
            if (! array_key_exists($pattern, $this->allRulesCache)) {
                $this->allRulesCache[$pattern] = $action;
            }
        }
        return $this->allRulesCache;
    }

    /**
     * Метод сбрасывает кеш правил.
     *
     * @return $this
     */
    protected function clearRulesCache()
    {
        $this->allRulesCache = [];

        return $this;
    }

    /**
     * Метод проверяет заданные пользовательские и системные правила перед их дальнейшей обработкой и построением.
     *
     * @throws ServerErrorHttpException Исключение, если правила не прошли предварительную проверку.
     *
     * @return void
     */
    protected function preBuildRules()
    {
        $rulePatternList = $this->getAllRules();
        foreach ($rulePatternList as $rule => $route) {
            if (preg_match('/system\/(.+)$/', strtolower($rule))) {
                throw new ServerErrorHttpException('User rules can not contain any system controller');
            }
        }

        $this->rules = ArrayHelper::merge($this->systemRules, $this->rules);
        $this->clearRulesCache();
    }

    /**
     * Метод парсит правило, выделяя возвращая методы запроса и паттерн.
     *
     * @param string $rule Правило для парсинга.
     *
     * @return array
     */
    protected function parseRule($rule)
    {
        $methods = ['GET'];
        $pattern = $rule;

        if (1 === preg_match('/\[(.+)\](.+)/', $rule, $matches)) {

            $methods = strtoupper($matches[1]);
            $pattern = $matches[2];

            if (false !== strpos($matches[1], ',')) {
                $methods = explode(',', $matches[1]);
            } else {
                $methods = (array)$methods;
            }
        }

        return [
            $methods,
            $pattern,
        ];
    }

    /**
     * Метод возвращает параметры из роута, которые должны быть переданы дальше в обработчик.
     *
     * @param string $route           Запрошенный роут.
     * @param string $originalPattern Первоначальный паттерн совпавшего правила проверки.
     *
     * @throws InvalidParamException Исключение при неверных параметрах доступа к элементу массива.
     *
     * @return array
     */
    protected function getRouteParams($route, $originalPattern)
    {
        $originalPattern = str_replace([
            '(',
            ')',
            '?',
        ], '', $originalPattern);

        $ruleParts  = explode('/', $originalPattern);
        $routeParts = explode('/', $route);

        $params = array_fill_keys(array_keys($this->ruleItems), null);

        foreach ($routeParts as $routePart) {
            foreach ($ruleParts as $rulePart) {

                if (preg_match('/<(.+)>/', $rulePart, $matches)) {
                    $name        = $matches[1];
                    $rulePattern = ArrayHelper::getValue($this->ruleItems, $name, false);

                    array_shift($ruleParts);

                    if (false !== $rulePattern && preg_match('/^' . $rulePattern . '/', $routePart)) {
                        $params[$name] = $routePart;
                        break;
                    }
                }
            }
        }

        return $this->normalizeParams($params);
    }

    /**
     * Метод нормализует значения параметров запроса.
     * По-умолчанию: приводит к единственному числу название ресурса/подресурса, а также удаляет незаданные параметры.
     *
     * @param array $params Параметры для нормализации.
     *
     * @return array
     */
    protected function normalizeParams(array $params = [])
    {
        $needNormalize = [
            'resource',
            'subresource',
        ];
        $normalized    = [];

        foreach ($params as $name => $value) {
            if (null === $value) {
                continue;
            }

            $normalized[$name] = $value;

            if (in_array($name, $needNormalize, true)) {
                $normalized[$name] = Inflector::singularize($value);
            }
        }

        return $normalized;
    }

    /**
     * Метод формирует список параметров для сортировки.
     *
     * @param array $queryParams Дополнительные параметры запроса.
     *
     * @return array
     */
    protected function getQueryParams(array $queryParams = [])
    {
        $params = $queryParams;

        // Если задана сортировка - включаем ее в передаваемые параметры обработчику.
        if (isset($params['sort'])) {
            $sortQuery = $params['sort'];
            $sort      = (array)$sortQuery;

            unset($params['sort']);

            if (strpos($sortQuery, ',')) {
                $sort = explode(',', trim(preg_replace('/\s+/', '', $sortQuery)));
            }

            foreach ($sort as $sortParam) {
                // Если параметр пустой или число - пропускаем его.
                if (empty($sortParam) || preg_match('/^(\+?|-)\d+/', $sortParam)) {
                    continue;
                }

                if ('-' === $sortParam[0]) {
                    if (strlen($sortParam) > 1) {
                        $params['sort'][str_replace('-', '', $sortParam)] = SORT_DESC;
                    }
                } else {
                    $params['sort'][str_replace('+', '', $sortParam)] = SORT_ASC;
                }
            }
        }

        return $params;
    }

    /**
     * Метод на основе полученных параметров формирует полное имя пользовательского действия и его параметры.
     *
     * @param string $type   Тип пользователского действия.
     * @param array  $params Параметры для обработки.
     *
     * @throws InvalidParamException Исключение при неверных параметрах доступа к элементу массива.
     *
     * @return array
     */
    public function getUserAction($type, array $params = [])
    {
        $userParams   = array_diff_key($params, array_flip($this->userActionIdentity));
        $actionParams = array_intersect_key($params, array_flip($this->userActionIdentity));

        if (isset($actionParams['version'])) {
            $actionParams['version'] = static::getFormattedValue($actionParams['version']);
        }

        // Action-параметр должен быть всегда последним элементом.
        $action = ArrayHelper::getValue($actionParams, 'action', false);
        unset($actionParams['action']);

        $actionParams['type'] = $type;
        if ($action) {
            $actionParams['action'] = $action;
        }

        // Формируем полное имя пользователского действия для подключения к контроллеру.
        $userAction = implode('-', $actionParams);

        return [
            $userAction,
            $userParams,
        ];
    }

    /**
     * Геттер возвращает список отформатированных API действий для последующего вызова их из контроллера.
     *
     * @return array
     */
    public function getFormattedActions()
    {
        $actions = [];

        foreach ($this->actions as $version => $versionConfigs) {
            $version = static::getFormattedValue($version);
            foreach ($versionConfigs as $route => $actionClass) {
                $actionName           = $version . '-' . static::getFormattedValue($route);
                $actions[$actionName] = $actionClass;
            }
        }

        foreach ($this->getSpecialActionList() as $route => $actionClass) {
            $actionName           = static::getFormattedValue($route);
            $actions[$actionName] = $actionClass;
        }

        return $actions;
    }

    /**
     * Метод возвращает отформатированные даннные для формирования имени действия:
     * точки заменяются на подчеркивания, слешы на дефисы.
     *
     * @param string $value Входные данные.
     *
     * @return string
     */
    protected static function getFormattedValue($value)
    {
        return str_replace([
            '.',
            '/',
            '#',
        ], [
            '_',
            '-',
            '',
        ], $value);
    }

    /**
     * Действие для вывода информации о всех доступных методах API.
     *
     * @return array
     *
     * @throws InvalidConfigException Если не удалось получить класс.
     */
    public function getInfo()
    {
        $actions = [];

        foreach ($this->actions as $version => $userAction) {
            $actions = ArrayHelper::merge($actions, $this->getInfoVersion($version));
        }

        return $actions;
    }

    /**
     * Действие для вывода информации о всех доступных методах одной версии API.
     *
     * @param string $version Версия API.
     *
     * @return array
     *
     * @throws InvalidConfigException Если не удалось получить класс.
     */
    public function getInfoVersion($version)
    {
        if (! isset($this->actions[$version])) {
            return [];
        }

        $actions = [];

        /* @var ApiActionInterface $actionClass */
        foreach ($this->actions[$version] as $route => $actionConfig) {
            $actionClass = $this->getActionClassFromConfig($actionConfig);
            if (method_exists($actionClass, 'info')) {
                $apiRoute           = $this->getFormattedInfoRoute($route);
                $actions[$apiRoute] = $actionClass::info();
            }
        }

        return [$version => $actions];
    }

    /**
     * Вычленяем класс действия из его конфигурации.
     *
     * @param string|array $actionConfig Конфигурация апи-экшена.
     *
     * @return string
     *
     * @throws InvalidConfigException Если не удалось получить класс.
     */
    protected function getActionClassFromConfig($actionConfig)
    {
        if (is_string($actionConfig)) {
            return $actionConfig;
        }
        if (is_array($actionConfig) && array_key_exists('class', $actionConfig)) {
            return $actionConfig['class'];
        }
        throw new InvalidConfigException('can\'t find action class, check your configs');
    }

    /**
     * Метод преобразует роут из формата контроллера в формат API.
     * Например "game/update" => "PUT game".
     *
     * @param string $route Роут для форматирования.
     *
     * @return string
     */
    protected function getFormattedInfoRoute($route)
    {
        $mapping = [
            'index'  => 'GET',
            'view'   => 'GET',
            'create' => 'CREATE',
            'update' => 'PUT',
            'delete' => 'DELETE',
            'post'   => 'POST',
        ];

        foreach ($mapping as $action => $method) {
            if (false !== strpos(strtolower($route), $action)) {
                $replaceWhat = [
                    '/' . $action . '/',
                    '/\/\//',
                    '/\/$/',
                ];
                $replaceTo   = [
                    '',
                    '/',
                    '',
                ];
                return $method . ' ' . preg_replace($replaceWhat, $replaceTo, $route);
            }
        }

        return $route;
    }

    /**
     * Метод возвращает список всех действий из списка правил, которые заданы для указанного контроллера.
     *
     * @param string $controllerId Идентификатор контроллера.
     *
     * @return array
     */
    public function getControllerActions($controllerId)
    {
        $actions = [];

        $rulePatternList = $this->getAllRules();
        foreach ($rulePatternList as $route) {
            list($controller, $action) = explode('/', $route);

            if ($controller === $controllerId) {
                $actions[] = $action;
            }
        }
        return $actions;
    }

    /**
     * Метод устанавливает заголовки для предзапроса.
     *
     * @param Response $response Респонз, в который сетим хедеры.
     *
     * @return void
     */
    protected function addDefaultHeaders(Response $response)
    {
        $headers        = $response->getHeaders();
        $defaultHeaders = Yii::$app->get('apiServer')->getDefaultHeaders();
        foreach ($defaultHeaders as $name => $value) {
            if (null === $value) {
                continue;
            }
            $headers->set($name, $value);
        }
    }
}
