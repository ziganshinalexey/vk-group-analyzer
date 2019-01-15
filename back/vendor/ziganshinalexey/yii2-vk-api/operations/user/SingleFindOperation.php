<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\operations\user;

use Userstory\ComponentBase\events\FindOperationEvent;
use Userstory\Yii2Exceptions\exceptions\typeMismatch\IntMismatchException;
use yii;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\UserInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\SingleFindOperationInterface;
use function is_int;

/**
 * Операция поиска сущностей "ВК пользователь" на основе фильтра.
 */
class SingleFindOperation extends BaseFindOperation implements SingleFindOperationInterface
{
    /**
     * Задает критерий фильтрации выборки по атрибуту "Факультет" сущности "ВК пользователь".
     *
     * @param string $facultyName Атрибут "Факультет" сущности "ВК пользователь".
     * @param string $operator    Оператор сравнения при поиске.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return SingleFindOperationInterface
     */
    public function byFacultyName(string $facultyName, string $operator = '='): SingleFindOperationInterface
    {
        $this->getQuery()->byFacultyName($facultyName, $operator);
        return $this;
    }

    /**
     * Задает критерий фильтрации выборки по атрибуту "Имя" сущности "ВК пользователь".
     *
     * @param string $firstName Атрибут "Имя" сущности "ВК пользователь".
     * @param string $operator  Оператор сравнения при поиске.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return SingleFindOperationInterface
     */
    public function byFirstName(string $firstName, string $operator = '='): SingleFindOperationInterface
    {
        $this->getQuery()->byFirstName($firstName, $operator);
        return $this;
    }

    /**
     * Задает критерий фильтрации выборки по атрибуту "Идентификатор" сущности "ВК пользователь".
     *
     * @param int    $id       Атрибут "Идентификатор" сущности "ВК пользователь".
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
     * Задает критерий фильтрации выборки по нескольким значениям PK сущности "ВК пользователь".
     *
     * @param array $ids Список PK  сущности "ВК пользователь".
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
                throw new IntMismatchException('All User ids must be integer');
            }
        }
        $this->getQuery()->byIds($ids);
        return $this;
    }

    /**
     * Задает критерий фильтрации выборки по атрибуту "Фамилия" сущности "ВК пользователь".
     *
     * @param string $lastName Атрибут "Фамилия" сущности "ВК пользователь".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return SingleFindOperationInterface
     */
    public function byLastName(string $lastName, string $operator = '='): SingleFindOperationInterface
    {
        $this->getQuery()->byLastName($lastName, $operator);
        return $this;
    }

    /**
     * Задает критерий фильтрации выборки по атрибуту "Факультет" сущности "ВК пользователь".
     *
     * @param string $photo    Атрибут "Факультет" сущности "ВК пользователь".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return SingleFindOperationInterface
     */
    public function byPhoto(string $photo, string $operator = '='): SingleFindOperationInterface
    {
        $this->getQuery()->byPhoto($photo, $operator);
        return $this;
    }

    /**
     * Задает критерий фильтрации выборки по атрибуту "Университет" сущности "ВК пользователь".
     *
     * @param string $universityName Атрибут "Университет" сущности "ВК пользователь".
     * @param string $operator       Оператор сравнения при поиске.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return SingleFindOperationInterface
     */
    public function byUniversityName(string $universityName, string $operator = '='): SingleFindOperationInterface
    {
        $this->getQuery()->byUniversityName($universityName, $operator);
        return $this;
    }

    /**
     * Метод возвращает одну сущность по заданному фильтру.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return UserInterface|null
     */
    public function doOperation(): ?UserInterface
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

        $list   = $this->getUserList($data);
        $result = array_shift($list);
        $event  = Yii::createObject([
            'class'                  => FindOperationEvent::class,
            'dataTransferObjectList' => $list,
        ]);
        $this->trigger(self::DO_EVENT, $event);
        return $result;
    }

    /**
     * Устанавливает сортировку результатов запроса по полю "facultyName".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return SingleFindOperationInterface
     */
    public function sortByFacultyName(string $sortType = 'ASC'): SingleFindOperationInterface
    {
        $this->getQuery()->sortBy('facultyName', $sortType);
        return $this;
    }

    /**
     * Устанавливает сортировку результатов запроса по полю "firstName".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return SingleFindOperationInterface
     */
    public function sortByFirstName(string $sortType = 'ASC'): SingleFindOperationInterface
    {
        $this->getQuery()->sortBy('firstName', $sortType);
        return $this;
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
     * Устанавливает сортировку результатов запроса по полю "lastName".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return SingleFindOperationInterface
     */
    public function sortByLastName(string $sortType = 'ASC'): SingleFindOperationInterface
    {
        $this->getQuery()->sortBy('lastName', $sortType);
        return $this;
    }

    /**
     * Устанавливает сортировку результатов запроса по полю "photo".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return SingleFindOperationInterface
     */
    public function sortByPhoto(string $sortType = 'ASC'): SingleFindOperationInterface
    {
        $this->getQuery()->sortBy('photo', $sortType);
        return $this;
    }

    /**
     * Устанавливает сортировку результатов запроса по полю "universityName".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return SingleFindOperationInterface
     */
    public function sortByUniversityName(string $sortType = 'ASC'): SingleFindOperationInterface
    {
        $this->getQuery()->sortBy('universityName', $sortType);
        return $this;
    }
}
