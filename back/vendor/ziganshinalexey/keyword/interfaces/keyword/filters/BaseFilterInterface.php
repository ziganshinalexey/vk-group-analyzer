<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\interfaces\keyword\filters;

use Userstory\ComponentBase\interfaces\AbstractFilterInterface;

/**
 * Интерфейс объявляет методы фильтра данных.
 */
interface BaseFilterInterface extends AbstractFilterInterface
{
    /**
     * Метод возвращает атрибут "Идентификатор" сущности "Ключевое фраза".
     *
     * @return int
     */
    public function getId();

    /**
     * Метод возвращает атрибут "Идентификатор типа личности" сущности "Ключевое фраза".
     *
     * @return int
     */
    public function getPersonTypeId();

    /**
     * Метод возвращает атрибут "Название" сущности "Ключевое фраза".
     *
     * @return string
     */
    public function getText();
}
