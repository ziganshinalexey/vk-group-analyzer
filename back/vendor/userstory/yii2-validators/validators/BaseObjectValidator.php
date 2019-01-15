<?php

declare(strict_types = 1);

namespace Userstory\Yii2Validators\validators;

use Userstory\Yii2Errors\traits\errors\WithErrorsTrait;
use Userstory\Yii2Exceptions\exceptions\MethodNotExistsException;
use Userstory\Yii2Validators\interfaces\BaseObjectValidatorInterface;
use yii\base\InvalidConfigException;
use yii\base\Model;
use function DeepCopy\deep_copy;
use function ucfirst;
use function method_exists;
use function get_class;

/**
 * Класс BaseValidator.
 * Базовый валидатор объекта.
 */
class BaseObjectValidator extends Model implements BaseObjectValidatorInterface
{
    use WithErrorsTrait;

    /**
     * Объект для выполнения валидации.
     *
     * @var mixed|null
     */
    protected $object;

    /**
     * Метод получает объект для валидации.
     *
     * @return mixed
     */
    protected function getObject()
    {
        return $this->object;
    }

    /**
     * Метод устанавливает объект для валидации.
     *
     * @param mixed $object Новое значение.
     *
     * @return static
     */
    public function setObject($object): BaseObjectValidatorInterface
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
     * @throws MethodNotExistsException Исключение генерируется в случае если у валидируемого объекта нет гетера для нужного атрибута.
     */
    public function __get($name)
    {
        $getterName = 'get' . ucfirst($name);
        $object     = $this->getObject();
        if (! method_exists($object, $getterName)) {
            throw new MethodNotExistsException('Method "' . get_class($object) . '::' . $getterName . '" does not exist');
        }
        return $object->$getterName();
    }

    /**
     * Конструктор копирования валидатора.
     *
     * @return static
     */
    public function copy(): BaseObjectValidatorInterface
    {
        return deep_copy($this);
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
     *
     * @param mixed $object      Объект для валидации.
     * @param bool  $clearErrors Необходимо ли очищать список ошибок при запуске валидации.
     *
     * @return boolean
     *
     * @throws InvalidConfigException Исключение генерируется в случае, если подсистема ошибок сконфигурирована неверно.
     */
    public function validateObject($object, bool $clearErrors = true): bool
    {
        $this->setObject($object);
        if ($clearErrors) {
            $this->clearUSErrors();
        }
        $result = $this->validate(null, $clearErrors);
        if (! $result) {
            $this->addYiiErrors($this->getErrors());
        }
        return $result;
    }
}
