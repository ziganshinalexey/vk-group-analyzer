<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\operations\keyword;

use Userstory\ComponentBase\events\FindOperationEvent;
use Userstory\Yii2Exceptions\exceptions\typeMismatch\IntMismatchException;
use yii;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\KeywordInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\MultiFindOperationInterface;
use function is_int;

/**
 * Операция поиска сущностей "Ключевое фраза" на основе фильтра.
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
     * Задает критерий фильтрации выборки по атрибуту "Идентификатор" сущности "Ключевое фраза".
     *
     * @param int    $id       Атрибут "Идентификатор" сущности "Ключевое фраза".
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
     * Задает критерий фильтрации выборки по нескольким значениям PK сущности "Ключевое фраза".
     *
     * @param array $ids Список PK  сущности "Ключевое фраза".
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
                throw new IntMismatchException('All Keyword ids must be integer');
            }
        }
        $this->getQuery()->byIds($ids);
        return $this;
    }

    /**
     * Задает критерий фильтрации выборки по атрибуту "Идентификатор типа личности" сущности "Ключевое фраза".
     *
     * @param int    $personTypeId Атрибут "Идентификатор типа личности" сущности "Ключевое фраза".
     * @param string $operator     Оператор сравнения при поиске.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return MultiFindOperationInterface
     */
    public function byPersonTypeId(int $personTypeId, string $operator = '='): MultiFindOperationInterface
    {
        $this->getQuery()->byPersonTypeId($personTypeId, $operator);
        return $this;
    }

    /**
     * Задает критерий фильтрации выборки по атрибуту "Название" сущности "Ключевое фраза".
     *
     * @param string $text     Атрибут "Название" сущности "Ключевое фраза".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return MultiFindOperationInterface
     */
    public function byText(string $text, string $operator = '='): MultiFindOperationInterface
    {
        $this->getQuery()->byText($text, $operator);
        return $this;
    }

    /**
     * Метод возвращает все сущности по заданному фильтру.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return KeywordInterface[]
     */
    public function doOperation(): array
    {
        $data   = $this->allAsArray();
        $result = $this->getKeywordList($data);
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
     * Устанавливает сортировку результатов запроса по полю "personTypeId".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return MultiFindOperationInterface
     */
    public function sortByPersonTypeId(string $sortType = 'ASC'): MultiFindOperationInterface
    {
        $this->getQuery()->sortBy('personTypeId', $sortType);
        return $this;
    }

    /**
     * Устанавливает сортировку результатов запроса по полю "text".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return MultiFindOperationInterface
     */
    public function sortByText(string $sortType = 'ASC'): MultiFindOperationInterface
    {
        $this->getQuery()->sortBy('text', $sortType);
        return $this;
    }
}
