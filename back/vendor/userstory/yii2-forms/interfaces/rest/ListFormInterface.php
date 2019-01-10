<?php

declare( strict_types = 1 );

namespace Userstory\Yii2Forms\interfaces\rest;

use Userstory\ComponentBase\interfaces\AbstractFilterInterface;
use Userstory\Yii2Forms\validators\rest\AbstractFilterValidator;

/**
 * Интерфейс формы для просмотра списка DTO.
 */
interface ListFormInterface extends AbstractFormInterface
{
    /**
     * Метод задает объект фильтра для формы выборки.
     *
     * @param AbstractFilterInterface $value Новое значение.
     *
     * @return ListFormInterface
     */
    public function setFilter(AbstractFilterInterface $value): ListFormInterface;

    /**
     * Метод задает объект валидатора для фильтра.
     *
     * @param AbstractFilterValidator $value Новое значение.
     *
     * @return ListFormInterface
     */
    public function setFilterValidator(AbstractFilterValidator $value): ListFormInterface;

    /**
     * Метод возвращает флаг полноты записей в ответе.
     *
     * @return boolean
     */
    public function getMore(): bool;
}
