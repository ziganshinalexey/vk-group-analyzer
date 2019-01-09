<?php

namespace Userstory\ComponentHelpers;

use Userstory\ComponentAutoconfig\interfaces\web\AutoconfigInterface as AutoconfigWebInterface;

/**
 * Автоконфиг для стандартных компонентов.
 *
 * @package UserstoryAcma\CompanyAdmin
 */
class Autoconfig implements AutoconfigWebInterface
{
    /**
     * Метод реализует класс интерфейса getWebConfig.
     *
     * @return array
     */
    public static function getWebConfig()
    {
        return require __DIR__ . '/config/module.config.php';
    }
}
