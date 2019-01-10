<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\queries;

use yii\db\Query;
use Ziganshinalexey\Keyword\entities\KeywordActiveRecord;
use Ziganshinalexey\Keyword\interfaces\keyword\QueryInterface;

/**
 * Класс реализует обертку для формирования критериев выборки данных.
 */
class KeywordQuery extends Query implements QueryInterface
{
    /**
     * Выборка по атрибуту "Идентификатор" сущности "Ключевое фраза".
     *
     * @param int    $id       Атрибут "Идентификатор" сущности.
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return QueryInterface
     */
    public function byId(int $id, string $operator = '='): QueryInterface
    {
        return $this->andWhere([
            $operator,
            'id',
            $id,
        ]);
    }

    /**
     * Задает критерий фильтрации по нескольким значениям атрибута "Идентификатор" сущности "Ключевое фраза".
     *
     * @param array $ids Атрибут "Идентификатор" сущности "Ключевое фраза".
     *
     * @return QueryInterface
     */
    public function byIds(array $ids): QueryInterface
    {
        return $this->andWhere([
            'IN',
            'id',
            $ids,
        ]);
    }

    /**
     * Выборка по атрибуту "Идентификатор типа личности" сущности "Ключевое фраза".
     *
     * @param int    $personTypeId Атрибут "Идентификатор типа личности" сущности.
     * @param string $operator     Оператор сравнения при поиске.
     *
     * @return QueryInterface
     */
    public function byPersonTypeId(int $personTypeId, string $operator = '='): QueryInterface
    {
        return $this->andWhere([
            $operator,
            'personTypeId',
            $personTypeId,
        ]);
    }

    /**
     * Выборка по атрибуту "Название" сущности "Ключевое фраза".
     *
     * @param string $text     Атрибут "Название" сущности.
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return QueryInterface
     */
    public function byText(string $text, string $operator = '='): QueryInterface
    {
        return $this->andWhere([
            $operator,
            'text',
            $text,
        ]);
    }

    /**
     * Метод выполняет инициализацию объекта.
     *
     * @inherit
     *
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->from(KeywordActiveRecord::tableName());
        $this->select('*');
    }

    /**
     * Устанавливает сортировку результатов запроса.
     *
     * @param string $fieldName Название атрибута, по которому производится сортировка.
     * @param string $sortType  Тип сортировки - ASC или DESC.
     *
     * @return QueryInterface
     */
    public function sortBy(string $fieldName, string $sortType = 'DESC'): QueryInterface
    {
        $sortType = 'ASC' === $sortType ? $sortType : 'DESC';
        return $this->addOrderBy($fieldName . ' ' . $sortType);
    }
}
