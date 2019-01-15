<?php

declare(strict_types = 1);

namespace Userstory\Yii2Errors\dataTransferObjects;

use Userstory\Yii2Errors\interfaces\BaseCollectionInterface;
use Userstory\Yii2Errors\interfaces\BaseMessageInterface;

/**
 * Класс AbstractCollection.
 * Базовый класс коллекции сообщений.
 */
abstract class AbstractMessageCollection implements BaseCollectionInterface
{
    /**
     * Список объектов сообщений в коллекции.
     *
     * @var BaseMessageInterface[]
     */
    protected $messageList = [];

    /**
     * Метод проверяет является ли коллекция пустой.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->messageList);
    }

    /**
     * Метод добавляет сообщение в коллекцию.
     *
     * @param BaseMessageInterface $message Новое сообщение.
     *
     * @return void
     */
    protected function addMessage(BaseMessageInterface $message): void
    {
        $this->messageList[] = $message;
    }

    /**
     * Метод добавляет сообщения переданной колеккции в текущую коллекцию.
     *
     * @param BaseCollectionInterface $errorCollection Коллекция для объединения.
     *
     * @return void
     */
    protected function mergeCollection(BaseCollectionInterface $errorCollection): void
    {
        foreach ($errorCollection as $message) {
            $this->addMessage($message);
        }
    }

    /**
     * Метод очищает коллекцию сообщений.
     *
     * @return void
     */
    protected function clearCollection(): void
    {
        $this->messageList = [];
    }
}
