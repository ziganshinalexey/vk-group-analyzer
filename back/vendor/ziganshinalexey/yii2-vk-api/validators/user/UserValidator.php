<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\validators\user;

use Userstory\ComponentBase\validators\BaseDTOValidator;
use Userstory\Yii2Exceptions\exceptions\typeMismatch\ExtendsMismatchException;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\UserInterface;
use function get_class;

/**
 * Валидатор атрибутов DTO сущности "ВК пользователь".
 *
 * @property string $facultyName    Факультет.
 * @property string $firstName      Имя.
 * @property int    $id             Идентификатор.
 * @property string $lastName       Фамилия.
 * @property string $photo          Факультет.
 * @property string $universityName Университет.
 */
class UserValidator extends BaseDTOValidator
{
    /**
     * Список правил валидации для сущности "ВК пользователь".
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
                'firstName',
                'lastName',
                'universityName',
                'facultyName',
                'photo',
            ],
            'string',
            'max' => 255,
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
        if (! $object instanceof UserInterface) {
            throw new ExtendsMismatchException(get_class($object) . ' must implement ' . UserInterface::class);
        }
        return parent::validateObject($object);
    }
}
