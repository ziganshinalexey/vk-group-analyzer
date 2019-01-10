<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\queries;

use yii\db\Query;
use Ziganshinalexey\PersonType\entities\PersonTypeActiveRecord;
use Ziganshinalexey\PersonType\interfaces\personType\QueryInterface;

/**
 * Класс реализует обертку для формирования критериев выборки данных.
 */
class PersonTypeQuery extends Query implements QueryInterface
{
    /**
     * Выборка по атрибуту "Идентификатор" сущности "Тип личности".
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
     * Задает критерий фильтрации по нескольким значениям атрибута "Идентификатор" сущности "Тип личности".
     *
     * @param array $ids Атрибут "Идентификатор" сущности "Тип личности".
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
     * Выборка по атрибуту "Название" сущности "Тип личности".
     *
     * @param string $name     Атрибут "Название" сущности.
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return QueryInterface
     */
    public function byName(string $name, string $operator = '='): QueryInterface
    {
        return $this->andWhere([
            $operator,
            'name',
            $name,
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
        $this->from(PersonTypeActiveRecord::tableName());
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
