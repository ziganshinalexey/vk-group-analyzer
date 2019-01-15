<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\user\filters;

use Userstory\ComponentBase\interfaces\ObjectWithErrorsInterface;

/**
 * Интерфейс объявляет методы фильтрации операций.
 */
interface BaseFilterOperationInterface extends ObjectWithErrorsInterface
{
    /**
     * Задает критерий фильтрации выборки по атрибуту "Факультет" сущности "ВК пользователь".
     *
     * @param string $facultyName Атрибут "Факультет" сущности "ВК пользователь".
     * @param string $operator    Оператор сравнения при поиске.
     *
     * @return BaseFilterOperationInterface
     */
    public function byFacultyName(string $facultyName, string $operator = '=');

    /**
     * Задает критерий фильтрации выборки по атрибуту "Имя" сущности "ВК пользователь".
     *
     * @param string $firstName Атрибут "Имя" сущности "ВК пользователь".
     * @param string $operator  Оператор сравнения при поиске.
     *
     * @return BaseFilterOperationInterface
     */
    public function byFirstName(string $firstName, string $operator = '=');

    /**
     * Задает критерий фильтрации выборки по атрибуту "Идентификатор" сущности "ВК пользователь".
     *
     * @param int    $id       Атрибут "Идентификатор" сущности "ВК пользователь".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return BaseFilterOperationInterface
     */
    public function byId(int $id, string $operator = '=');

    /**
     * Задает критерий фильтрации выборки по нескольким значениям PK сущности "ВК пользователь".
     *
     * @param array $ids Список PK  сущности "ВК пользователь".
     *
     * @return BaseFilterOperationInterface
     */
    public function byIds(array $ids);

    /**
     * Задает критерий фильтрации выборки по атрибуту "Фамилия" сущности "ВК пользователь".
     *
     * @param string $lastName Атрибут "Фамилия" сущности "ВК пользователь".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return BaseFilterOperationInterface
     */
    public function byLastName(string $lastName, string $operator = '=');

    /**
     * Задает критерий фильтрации выборки по атрибуту "Факультет" сущности "ВК пользователь".
     *
     * @param string $photo    Атрибут "Факультет" сущности "ВК пользователь".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return BaseFilterOperationInterface
     */
    public function byPhoto(string $photo, string $operator = '=');

    /**
     * Задает критерий фильтрации выборки по атрибуту "Университет" сущности "ВК пользователь".
     *
     * @param string $universityName Атрибут "Университет" сущности "ВК пользователь".
     * @param string $operator       Оператор сравнения при поиске.
     *
     * @return BaseFilterOperationInterface
     */
    public function byUniversityName(string $universityName, string $operator = '=');

    /**
     * Устанавливает сортировку результатов запроса по полю "facultyName".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return BaseFilterOperationInterface
     */
    public function sortByFacultyName(string $sortType = 'ASC');

    /**
     * Устанавливает сортировку результатов запроса по полю "firstName".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return BaseFilterOperationInterface
     */
    public function sortByFirstName(string $sortType = 'ASC');

    /**
     * Устанавливает сортировку результатов запроса по полю "id".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return BaseFilterOperationInterface
     */
    public function sortById(string $sortType = 'ASC');

    /**
     * Устанавливает сортировку результатов запроса по полю "lastName".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return BaseFilterOperationInterface
     */
    public function sortByLastName(string $sortType = 'ASC');

    /**
     * Устанавливает сортировку результатов запроса по полю "photo".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return BaseFilterOperationInterface
     */
    public function sortByPhoto(string $sortType = 'ASC');

    /**
     * Устанавливает сортировку результатов запроса по полю "universityName".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return BaseFilterOperationInterface
     */
    public function sortByUniversityName(string $sortType = 'ASC');
}
