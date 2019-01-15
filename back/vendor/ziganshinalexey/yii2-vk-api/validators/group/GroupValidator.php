<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\validators\group;

use Userstory\ComponentBase\validators\BaseDTOValidator;
use Userstory\Yii2Exceptions\exceptions\typeMismatch\ExtendsMismatchException;
use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\GroupInterface;
use function get_class;

/**
 * Валидатор атрибутов DTO сущности "ВК группа".
 *
 * @property string $activity    Название.
 * @property string $description Название.
 * @property int    $id          Идентификатор.
 * @property string $name        Название.
 */
class GroupValidator extends BaseDTOValidator
{
    /**
     * Список правил валидации для сущности "ВК группа".
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
            [
                'name',
                'activity',
            ],
            'string',
            'max' => 255,
        ],
        [
            ['description'],
            'string',
            'max' => 65535,
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
        if (! $object instanceof GroupInterface) {
            throw new ExtendsMismatchException(get_class($object) . ' must implement ' . GroupInterface::class);
        }
        return parent::validateObject($object);
    }
}
