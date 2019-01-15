<?php

declare(strict_types = 1);

namespace Userstory\Yii2Errors\interfaces;

/**
 * Интерфейс BaseMessageInterface.
 * Интерфейс объекта сообщения.
 */
interface BaseMessageInterface
{
    /**
     * Метод возвращает источник сообщения.
     *
     * @return string
     */
    public function getSource(): string;

    /**
     * Метод возвращает код ошикбки.
     *
     * @return string
     */
    public function getCode(): string;

    /**
     * Метод возвращает тайтл сообщения.
     *
     * @return string
     */
    public function getTitle(): string;
}
