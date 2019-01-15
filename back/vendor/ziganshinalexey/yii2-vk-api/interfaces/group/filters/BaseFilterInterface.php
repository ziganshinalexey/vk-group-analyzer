<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\group\filters;

use Userstory\ComponentBase\interfaces\AbstractFilterInterface;

/**
 * Интерфейс объявляет методы фильтра данных.
 */
interface BaseFilterInterface extends AbstractFilterInterface
{
    /**
     * Метод возвращает атрибут "Название" сущности "ВК группа".
     *
     * @return string
     */
    public function getActivity();

    /**
     * Метод возвращает атрибут "Название" сущности "ВК группа".
     *
     * @return string
     */
    public function getDescription();

    /**
     * Метод возвращает атрибут "Идентификатор" сущности "ВК группа".
     *
     * @return int
     */
    public function getId();

    /**
     * Метод возвращает атрибут "Название" сущности "ВК группа".
     *
     * @return string
     */
    public function getName();
}
