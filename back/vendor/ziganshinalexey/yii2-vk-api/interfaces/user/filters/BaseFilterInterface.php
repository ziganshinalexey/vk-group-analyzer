<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\user\filters;

use Userstory\ComponentBase\interfaces\AbstractFilterInterface;

/**
 * Интерфейс объявляет методы фильтра данных.
 */
interface BaseFilterInterface extends AbstractFilterInterface
{
    /**
     * Метод возвращает атрибут "Факультет" сущности "ВК пользователь".
     *
     * @return string
     */
    public function getFacultyName();

    /**
     * Метод возвращает атрибут "Имя" сущности "ВК пользователь".
     *
     * @return string
     */
    public function getFirstName();

    /**
     * Метод возвращает атрибут "Идентификатор" сущности "ВК пользователь".
     *
     * @return int
     */
    public function getId();

    /**
     * Метод возвращает атрибут "Фамилия" сущности "ВК пользователь".
     *
     * @return string
     */
    public function getLastName();

    /**
     * Метод возвращает атрибут "Факультет" сущности "ВК пользователь".
     *
     * @return string
     */
    public function getPhoto();

    /**
     * Метод возвращает атрибут "Университет" сущности "ВК пользователь".
     *
     * @return string
     */
    public function getUniversityName();
}
