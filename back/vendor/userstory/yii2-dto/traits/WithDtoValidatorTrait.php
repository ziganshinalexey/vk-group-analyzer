<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\traits;

use Userstory\Yii2Validators\interfaces\BaseObjectValidatorInterface;

/**
 * Трейт объекта, работающего с валидатором ДТО.
 */
trait WithDtoValidatorTrait
{
    /**
     * Объект валидатора ДТО для работы.
     *
     * @var BaseObjectValidatorInterface|null
     */
    protected $dtoValidator;

    /**
     * Метод возвращает валидатор ДТО.
     *
     * @return BaseObjectValidatorInterface
     */
    public function getDtoValidator(): BaseObjectValidatorInterface
    {
        return $this->dtoValidator;
    }

    /**
     * Метод устанавливает валидатор ДТО.
     *
     * @param BaseObjectValidatorInterface $validator Новое значение.
     *
     * @return static
     */
    public function setDtoValidator(BaseObjectValidatorInterface $validator)
    {
        $this->dtoValidator = $validator;
        return $this;
    }
}
