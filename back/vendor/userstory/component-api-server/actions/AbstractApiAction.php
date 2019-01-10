<?php

namespace Userstory\ComponentApiServer\actions;

use Userstory\ComponentApiServer\components\ApiServerComponent;
use Userstory\ComponentApiServer\interfaces\ApiActionInterface;
use Userstory\ComponentApiServer\models\rest\Response as ApiResponse;
use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\ComponentHydrator\interfaces\FormatterInterface;
use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\web\Response;

/**
 * Class AbstractApiAction.
 * Базовый класс для всех наследуемых API действий.
 *
 * @property boolean $enableIPRestriction
 * @property boolean $enableEncryption
 *
 * @package Userstory\ComponentApiServer\components
 */
abstract class AbstractApiAction extends Action implements ApiActionInterface
{
    const FORMAT_KEY = 'format';

    /**
     * Свойство содержит объект ответа на API запрос.
     *
     * @var ApiResponse|null
     */
    protected $response;

    /**
     * Включить ли фильтр по IP адресам.
     *
     * @var boolean|null
     */
    protected $enableIPRestriction;

    /**
     * Включить ли шифрование данных.
     *
     * @var boolean|null
     */
    protected $enableEncryption;

    /**
     * Свойство хранит объект гидратора.
     *
     * @var HydratorInterface|null
     */
    protected $hydrator;

    /**
     * Свойство хранит объект преобразователя.
     *
     * @var FormatterInterface|null
     */
    protected $formatter;

    /**
     * Метод задает значение преобразователю.
     *
     * @param string $formatterClass Класс преобразователя.
     *
     * @return void
     *
     * @throws InvalidConfigException Если преобразователь сконфигурирован неверно.
     */
    public function setFormatter($formatterClass)
    {
        $formatter = Yii::createObject($formatterClass);
        if (! $formatter instanceof FormatterInterface) {
            throw new InvalidConfigException('Formatter must implement ' . FormatterInterface::class);
        }
        $this->formatter = $formatter;
    }

    /**
     * Метод возвращает объект преобразователя.
     *
     * @throws InvalidConfigException Если преобразователь сконфигурирован неверно.
     *
     * @return FormatterInterface
     */
    protected function getFormatter()
    {
        if (null === $this->formatter) {
            throw new InvalidConfigException('Formatter object can not be null');
        }
        return $this->formatter;
    }

    /**
     * Метод задает значение гидратору.
     *
     * @param string $hydratorClass Класс гидратора.
     *
     * @return void
     *
     * @throws InvalidConfigException Если гидратор сконфигурирован неверно.
     */
    public function setHydrator($hydratorClass)
    {
        $hydrator = Yii::createObject($hydratorClass);
        if (! $hydrator instanceof HydratorInterface) {
            throw new InvalidConfigException('Hydrator must implement ' . HydratorInterface::class);
        }
        $this->hydrator = $hydrator;
    }

    /**
     * Метод возвращает объект гидратора.
     *
     * @throws InvalidConfigException Если гидратор сконфигурирован неверно.
     *
     * @return HydratorInterface
     */
    protected function getHydrator()
    {
        if (null === $this->hydrator) {
            throw new InvalidConfigException('Hydrator object can not be null');
        }
        return $this->hydrator;
    }

    /**
     * Метод задает проверку фильтра по IP адресам.
     *
     * @param boolean $isEnabled Включить ли проверку.
     *
     * @return static
     */
    public function setEnableIPRestriction($isEnabled)
    {
        $this->enableIPRestriction = $isEnabled;
        return $this;
    }

    /**
     * Метод возвращает надо ли проводить проверку фильтра по IP адресам.
     *
     * @return boolean
     */
    public function getEnableIPRestriction()
    {
        return $this->enableIPRestriction;
    }

    /**
     * Метод задает включение шифрования для экшена.
     *
     * @param boolean $isEnabled Включить ли шифрование.
     *
     * @return static
     */
    public function setEnableEncryption($isEnabled)
    {
        $this->enableEncryption = $isEnabled;
        return $this;
    }

    /**
     * Метод возвращает надо ли включать шифрование для экшена.
     *
     * @return boolean
     */
    public function getEnableEncryption()
    {
        return $this->enableEncryption;
    }

    /**
     * Предвариательный метод инициализации действия.
     *
     * @return void
     */
    public function init()
    {
        parent::init();

        $this->response = Yii::$app->apiServer->response;
    }

    /**
     * Метод выполняет действие и возвращает результат.
     *
     * @param array $routeParams Список параметров роута.
     * @param array $queryParams Список параметров строки запроса.
     *
     * @return Response
     */
    abstract public function run(array $routeParams = [], array $queryParams = []);

    /**
     * Переопределенный метод для вызова API действия.
     *
     * @param mixed $params Входящие параметры для действия.
     *
     * @throws InvalidConfigException Исключение при неверной конфигурации запуска действия.
     *
     * @return Response
     */
    public function runWithParams($params)
    {
        if (isset($params[0]) && isset($params[0]['method'])) {
            return $this->response;
        }

        $response = parent::runWithParams($params);

        if ($response instanceof ApiResponse) {
            $this->response = $response;
            return $this->response;
        }

        if (! $this->response->hasData() && ! $this->response->hasErrors()) {
            $this->response->setData($response);
        }

        return $this->response;
    }

