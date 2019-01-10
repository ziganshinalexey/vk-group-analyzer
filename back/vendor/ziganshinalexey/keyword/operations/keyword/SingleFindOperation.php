<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\operations\keyword;

use Userstory\ComponentBase\events\FindOperationEvent;
use Userstory\Yii2Exceptions\exceptions\typeMismatch\IntMismatchException;
use yii;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\KeywordInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\SingleFindOperationInterface;
use function is_int;

/**
 * Операция поиска сущностей "Ключевое фраза" на основе фильтра.
 */
class SingleFindOperation extends BaseFindOperation implements SingleFindOperationInterface
{
    /**
     * Задает критерий фильтрации выборки по атрибуту "Идентификатор" сущности "Ключевое фраза".
     *
     * @param int    $id       Атрибут "Идентификатор" сущности "Ключевое фраза".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return SingleFindOperationInterface
     */
    public function byId(int $id, string $operator = '='): SingleFindOperationInterface
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
     * @return SingleFindOperationInterface
     */
    public function byIds(array $ids): SingleFindOperationInterface
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
     * @return SingleFindOperationInterface
     */
    public function byPersonTypeId(int $personTypeId, string $operator = '='): SingleFindOperationInterface
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
     * @return SingleFindOperationInterface
     */
    public function byText(string $text, string $operator = '='): SingleFindOperationInterface
    {
        $this->getQuery()->byText($text, $operator);
        return $this;
    }

    /**
     * Метод возвращает одну сущность по заданному фильтру.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return KeywordInterface|null
     */
    public function doOperation(): ?KeywordInterface
    {
        $query = $this->buildQuery();
        $data  = $this->getFromCache($query);
        if (null === $data || false === $data) {
            $data = $query->one($this->getDbConnection());
            if (! $data) {
                return null;
            }
            $data = [$data];
            $this->setToCache($query, $data);
        }

        $list   = $this->getKeywordList($data);
        $result = array_shift($list);
        $event  = Yii::createObject([
            'class'                  => FindOperationEvent::class,
            'dataTransferObjectList' => $list,
        ]);
        $this->trigger(self::DO_EVENT, $event);
        return $result;
    }

    /**
     * Устанавливает сортировку результатов запроса по полю "id".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return SingleFindOperationInterface
     */
    public function sortById(string $sortType = 'ASC'): SingleFindOperationInterface
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
     * @return SingleFindOperationInterface
     */
    public function sortByPersonTypeId(string $sortType = 'ASC'): SingleFindOperationInterface
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
     * @return SingleFindOperationInterface
     */
    public function sortByText(string $sortType = 'ASC'): SingleFindOperationInterface
    {
        $this->getQuery()->sortBy('text', $sortType);
        return $this;
    }
}
