<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\validators\personType;

use Userstory\ComponentBase\validators\BaseDTOValidator;
use Userstory\Yii2Exceptions\exceptions\typeMismatch\ExtendsMismatchException;
use Ziganshinalexey\PersonType\interfaces\personType\dto\PersonTypeInterface;
use function get_class;

/**
 * Валидатор атрибутов DTO сущности "Тип личности".
 *
 * @property int    $id   Идентификатор.
 * @property string $name Название.
 */
class PersonTypeValidator extends BaseDTOValidator
{
    /**
     * Список правил валидации для сущности "Тип личности".
     *
     * @var array
     */
    protected static $ruleList = [
        [
            ['id'],
            'integer',
            'min'         => 1,
            'max'         => 2147483647,
            'skipOnEmpty' => 1,
        ],
        [
            ['name'],
            'string',
            'max' => 255,
        ],
        [
            ['name'],
            'required',
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
     * @throws ExtendsMismatchException Исключение генерируется в случае, если передан ДТО неподдерживаемого типа.
     *
     * @return bool
     */
    public function validateObject($object): bool
    {
        if (! $object instanceof PersonTypeInterface) {
            throw new ExtendsMismatchException(get_class($object) . ' must implement ' . PersonTypeInterface::class);
        }
        return parent::validateObject($object);
    }
}
