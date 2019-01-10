<?php

namespace Userstory\ModuleSms\models;

use yii\httpclient\Client;
use Userstory\ComponentHelpers\helpers\ArrayHelper;

/**
 * Class AbstractCurlSend.
 * Расширяем абстрактный класс для отправок сообщений через курл.
 *
 * @package Userstory\ModuleSms\components\SmsProvider
 */
abstract class AbstractCurlSend extends AbstractProvider
{
    /**
     * Дополнение к основному урлу для отправки сообщения.
     *
     * @var string|null
     */
    protected $sendUrl;
    /**
     * Параметры для курл, определяем в конфиге.
     *
     * @var array|null
     */
    protected $curlSetOpt;

    /**
     * Полученный HTTP код ответа.
     *
     * @var null|integer
     */
    protected $responseCode;

    /**
     * массив заголовков для запроса.
     *
     * @var array
     */
    protected $headers = [];

    /**
     * Получить настройки для курла.
     *
     * @return array|null
     */
    public function getCurlSetOpt()
    {
        return $this->curlSetOpt;
    }

    /**
     * Указвть параметры для курла.
     *
     * @param array $curlSetOpt массив параметров.
     *
     * @return static
     */
    public function setCurlSetOpt(array $curlSetOpt)
    {
        $this->curlSetOpt = $curlSetOpt;
        return $this;
    }

    /**
     * Сам процесс отправки сообщения.
     *
     * @return mixed
     */
    protected function sent()
    {
        $curlOptions = [
            CURLOPT_HEADER         => 0,
            CURLOPT_RETURNTRANSFER => 1,
        ];
        if (is_array($this->curlSetOpt)) {
            $curlOptions = ArrayHelper::merge($curlOptions, $this->getCurlSetOpt());
        }
        $client   = new Client();
        $data     = $this->preparePostFields();
        $response = $client->createRequest()
           ->setMethod($this->getMethod())
           ->setUrl($this->getSendUrl())
           ->setData($data)
           ->setOptions($curlOptions)
           ->setHeaders($this->headers)
           ->send();
        $this->responseCode = $response->statusCode;
        return $response->content;
    }

    /**
     * Подготовка параметров к отправки.
     *
     * @return array
     */
    protected function preparePostFields()
    {
        return [];
    }

    /**
     * Сформировать урл для отправки сообщения.
     *
     * @return null|string
     */
    protected function getSendUrl()
    {
        if (null === $this->sendUrl) {
            return $this->getUrl();
        }

        $url = rtrim($this->getUrl(), '/');

        return $url . '/' . $this->sendUrl;
    }

    /**
     * Получаем метод отправки запроса(get/post).
     *
     * @return string
     */
    public function getMethod()
    {
        $method = 'GET';
        if (is_array($this->curlSetOpt) && isset( $this->curlSetOpt[CURLOPT_POST] )) {
            $method = $this->curlSetOpt[CURLOPT_POST] ? 'POST' : $method;
        }
        return $method;
    }

    /**
     * Присваиваем значение атрибуту.
     *
     * @param array $value значение для атрибута.
     *
     * @return static
     */
    public function setHeaders(array $value)
    {
        $this->headers = $value;
        return $this;
    }
}
