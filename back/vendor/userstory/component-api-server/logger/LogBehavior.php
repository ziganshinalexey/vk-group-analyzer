<?php

namespace Userstory\ComponentApiServer\logger;

use Userstory\ComponentApiServer\components\ApiServerComponent;
use yii;
use yii\base\Behavior;
use yii\base\Event;
use Userstory\ComponentHelpers\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use yii\web\Response;

/**
 * Class LogBehavior.
 * Поведение для логирования поступающих api запросов.
 *
 * @package app\api\log
 */
class LogBehavior extends Behavior
{
    /**
     * Свойство содержит callback-обработчик для форматирования данных перед записью в лог.
     *
     * @var callable|mixed|null
     */
    protected $formatter;

    /**
     * Включить логирование запросов.
     *
     * @var boolean
     */
    public $enableLogging = true;

    /**
     * Сеттер для установки обработчика форматирования лога.
     *
     * @param callable|mixed $handler Колбек для установки.
     *
     * @return static
     */
    public function setFormatter($handler)
    {
        $this->formatter = $handler;

        return $this;
    }

    /**
     * Метод возвращает обработчики на родительские события.
     *
     * @return array
     */
    public function events()
    {
        return ArrayHelper::merge(parent::events(), [
            ApiServerComponent::EVENT_API_REQUEST => 'log',
        ]);
    }

    /**
     * Метод обрабатывает событие api запроса, сохраняя необходимые данные запроса/ответа в логах.
     *
     * @param Event|mixed $event Объект события.
     *
     * @return void
     */
    public function log($event)
    {
        if (! $this->enableLogging) {
            return;
        }

        $response     = Yii::$app->response;
        $dataResponse = $response->data;

        if (Response::FORMAT_JSON === $response->format) {
            $dataResponse = Json::decode(Json::encode($response->data), true);
        } elseif (Response::FORMAT_RAW === $response->format) {
            $dataResponse = StringHelper::truncate($dataResponse, 50);
        }

        $data = [
            'url'      => Yii::$app->request->absoluteUrl,
            'x-method' => $event->sender->getMethod(),
            'request'  => Yii::$app->request->post(),
            'response' => $dataResponse,
        ];

        if (isset( $this->formatter ) && is_callable($this->formatter)) {
            $data = call_user_func($this->formatter, $data);
        }

        Yii::info($data, 'apiLog');
    }
}
