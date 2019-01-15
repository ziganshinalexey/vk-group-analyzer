<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\user\operations;

use Userstory\Yii2Cache\interfaces\QueryCacheInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\OperationResultInterface;

/**
 * Интерфейс операции, реализующей логику удаления сущности "ВК пользователь".
 */
interface MultiDeleteOperationInterface
{
    public const DO_EVENT = 'DO_DELETE';

    /**
     * Задает критерий фильтрации выборки по атрибуту "Факультет" сущности "ВК пользователь".
     *
     * @param string $facultyName Атрибут "Факультет" сущности "ВК пользователь".
     *
     * @return MultiDeleteOperationInterface
     */
    public function byFacultyName(string $facultyName): MultiDeleteOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Имя" сущности "ВК пользователь".
     *
     * @param string $firstName Атрибут "Имя" сущности "ВК пользователь".
     *
     * @return MultiDeleteOperationInterface
     */
    public function byFirstName(string $firstName): MultiDeleteOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Идентификатор" сущности "ВК пользователь".
     *
     * @param int $id Атрибут "Идентификатор" сущности "ВК пользователь".
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
     * Задает критерий фильтрации выборки по атрибуту "Фамилия" сущности "ВК пользователь".
     *
     * @param string $lastName Атрибут "Фамилия" сущности "ВК пользователь".
     *
     * @return MultiDeleteOperationInterface
     */
    public function byLastName(string $lastName): MultiDeleteOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Факультет" сущности "ВК пользователь".
     *
     * @param string $photo Атрибут "Факультет" сущности "ВК пользователь".
     *
     * @return MultiDeleteOperationInterface
     */
    public function byPhoto(string $photo): MultiDeleteOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Университет" сущности "ВК пользователь".
     *
     * @param string $universityName Атрибут "Университет" сущности "ВК пользователь".
     *
     * @return MultiDeleteOperationInterface
     */
    public function byUniversityName(string $universityName): MultiDeleteOperationInterface;

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
