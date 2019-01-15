<?php

declare(strict_types = 1);

namespace Userstory\Yii2Errors\dataTransferObjects\errors;

use Userstory\Yii2Errors\dataTransferObjects\AbstractMessageCollection;
use Userstory\Yii2Errors\interfaces\errors\ErrorInterface;
use Userstory\Yii2Errors\interfaces\errors\CollectionInterface;
use Userstory\Yii2Errors\interfaces\errors\ListIteratorInterface;
use Userstory\Yii2Errors\traits\errors\ComponentTrait;
use yii\base\InvalidConfigException;

/**
 * Класс Collection.
 * Класс коллекции ошибок.
 */
class Collection extends AbstractMessageCollection implements CollectionInterface
{
    use ComponentTrait;

    /**
     * Метод возвращает итератор для итерирования по коллекции ошибок.
     *
     * @return ListIteratorInterface
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной конфигурации подсистемы.
     */
    public function getIterator(): ListIteratorInterface
    {
        return $this->getErrorsComponent()->getListIterator($this->messageList);
    }

    /**
     * Метод добавляет ошибку в коллекцию.
     *
     * @param ErrorInterface $message Новая ошибка.
     *
     * @return CollectionInterface
     */
    public function add(ErrorInterface $message): CollectionInterface
    {
        $this->addMessage($message);
        return $this;
    }

    /**
     * Метод добавляет сообщения переданной колеккции в текущую коллекцию.
     *
     * @param CollectionInterface $errorCollection Коллекция для объединения.
     *
     * @return CollectionInterface
     */
    public function merge(CollectionInterface $errorCollection): CollectionInterface
    {
        $this->mergeCollection($errorCollection);
        return $this;
    }

    /**
     * Метод очищает коллекцию ошибок.
     *
     * @return CollectionInterface
     */
    public function clear(): CollectionInterface
    {
        $this->clearCollection();
        return $this;
    }
}
