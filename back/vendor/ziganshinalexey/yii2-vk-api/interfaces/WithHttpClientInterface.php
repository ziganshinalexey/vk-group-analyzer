<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces;

use yii\httpclient\Client;

/**
 * Interface WithHttpClientInterface
 */
interface WithHttpClientInterface
{
    /**
     * Метод возвращает клиент для http запросов.
     *
     * @return Client
     */
    public function getHttpClient(): Client;

    /**
     * Метод устанавливает клиент для http запросов.
     *
     * @param Client $httpClient Новое значение.
     *
     * @return static
     */
    public function setHttpClient(Client $httpClient);
}
