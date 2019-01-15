<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\group\operations;

use Userstory\ComponentBase\interfaces\DTOValidatorInterface;
use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\Yii2Cache\interfaces\QueryCacheInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\GroupInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\OperationResultInterface;

/**
 * Интерфейс операции, реализующей логику обновления данных сущности "ВК группа".
 */
interface SingleUpdateOperationInterface
{
    public const DO_EVENT = 'DO_UPDATE';

    /**
     * Метод выполняет операцию.
     *
     * @return OperationResultInterface
     */
    public function doOperation(): OperationResultInterface;

    /**
     * Метод возвращает сущность, над которой нужэно выполнить операцию.
     *
     * @return GroupInterface
     */
    public function getGroup(): GroupInterface;

    /**
     * Метод возвращает валидатор ДТО сущности.
     *
     * @return DTOValidatorInterface
     */
    public function getGroupValidator(): DTOValidatorInterface;

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
     * Метод устанавливает сущность, над которой необходимо выполнить операцию.
     *
     * @param GroupInterface $value Новое значение.
     *
     * @return SingleUpdateOperationInterface
     */
    public function setGroup(GroupInterface $value): SingleUpdateOperationInterface;

    /**
     * Метод задает значение гидратора сущности "ВК группа" в массив для записи в БД и обратно.
     *
     * @param HydratorInterface $hydrator Объект класса преобразователя.
     *
     * @return static
     */
    public function setGroupDatabaseHydrator(HydratorInterface $hydrator);

    /**
     * Метод устанавливает валидатор ДТО сущности.
     *
     * @param DTOValidatorInterface $validator Новое значение.
     *
     * @return SingleUpdateOperationInterface
     */
    public function setGroupValidator(DTOValidatorInterface $validator): SingleUpdateOperationInterface;

    /**
     * Метод устанавливает объект прототипа ответа команды.
     *
     * @param OperationResultInterface $value Новое значение.
     *
     * @return SingleUpdateOperationInterface
     */
    public function setResultPrototype(OperationResultInterface $value): SingleUpdateOperationInterface;
}