    /**
     * Метод запускается перед выполнением api-action и устанавливает нужный формат ответа.
     *
     * @return boolean
     */
    protected function beforeRun()
    {
        /* @var ApiServerComponent $apiServer */
        $apiServer = Yii::$app->apiServer;
        $apiServer->setAction($this)->trigger(ApiServerComponent::EVENT_API_BEFORE_ACTION);

        $format = ArrayHelper::getValue(Yii::$app->request->post(), self::FORMAT_KEY, Response::FORMAT_JSON);

        switch ($format) {
            case Response::FORMAT_XML:
                $this->response->setFormat(Response::FORMAT_XML);
                break;

            case Response::FORMAT_JSON:
                $this->response->setFormat(Response::FORMAT_JSON);
                break;
        }

        return parent::beforeRun();
    }

    /**
     * Метод выполняет необходимые действия для обработки возникшей ошибки доступа.
     *
     * @param string $message сообщение об ошибке.
     *
     * @return array
     */
    protected function processAccessError($message = 'Доступ запрещен')
    {
        $this->response->addError(403, $message);
        Yii::$app->response->setStatusCode(403);
        return [];
    }

    /**
     * Метод выполняет необходимые действия для обработки возникшей ошибки доступа.
     *
     * @param array  $errors  массив ошибок.
     * @param string $message сообщение об ошибке.
     * @param string $detail  подробнее об ошибке.
     *
     * @return array
     */
    protected function processWrongDataError(array $errors, $message = 'Неверные входные параметры', $detail = '')
    {
        $this->response->addError(422, $message, $detail, $errors);
        Yii::$app->response->setStatusCode(422);
        return [];
    }

    /**
     * Метод выполняет необходимые действия для обработки возникших ошибок модели.
     *
     * @param array $errorList Массив ошибок.
     *
     * @deprecated
     *
     * @return array
     */
    protected function processModelError(array $errorList)
    {
        foreach ($errorList as $errorKey => $errorMessageList) {
            foreach ($errorMessageList as $errorMessage) {
                if (! $errorMessage) {
                    continue;
                }
                $this->response->addError(422, $errorMessage, ['attribute' => $errorKey]);
            }
        }
        Yii::$app->response->setStatusCode(422);
        return [];
    }

    /**
     * Метод выполняет необходимые действия для обработки возникшей ошибки доступа.
     *
     * @param string $message сообщение об ошибке.
     *
     * @return array
     */
    protected function processNotFoundError($message = 'Сущность не найдена')
    {
        $this->response->addError(404, $message);
        Yii::$app->response->setStatusCode(404);
        return [];
    }

    /**
     * Метод добавляет список ошибок в ответ.
     *
     * @param array $errors Список ошибок.
     *
     * @throws InvalidParamException Исключение в случае, если ошибка не содержит кода или описания.
     *
     * @return ApiResponse
     */
    protected function addErrors(array $errors)
    {
        foreach ($errors as $error) {
            $code   = ArrayHelper::getValue($error, 'code');
            $title  = ArrayHelper::getValue($error, 'title');
            $detail = ArrayHelper::getValue($error, 'detail', '');
            $data   = ArrayHelper::getValue($error, 'data', []);

            if (! isset($code, $title)) {
                throw new InvalidParamException('Errors does not contain required elements (Code or Title)');
            }

            $this->response->addError($code, $title, $detail, $data);
        }

        return $this->response;
    }

    /**
     * Метод добавляет ошибки модели к ответу сервера.
     *
     * @param array   $errorList    Ошибки модели для добавления.
     * @param boolean $commonErrors Добавлять ли ошибку к общему списку моделей сверху у формы.
     * @param boolean $fieldErrors  Выводить ли ошибку около поля атрибута, для которого ошибка добавляется.
     *
     * @return void
     */
    protected function addModelErrors(array $errorList, $commonErrors = true, $fieldErrors = true)
    {
        foreach ($errorList as $attribute => $errorMessageList) {
            $this->addModelError($attribute, $errorMessageList, $commonErrors, $fieldErrors);
        }
    }

    /**
     * Метод добавляет ошибки модели к ответу сервера.
     *
     * @param string  $attribute    Атрибут, для которого добавляется ошибка.
     * @param array   $errorData    Данные ошибки. Стандартый формат ошибки модели Yii.
     * @param boolean $commonErrors Добавлять ли ошибку к общему списку моделей сверху у формы.
     * @param boolean $fieldErrors  Выводить ли ошибку около поля атрибута, для которого ошибка добавляется.
     *
     * @return void
     *
     * @internal param array $errorList Ошибки модели для добавления.
     */
    protected function addModelError($attribute, array $errorData, $commonErrors = true, $fieldErrors = true)
    {
        foreach ($errorData as $errorMessage) {
            if (! $errorMessage) {
                continue;
            }
            $commonError = $commonErrors ? $errorMessage : '';
            $fieldError  = $fieldErrors ? $errorMessage : '';
            $errorData   = 'system' !== $attribute ? [$attribute => $fieldError] : [];
            $this->response->addError(422, $commonError, '', $errorData);
        }
        Yii::$app->response->setStatusCode(400);
    }

    /**
     * Метод выполняет необходимые действия для обработки возникшей ошибки доступа.
     *
     * @param string $message сообщение об ошибке.
     * @param string $detail  подробнее об ошибке.
     *
     * @return array
     */
    protected function processInternalError($message = 'Внутренняя ошибка сервера', $detail = '')
    {
        $this->response->addError(500, $message, $detail);
        Yii::$app->response->setStatusCode(500);
        return [];
    }
}
