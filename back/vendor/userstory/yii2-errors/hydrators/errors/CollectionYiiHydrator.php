<?php

declare(strict_types = 1);

namespace Userstory\Yii2Errors\hydrators\errors;

use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\Yii2Errors\interfaces\errors\CollectionInterface;
use Userstory\Yii2Errors\interfaces\errors\ErrorInterface;
use Userstory\Yii2Errors\traits\errors\ComponentTrait;
use Userstory\Yii2Exceptions\exceptions\types\ExtendsMismatchException;
use yii\base\InvalidConfigException;
use function get_class;
use function is_array;

/**
 * Класс CollectionYiiHydrator.
 * Гидратор коллекции ошибок из/в фломат ошибок Yii.
 */
class CollectionYiiHydrator implements HydratorInterface
{
    use ComponentTrait;

    /**
     * Прототип объекта ошибки для создания объектов ошибок.
     *
     * @var ErrorInterface|null
     */
    protected $errorPrototype;

    /**
     * Метод возвращает прототип ошибки.
     *
     * @return ErrorInterface
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной конфигурации подсистемы.
     */
    public function getErrorPrototype(): ErrorInterface
    {
        return $this->errorPrototype;
    }

    /**
     * Метод устанавливает прототип ошибки.
     *
     * @param ErrorInterface $error Новое значение.
     *
     * @return void
     */
    public function setErrorPrototype(ErrorInterface $error): void
    {
        $this->errorPrototype = $error;
    }

    /**
     * Метод извлекает данные из коллекции ошибок и возаращает их в формате ошибок Yii.
     *
     * @param mixed $object Объект коллекции для извлечения данных.
     *
     * @return array
     *
     * @throws ExtendsMismatchException Исключение генерируется если в качестве аргумента передана не коллекция ошибок.
     */
    public function extract($object): array
    {
        if (! $object instanceof CollectionInterface) {
            throw new ExtendsMismatchException('Class ' . get_class($object) . ' must implements ' . CollectionInterface::class);
        }

        $result = [];
        foreach ($object as $error) {
            $source = $error->getSource();
            if (! isset($result[$source])) {
                $result[$source] = [];
            }
            $result[$source][] = $error->getTitle();
        }
        return $result;
    }

    /**
     * Метод выполняет заполнение коллекции ошибок данными ошибок из модели Yii.
     *
     * @param mixed $data   Данные ошибок из модели Yii.
     * @param mixed $object Коллекция ошибок.
     *
     * @return CollectionInterface
     *
     * @throws ExtendsMismatchException Исключение генерируется если переданы неверные аргументы.
     * @throws InvalidConfigException Исключение генерируется в случае неверной конфигурации подсистемы.
     */
    public function hydrate($data, $object): CollectionInterface
    {
        if (! $object instanceof CollectionInterface) {
            throw new ExtendsMismatchException('Class ' . get_class($object) . ' must implements ' . CollectionInterface::class);
        }
        if (! is_array($data)) {
            throw new ExtendsMismatchException('$data must be array');
        }

        $errorPrototype = $this->getErrorPrototype();
        foreach ($data as $source => $errorMessageList) {
            if (! is_array($errorMessageList)) {
                throw new ExtendsMismatchException('Wrong collection data format');
            }
            foreach ($errorMessageList as $message) {
                $error = $errorPrototype->copy()->setSource($source)->setTitle($message);
                $object->add($error);
            }
        }

        return $object;
    }
}
