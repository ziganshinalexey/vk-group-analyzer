<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\operations\group;

use Userstory\ComponentBase\events\FindOperationEvent;
use Userstory\Yii2Exceptions\exceptions\typeMismatch\IntMismatchException;
use yii;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\GroupInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\MultiFindOperationInterface;
use function is_int;

/**
 * Операция поиска сущностей "ВК группа" на основе фильтра.
 */
class MultiFindOperation extends BaseFindOperation implements MultiFindOperationInterface
{
    /**
     * Метод возвращает все сущности по заданному фильтру в виде массива.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return array
     */
    public function allAsArray(): array
    {
        $query = $this->buildQuery();
        $data  = $this->getFromCache($query, true);
        if (null === $data || false === $data) {
            $data = $query->all($this->getDbConnection());
            $this->setToCache($query, $data, true);
        }
        return $data;
    }

    /**
     * Задает критерий фильтрации выборки по атрибуту "Название" сущности "ВК группа".
     *
     * @param string $activity Атрибут "Название" сущности "ВК группа".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return MultiFindOperationInterface
     */
    public function byActivity(string $activity, string $operator = '='): MultiFindOperationInterface
    {
        $this->getQuery()->byActivity($activity, $operator);
        return $this;
    }

    /**
     * Задает критерий фильтрации выборки по атрибуту "Название" сущности "ВК группа".
     *
     * @param string $description Атрибут "Название" сущности "ВК группа".
     * @param string $operator    Оператор сравнения при поиске.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return MultiFindOperationInterface
     */
    public function byDescription(string $description, string $operator = '='): MultiFindOperationInterface
    {
        $this->getQuery()->byDescription($description, $operator);
        return $this;
    }

    /**
     * Задает критерий фильтрации выборки по атрибуту "Идентификатор" сущности "ВК группа".
     *
     * @param int    $id       Атрибут "Идентификатор" сущности "ВК группа".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return MultiFindOperationInterface
     */
    public function byId(int $id, string $operator = '='): MultiFindOperationInterface
    {
        $this->getQuery()->byId($id, $operator);
        return $this;
    }

    /**
     * Задает критерий фильтрации выборки по нескольким значениям PK сущности "ВК группа".
     *
     * @param array $ids Список PK  сущности "ВК группа".
     *
     * @throws IntMismatchException   Если в переданном массиве содержатся не только целые числа.
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return MultiFindOperationInterface
     */
    public function byIds(array $ids): MultiFindOperationInterface
    {
        foreach ($ids as $id) {
            if (! is_int($id)) {
                throw new IntMismatchException('All Group ids must be integer');
            }
        }
        $this->getQuery()->byIds($ids);
        return $this;
    }

    /**
     * Задает критерий фильтрации выборки по атрибуту "Название" сущности "ВК группа".
     *
     * @param string $name     Атрибут "Название" сущности "ВК группа".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return MultiFindOperationInterface
     */
    public function byName(string $name, string $operator = '='): MultiFindOperationInterface
    {
        $this->getQuery()->byName($name, $operator);
        return $this;
    }

    /**
     * Метод возвращает все сущности по заданному фильтру.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return GroupInterface[]
     */
    public function doOperation(): array
    {
        $data   = $this->allAsArray();
        $result = $this->getGroupList($data);
        $event  = Yii::createObject([
            'class'                  => FindOperationEvent::class,
            'dataTransferObjectList' => $result,
        ]);
        $this->trigger(self::DO_EVENT, $event);
        return $result;
    }

    /**
     * Метод устанавливает лимит получаемых сущностей.
     *
     * @param int $limit Количество необходимых сущностей.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return MultiFindOperationInterface
     */
    public function limit(int $limit): MultiFindOperationInterface
    {
        if ($limit <= 0) {
            return $this;
        }
        $this->getQuery()->limit($limit);
        return $this;
    }

    /**
     * Метод устанавливает смещение получаемых сущностей.
     *
     * @param int $offset Смещение в списке необходимых сущностей.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return MultiFindOperationInterface
     */
    public function offset(int $offset): MultiFindOperationInterface
    {
        if ($offset < 0) {
            return $this;
        }
        $this->getQuery()->offset($offset);
        return $this;
    }

    /**
     * Устанавливает сортировку результатов запроса по полю "activity".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return MultiFindOperationInterface
     */
    public function sortByActivity(string $sortType = 'ASC'): MultiFindOperationInterface
    {
        $this->getQuery()->sortBy('activity', $sortType);
        return $this;
    }

    /**
     * Устанавливает сортировку результатов запроса по полю "description".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return MultiFindOperationInterface
     */
    public function sortByDescription(string $sortType = 'ASC'): MultiFindOperationInterface
    {
        $this->getQuery()->sortBy('description', $sortType);
        return $this;
    }

    /**
     * Устанавливает сортировку результатов запроса по полю "id".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return MultiFindOperationInterface
     */
    public function sortById(string $sortType = 'ASC'): MultiFindOperationInterface
    {
        $this->getQuery()->sortBy('id', $sortType);
        return $this;
    }

    /**
     * Устанавливает сортировку результатов запроса по полю "name".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return MultiFindOperationInterface
     */
    public function sortByName(string $sortType = 'ASC'): MultiFindOperationInterface
    {
        $this->getQuery()->sortBy('name', $sortType);
        return $this;
    }
}
