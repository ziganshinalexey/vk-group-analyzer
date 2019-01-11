<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi;

use Userstory\ComponentAutoconfig\interfaces\web\AutoconfigInterface;

/**
 * Настройки для автоконфига - автоматической сборки конфигурации.
 */
class Autoconfig implements AutoconfigInterface
{
    /**
     * Метод реализует интерфейс getWebConfig и возвращает настройки для работы в web-режиме.
     *
     * @return array
     */
    public static function getWebConfig(): array
    {
        return require __DIR__ . '/config/web.config.php';
    }
}
