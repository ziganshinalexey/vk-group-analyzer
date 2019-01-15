<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\validators;

use Userstory\Yii2Dto\interfaces\BaseDtoInterface;
use Userstory\Yii2Exceptions\exceptions\types\ExtendsMismatchException;
use Userstory\Yii2Validators\interfaces\BaseObjectValidatorInterface;
use Userstory\Yii2Validators\validators\BaseObjectValidator;
use function get_class;

/**
 * Класс BaseDtoValidator.
 * Базовый валидатор ДТО объекта.
 *
 * @noinspection LongInheritanceChainInspection
 */
class BaseDtoValidator extends BaseObjectValidator
{
    /**
     * Метод получает объект для валидации.
     * Метод необходим для обеспечения строгой типизации возвращаемого результата,
     * которой нет в родительском методе.
     *
     * @return BaseDtoInterface
     *
     * @todo Избавиться от переменной $result, когда починят прекомит.
     */
    protected function getObject(): BaseDtoInterface
    {
        $result = parent::getObject();
        return $result;
    }

    /**
     * Метод устанавливает объект для валидации.
     *
     * @param mixed $object Новое значение.
     *
     * @return BaseObjectValidatorInterface
     *
     * @throws ExtendsMismatchException Исключение генерируется в случае если устанавливается неверный объект.
     */
    public function setObject($object): BaseObjectValidatorInterface
    {
        if (! $object instanceof BaseDtoInterface) {
            throw new ExtendsMismatchException(get_class($object) . ' must implement ' . BaseDtoInterface::class);
        }
        parent::setObject($object);
        return $this;
    }
}
