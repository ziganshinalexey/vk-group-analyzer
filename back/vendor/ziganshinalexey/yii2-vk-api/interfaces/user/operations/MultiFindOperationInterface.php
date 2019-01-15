<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\user\operations;

use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\UserInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\filters\MultiFilterOperationInterface;

/**
 * Интерфейс операции, реализующей логику поиска сущности.
 */
interface MultiFindOperationInterface extends BaseFindOperationInterface, MultiFilterOperationInterface
{
    /**
     * Метод возвращает все сущности по заданному фильтру в виде массива.
     *
     * @return array
     */
    public function allAsArray(): array;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Факультет" сущности "ВК пользователь".
     *
     * @param string $facultyName Атрибут "Факультет" сущности "ВК пользователь".
     * @param string $operator    Оператор сравнения при поиске.
     *
     * @return MultiFindOperationInterface
     */
    public function byFacultyName(string $facultyName, string $operator = '='): MultiFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Имя" сущности "ВК пользователь".
     *
     * @param string $firstName Атрибут "Имя" сущности "ВК пользователь".
     * @param string $operator  Оператор сравнения при поиске.
     *
     * @return MultiFindOperationInterface
     */
    public function byFirstName(string $firstName, string $operator = '='): MultiFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Идентификатор" сущности "ВК пользователь".
     *
     * @param int    $id       Атрибут "Идентификатор" сущности "ВК пользователь".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return MultiFindOperationInterface
     */
    public function byId(int $id, string $operator = '='): MultiFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по нескольким значениям PK сущности "ВК пользователь".
     *
     * @param array $ids Список PK  сущности "ВК пользователь".
     *
     * @return MultiFindOperationInterface
     */
    public function byIds(array $ids): MultiFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Фамилия" сущности "ВК пользователь".
     *
     * @param string $lastName Атрибут "Фамилия" сущности "ВК пользователь".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return MultiFindOperationInterface
     */
    public function byLastName(string $lastName, string $operator = '='): MultiFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Факультет" сущности "ВК пользователь".
     *
     * @param string $photo    Атрибут "Факультет" сущности "ВК пользователь".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return MultiFindOperationInterface
     */
    public function byPhoto(string $photo, string $operator = '='): MultiFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Университет" сущности "ВК пользователь".
     *
     * @param string $universityName Атрибут "Университет" сущности "ВК пользователь".
     * @param string $operator       Оператор сравнения при поиске.
     *
     * @return MultiFindOperationInterface
     */
    public function byUniversityName(string $universityName, string $operator = '='): MultiFindOperationInterface;

    /**
     * Метод возвращает все сущности по заданному фильтру.
     *
     * @return UserInterface[]
     */
    public function doOperation(): array;

    /**
     * Метод устанавливает лимит получаемых сущностей.
     *
     * @param int $limit Количество необходимых сущностей.
     *
     * @return MultiFindOperationInterface
     */
    public function limit(int $limit): MultiFindOperationInterface;

    /**
     * Метод устанавливает смещение получаемых сущностей.
     *
     * @param int $offset Смещение в списке необходимых сущностей.
     *
     * @return MultiFindOperationInterface
     */
    public function offset(int $offset): MultiFindOperationInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "facultyName".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return MultiFindOperationInterface
     */
    public function sortByFacultyName(string $sortType = 'ASC'): MultiFindOperationInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "firstName".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return MultiFindOperationInterface
     */
    public function sortByFirstName(string $sortType = 'ASC'): MultiFindOperationInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "id".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return MultiFindOperationInterface
     */
    public function sortById(string $sortType = 'ASC'): MultiFindOperationInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "lastName".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return MultiFindOperationInterface
     */
    public function sortByLastName(string $sortType = 'ASC'): MultiFindOperationInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "photo".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return MultiFindOperationInterface
     */
    public function sortByPhoto(string $sortType = 'ASC'): MultiFindOperationInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "universityName".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return MultiFindOperationInterface
     */
    public function sortByUniversityName(string $sortType = 'ASC'): MultiFindOperationInterface;
}
