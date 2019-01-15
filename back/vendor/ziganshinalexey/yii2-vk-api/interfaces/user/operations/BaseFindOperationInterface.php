<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\user\operations;

use Userstory\ComponentBase\interfaces\ObjectWithErrorsInterface;
use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\Yii2Cache\interfaces\QueryCacheInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\UserInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\QueryInterface;

/**
 * Интерфейс операции, реализующей логику поиска сущности.
 */
interface BaseFindOperationInterface extends ObjectWithErrorsInterface
{
    public const DO_EVENT = 'DO_FIND';

    /**
     * Метод возвращает сущность, над которой нужно выполнить операцию.
     *
     * @return UserInterface
     */
    public function getUserPrototype(): UserInterface;

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
     * Метод устанавливает объект запрос к базе данных.
     *
     * @param QueryInterface $query Новое значение объекта запроса.
     *
     * @return BaseFindOperationInterface
     */
    public function setQuery(QueryInterface $query): BaseFindOperationInterface;

    /**
     * Метод задает значение гидратора сущности "ВК пользователь" в массив для записи в БД и обратно.
     *
     * @param HydratorInterface $hydrator Объект класса преобразователя.
     *
     * @return static
     */
    public function setUserDatabaseHydrator(HydratorInterface $hydrator);

    /**
     * Метод устанавливает сущность, над которой необходимо выполнить операцию.
     *
     * @param UserInterface $value Новое значение.
     *
     * @return BaseFindOperationInterface
     */
    public function setUserPrototype(UserInterface $value): BaseFindOperationInterface;
}
