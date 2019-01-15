<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\queries;

use yii\db\Query;
use Ziganshinalexey\Yii2VkApi\entities\GroupActiveRecord;
use Ziganshinalexey\Yii2VkApi\interfaces\group\QueryInterface;

/**
 * Класс реализует обертку для формирования критериев выборки данных.
 */
class GroupQuery extends Query implements QueryInterface
{
    /**
     * Выборка по атрибуту "Название" сущности "ВК группа".
     *
     * @param string $activity Атрибут "Название" сущности.
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return QueryInterface
     */
    public function byActivity(string $activity, string $operator = '='): QueryInterface
    {
        return $this->andWhere([
            $operator,
            'activity',
            $activity,
        ]);
    }

    /**
     * Выборка по атрибуту "Название" сущности "ВК группа".
     *
     * @param string $description Атрибут "Название" сущности.
     * @param string $operator    Оператор сравнения при поиске.
     *
     * @return QueryInterface
     */
    public function byDescription(string $description, string $operator = '='): QueryInterface
    {
        return $this->andWhere([
            $operator,
            'description',
            $description,
        ]);
    }

    /**
     * Выборка по атрибуту "Идентификатор" сущности "ВК группа".
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
     * Задает критерий фильтрации по нескольким значениям атрибута "Идентификатор" сущности "ВК группа".
     *
     * @param array $ids Атрибут "Идентификатор" сущности "ВК группа".
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
     * Выборка по атрибуту "Название" сущности "ВК группа".
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
        $this->from(GroupActiveRecord::tableName());
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
