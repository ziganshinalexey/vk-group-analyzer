<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\interfaces;

use Userstory\Yii2Validators\interfaces\BaseObjectValidatorInterface;

/**
 * Интерфейс объекта, работающего с валидатором ДТО.
 */
interface WithDtoValidatorInterface
{
    /**
     * Метод возвращает валидатор ДТО.
     *
     * @return BaseObjectValidatorInterface
     */
    public function getDtoValidator(): BaseObjectValidatorInterface;

    /**
     * Метод устанавливает валидатор ДТО.
     *
     * @param BaseObjectValidatorInterface $validator Новое значение.
     *
     * @return static
     */
    public function setDtoValidator(BaseObjectValidatorInterface $validator);
}
