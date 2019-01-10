<?php

declare( strict_types = 1 );

namespace Userstory\Yii2Forms\validators\rest;

use Userstory\ComponentBase\exceptions\TypeMismatchException;
use Userstory\ComponentBase\interfaces\AbstractFilterInterface;
use Userstory\ComponentBase\validators\BaseDTOValidator;

/**
 * Валидатор атрибутов DTO сущности "Фильтр для формы".
 *
 * @property int $limit  Лимит выводимых записей.
 * @property int $offset Номер записи, с которой нуобходимо сделать выборку.
 */
class AbstractFilterValidator extends BaseDTOValidator
{
    /**
     * Список правил валидации для сущности "Фильтр для формы".
     *
     * @var array
     */
    protected static $ruleList = [
        [
            [
                'limit',
                'offset',
            ],
            'integer',
            'max' => 2147483647,
            'min' => 0,
        ],
    ];

    /**
     * Данный метод возвращает массив, содержащий правила валидации атрибутов.
     *
     * @return array
     */
    public static function getRules(): array
    {
        return self::$ruleList;
    }

    /**
     * Данный метод возвращает массив, содержащий правила валидации атрибутов.
     *
     * @return array
     */
    public function rules(): array
    {
        return self::$ruleList;
    }

    /**
     * Метод выполняет валидацию ДТО сущности.
     *
     * @param mixed $object Объект для валидации.
     *
     * @throws TypeMismatchException Исключение генерируется в случае, если передан ДТО неподдерживаемого типа.
     *
     * @return bool
     */
    public function validateObject($object): bool
    {
        if (! $object instanceof AbstractFilterInterface) {
            throw new TypeMismatchException(get_class($object) . ' must implement ' . AbstractFilterInterface::class);
        }
        return parent::validateObject($object);
    }
}
