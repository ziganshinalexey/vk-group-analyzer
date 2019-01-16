<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\traits;

use yii\httpclient\Client;

/**
 * Трейт WithHttpClientTrait.
 * Трейт содержит общую логику объекта, работающего с клиент для http запросов.
 */
trait WithHttpClientTrait
{
    /**
     * Свойство хранит клиент для http запросов.
     *
     * @var Client|null
     */
    protected $httpClient;

    /**
     * Метод возвращает клиент для http запросов.
     *
     * @return Client
     */
    public function getHttpClient(): Client
    {
        return $this->httpClient;
    }

    /**
     * Метод устанавливает клиент для http запросов.
     *
     * @param Client $httpClient Новое значение.
     *
     * @return static
     */
    public function setHttpClient(Client $httpClient): self
    {
        $this->httpClient = $httpClient;
        return $this;
    }
}
