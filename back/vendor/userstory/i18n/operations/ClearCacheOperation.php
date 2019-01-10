<?php

namespace Userstory\I18n\operations;

use Userstory\ComponentBase\interfaces\ActiveRecordCacheInterface;
use Userstory\I18n\interfaces\ClearCacheInterface;
use yii\base\InvalidValueException;

/**
 * Класс ClearCacheOperation реализует операции по очистки кеша через компонент.
 *
 * @package Userstory\I18n\operations
 */
class ClearCacheOperation implements ClearCacheInterface
{
    /**
     * Свойство хранит объект кеширования.
     *
     * @var ActiveRecordCacheInterface[]|null
     */
    protected $cacheModel;

    /**
     * Метод задает значение свойству кеша.
     *
     * @param ActiveRecordCacheInterface $cacheModel Новое значение.
     *
     * @return void
     */
    public function setCacheModel(ActiveRecordCacheInterface $cacheModel)
    {
        $this->cacheModel[] = $cacheModel;
    }

    /**
     * Метод возвращает значение свойство кеша.
     *
     * @return ActiveRecordCacheInterface[]
     */
    protected function getCacheModel()
    {
        if (null === $this->cacheModel) {
            throw new InvalidValueException('Cache has empty value.');
        }
        return $this->cacheModel;
    }

    /**
     * Метод очищает кеш компонента мультиязычности.
     *
     * @return void
     */
    public function flush()
    {
        $cacheInstances = $this->getCacheModel();
        foreach ($cacheInstances as $cacheInstance) {
            $cacheInstance->flush();
        }
    }
}
