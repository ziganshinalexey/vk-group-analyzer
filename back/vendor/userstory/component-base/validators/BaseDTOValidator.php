<?php

namespace Userstory\ComponentBase\validators;

use Userstory\ComponentBase\interfaces\DTOValidatorInterface;
use yii\base\InvalidConfigException;
use yii\base\Model;

/**
 * Класс BaseDTOValidator.
 * Базовый валидатор ДТО объекта.
 *
 * @deprecated Следует использовать Userstory\Yii2Dto\validators\BaseDtoValidator.
 */
class BaseDTOValidator extends Model implements DTOValidatorInterface
{
    /**
     * ДТО объект для валидации.
     *
     * @var object|null
     */
    protected $object;

    /**
     * Метод получает объект для валидации.
     *
     * @return object
     *
     * @throws InvalidConfigException Исключение генерирует в случае если объект пустой.
     */
    protected function getObject(): object
    {
        if (! $this->object) {
            throw new InvalidConfigException(__METHOD__ . '() Object can not be empyt');
        }
        return $this->object;
    }

    /**
     * Метод устанавливает объект для валидации.
     * TODO: Добавить строгую типизацию public function setObject(object $object): DTOValidatorInterface.
     *
     * @param mixed $object Новое значение.
     *
     * @return DTOValidatorInterface
     */
    public function setObject($object): DTOValidatorInterface
    {
        $this->object = $object;
        return $this;
    }

    /**
     * Магический метод __гет для получения несуществующих тарибутов валидатора.
     *
     * @param string $name Название атрибута, который нужно получить.
     *
     * @return mixed
     *
     * @throws InvalidConfigException Исключение генерируется в случае если у валидируемого объекта нет гетера для нужного атрибута.
     */
    public function __get($name)
    {
        $getterName = 'get' . ucfirst($name);
        $object     = $this->getObject();
        if (! method_exists($object, $getterName)) {
            throw new InvalidConfigException(__METHOD__ . '() Method "' . get_class($object) . '::' . $getterName . '" does not exist');
        }
        return $object->$getterName();
    }

    /**
     * Конструктор копирования валидатора.
     *
     * @return static
     */
    public function copy()
    {
        return new static();
    }

    /**
     * Метод возвращает правила валидации.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Метод выполняет валидацию ДТО объекта.
     * TODO: Добавить строгую типизацию public function validateObject(object $object): bool.
     *
     * @param mixed $object Объект для валидации.
     *
     * @return boolean
     */
    public function validateObject($object): bool
    {
        $this->setObject($object);
        return $this->validate(null, true);
    }
}
