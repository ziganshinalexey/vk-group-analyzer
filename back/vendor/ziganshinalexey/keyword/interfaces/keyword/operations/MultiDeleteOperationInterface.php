<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\interfaces\keyword\operations;

use Userstory\Yii2Cache\interfaces\QueryCacheInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\OperationResultInterface;

/**
 * Интерфейс операции, реализующей логику удаления сущности "Ключевое фраза".
 */
interface MultiDeleteOperationInterface
{
    public const DO_EVENT = 'DO_DELETE';

    /**
     * Задает критерий фильтрации выборки по атрибуту "Идентификатор" сущности "Ключевое фраза".
     *
     * @param int $id Атрибут "Идентификатор" сущности "Ключевое фраза".
     *
     * @return MultiDeleteOperationInterface
     */
    public function byId(int $id): MultiDeleteOperationInterface;

    /**
     * Дообваляет фильтр для удаления по ИД.
     *
     * @param array $id Список ИД для удаления.
     *
     * @return MultiDeleteOperationInterface
     */
    public function byIds(array $id): MultiDeleteOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Идентификатор типа личности" сущности "Ключевое фраза".
     *
     * @param int $personTypeId Атрибут "Идентификатор типа личности" сущности "Ключевое фраза".
     *
     * @return MultiDeleteOperationInterface
     */
    public function byPersonTypeId(int $personTypeId): MultiDeleteOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Название" сущности "Ключевое фраза".
     *
     * @param string $text Атрибут "Название" сущности "Ключевое фраза".
     *
     * @return MultiDeleteOperationInterface
     */
    public function byText(string $text): MultiDeleteOperationInterface;

    /**
     * Метод выполняет операцию.
     *
     * @return OperationResultInterface
     */
    public function doOperation(): OperationResultInterface;

    /**
     * Метод возвращает объект-результат ответа команды.
     *
     * @return OperationResultInterface
     */
    public function getResultPrototype(): OperationResultInterface;

    /**
     * Метод задает обработчик на событие.
     *
     * @param string        $name    Название события.
     * @param callable|null $handler Обработчик события.
     * @param mixed|null    $data    Данные которые будет использовать при триггере.
     * @param bool|true     $append  Флаг добавления или замены обработчика.
     *
     * @inherit
     *
     * @return void
     */
    public function on($name, $handler, $data = null, $append = true);

    /**
     * Метод устанавливает модель кэшера.
     *
     * @param QueryCacheInterface $cacheModel Новое значение модели кэшера.
     *
     * @return static
     */
    public function setCacheModel(QueryCacheInterface $cacheModel);

    /**
     * Метод устанавливает объект прототипа ответа команды.
     *
     * @param OperationResultInterface $value Новое значение.
     *
     * @return MultiDeleteOperationInterface
     */
    public function setResultPrototype(OperationResultInterface $value): MultiDeleteOperationInterface;
}
