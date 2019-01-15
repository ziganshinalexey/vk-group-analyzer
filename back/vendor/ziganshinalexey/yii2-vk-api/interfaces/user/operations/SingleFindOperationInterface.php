<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\user\operations;

use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\UserInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\filters\SingleFilterOperationInterface;

/**
 * Интерфейс операции, реализующей логику поиска сущности.
 */
interface SingleFindOperationInterface extends BaseFindOperationInterface, SingleFilterOperationInterface
{
    /**
     * Задает критерий фильтрации выборки по атрибуту "Факультет" сущности "ВК пользователь".
     *
     * @param string $facultyName Атрибут "Факультет" сущности "ВК пользователь".
     * @param string $operator    Оператор сравнения при поиске.
     *
     * @return SingleFindOperationInterface
     */
    public function byFacultyName(string $facultyName, string $operator = '='): SingleFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Имя" сущности "ВК пользователь".
     *
     * @param string $firstName Атрибут "Имя" сущности "ВК пользователь".
     * @param string $operator  Оператор сравнения при поиске.
     *
     * @return SingleFindOperationInterface
     */
    public function byFirstName(string $firstName, string $operator = '='): SingleFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Идентификатор" сущности "ВК пользователь".
     *
     * @param int    $id       Атрибут "Идентификатор" сущности "ВК пользователь".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return SingleFindOperationInterface
     */
    public function byId(int $id, string $operator = '='): SingleFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по нескольким значениям PK сущности "ВК пользователь".
     *
     * @param array $ids Список PK  сущности "ВК пользователь".
     *
     * @return SingleFindOperationInterface
     */
    public function byIds(array $ids): SingleFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Фамилия" сущности "ВК пользователь".
     *
     * @param string $lastName Атрибут "Фамилия" сущности "ВК пользователь".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return SingleFindOperationInterface
     */
    public function byLastName(string $lastName, string $operator = '='): SingleFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Факультет" сущности "ВК пользователь".
     *
     * @param string $photo    Атрибут "Факультет" сущности "ВК пользователь".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return SingleFindOperationInterface
     */
    public function byPhoto(string $photo, string $operator = '='): SingleFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Университет" сущности "ВК пользователь".
     *
     * @param string $universityName Атрибут "Университет" сущности "ВК пользователь".
     * @param string $operator       Оператор сравнения при поиске.
     *
     * @return SingleFindOperationInterface
     */
    public function byUniversityName(string $universityName, string $operator = '='): SingleFindOperationInterface;

    /**
     * Метод возвращает одну сущность по заданному фильтру.
     *
     * @return UserInterface|null
     */
    public function doOperation(): ?UserInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "facultyName".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return SingleFindOperationInterface
     */
    public function sortByFacultyName(string $sortType = 'ASC'): SingleFindOperationInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "firstName".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return SingleFindOperationInterface
     */
    public function sortByFirstName(string $sortType = 'ASC'): SingleFindOperationInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "id".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return SingleFindOperationInterface
     */
    public function sortById(string $sortType = 'ASC'): SingleFindOperationInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "lastName".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return SingleFindOperationInterface
     */
    public function sortByLastName(string $sortType = 'ASC'): SingleFindOperationInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "photo".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return SingleFindOperationInterface
     */
    public function sortByPhoto(string $sortType = 'ASC'): SingleFindOperationInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "universityName".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return SingleFindOperationInterface
     */
    public function sortByUniversityName(string $sortType = 'ASC'): SingleFindOperationInterface;
}
