<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\queries;

use yii\db\Query;
use Ziganshinalexey\Yii2VkApi\entities\UserActiveRecord;
use Ziganshinalexey\Yii2VkApi\interfaces\user\QueryInterface;

/**
 * Класс реализует обертку для формирования критериев выборки данных.
 */
class UserQuery extends Query implements QueryInterface
{
    /**
     * Выборка по атрибуту "Факультет" сущности "ВК пользователь".
     *
     * @param string $facultyName Атрибут "Факультет" сущности.
     * @param string $operator    Оператор сравнения при поиске.
     *
     * @return QueryInterface
     */
    public function byFacultyName(string $facultyName, string $operator = '='): QueryInterface
    {
        return $this->andWhere([
            $operator,
            'facultyName',
            $facultyName,
        ]);
    }

    /**
     * Выборка по атрибуту "Имя" сущности "ВК пользователь".
     *
     * @param string $firstName Атрибут "Имя" сущности.
     * @param string $operator  Оператор сравнения при поиске.
     *
     * @return QueryInterface
     */
    public function byFirstName(string $firstName, string $operator = '='): QueryInterface
    {
        return $this->andWhere([
            $operator,
            'firstName',
            $firstName,
        ]);
    }

    /**
     * Выборка по атрибуту "Идентификатор" сущности "ВК пользователь".
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
     * Задает критерий фильтрации по нескольким значениям атрибута "Идентификатор" сущности "ВК пользователь".
     *
     * @param array $ids Атрибут "Идентификатор" сущности "ВК пользователь".
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
     * Выборка по атрибуту "Фамилия" сущности "ВК пользователь".
     *
     * @param string $lastName Атрибут "Фамилия" сущности.
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return QueryInterface
     */
    public function byLastName(string $lastName, string $operator = '='): QueryInterface
    {
        return $this->andWhere([
            $operator,
            'lastName',
            $lastName,
        ]);
    }

    /**
     * Выборка по атрибуту "Факультет" сущности "ВК пользователь".
     *
     * @param string $photo    Атрибут "Факультет" сущности.
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return QueryInterface
     */
    public function byPhoto(string $photo, string $operator = '='): QueryInterface
    {
        return $this->andWhere([
            $operator,
            'photo',
            $photo,
        ]);
    }

    /**
     * Выборка по атрибуту "Университет" сущности "ВК пользователь".
     *
     * @param string $universityName Атрибут "Университет" сущности.
     * @param string $operator       Оператор сравнения при поиске.
     *
     * @return QueryInterface
     */
    public function byUniversityName(string $universityName, string $operator = '='): QueryInterface
    {
        return $this->andWhere([
            $operator,
            'universityName',
            $universityName,
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
        $this->from(UserActiveRecord::tableName());
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
