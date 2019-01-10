<?php

namespace Userstory\ComponentBase\interfaces;

use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use yii\db\ActiveRecordInterface;

/**
 * Интерфейс ActiveRecordCacheInterface объявляет реализацию класса кеша.
 *
 * @deprecated Следует использовать Userstory\Yii2Cache.
 */
interface ActiveRecordCacheInterface extends AbstractCacheInterface
{
    /**
     * Метод задает значение объекту для преобразования данных.
     *
     * @param DataModelInterface $value Новое значение.
     *
     * @deprecated Следует использовать Userstory\Yii2Cache.
     *
     * @return void
     */
    public function setModelInstance(DataModelInterface $value);

    /**
     * Метод возвращает значение объекта для преобразования данных.
     *
     * @deprecated Следует использовать Userstory\Yii2Cache.
     *
     * @return DataModelInterface
     */
    public function getModelInstance();

    /**
     * Метод задает значение для объекта гидратора.
     *
     * @param HydratorInterface $value Новое значение.
     *
     * @deprecated Следует использовать Userstory\Yii2Cache.
     *
     * @return void
     */
    public function setHydrator(HydratorInterface $value);

    /**
     * Метод возвращает значение объекта гидратора.
     *
     * @deprecated Следует использовать Userstory\Yii2Cache.
     *
     * @return HydratorInterface
     */
    public function getHydrator();

    /**
     * Метод очистки кеша по данным из модели.
     *
     * @param ActiveRecordInterface $model Объект сущности.
     *
     * @deprecated Следует использовать Userstory\Yii2Cache.
     *
     * @return void
     */
    public function clearCacheByModel(ActiveRecordInterface $model);
}
