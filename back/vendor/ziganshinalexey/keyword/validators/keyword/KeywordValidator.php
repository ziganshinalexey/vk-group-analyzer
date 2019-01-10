<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\validators\keyword;

use Userstory\ComponentBase\validators\BaseDTOValidator;
use Userstory\Yii2Exceptions\exceptions\typeMismatch\ExtendsMismatchException;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\KeywordInterface;
use Ziganshinalexey\PersonType\entities\PersonTypeActiveRecord;
use function get_class;

/**
 * Валидатор атрибутов DTO сущности "Ключевое фраза".
 *
 * @property int    $id           Идентификатор.
 * @property int    $personTypeId Идентификатор типа личности.
 * @property string $text         Название.
 */
class KeywordValidator extends BaseDTOValidator
{
    /**
     * Список правил валидации для сущности "Ключевое фраза".
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
            ['personTypeId'],
            'integer',
            'min' => -2147483648,
            'max' => 2147483647,
        ],
        [
            ['text'],
            'string',
            'max' => 65535,
        ],
        [
            [
                'text',
                'personTypeId',
            ],
            'required',
        ],
        [
            ['personTypeId'],
            'exist',
            'targetClass'     => PersonTypeActiveRecord::class,
            'targetAttribute' => [
                'personTypeId' => 'id',
            ],
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
        if (! $object instanceof KeywordInterface) {
            throw new ExtendsMismatchException(get_class($object) . ' must implement ' . KeywordInterface::class);
        }
        return parent::validateObject($object);
    }
}
