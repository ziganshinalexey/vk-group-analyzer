<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\traits;

use yii\httpclient\Client;

/**
 * Трейт WithHttpClientTrait.
 * Трейт содержит общую логику объекта, работающего с гидратором ДТО.
 */
trait WithHttpClientTrait
{
    /**
     * Объект гидратора ДТО для работы.
     *
     * @var Client|null
     */
    protected $httpClient;

    /**
     * Метод возвращает гидаратор ДТО.
     *
     * @return Client
     */
    public function getHttpClient(): Client
    {
        return $this->httpClient;
    }

    /**
     * Метод устанавливает гидратор ДТО.
     *
     * @param Client $httpClient Новое значение.
     *
     * @return static
     */
    public function setHttpClient(Client $httpClient)
    {
        $this->httpClient = $httpClient;
        return $this;
    }
}
