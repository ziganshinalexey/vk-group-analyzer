<?php

namespace Userstory\I18n\interfaces;

use Userstory\ComponentBase\interfaces\ActiveRecordCacheInterface;

/**
 * Интерфейс ClearCacheInterface объявляет методы по очистке кеша компонента мультиязычности.
 *
 * @package Userstory\I18n\interfaces
 */
interface ClearCacheInterface
{
    /**
     * Метод задает значение свойству кеша.
     *
     * @param ActiveRecordCacheInterface $cacheModel Новое значение.
     *
     * @return void
     */
    public function setCacheModel(ActiveRecordCacheInterface $cacheModel);

    /**
     * Метод очищает кеш компонента мультиязычности.
     *
     * @return void
     */
    public function flush();
}
