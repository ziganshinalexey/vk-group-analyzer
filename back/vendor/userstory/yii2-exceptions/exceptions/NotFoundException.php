<?php

declare(strict_types = 1);

namespace Userstory\Yii2Exceptions\exceptions;

/**
 * Исключение NotFoundException.
 * Исключение отсутствия сущности.
 */
class NotFoundException extends BaseException
{
    /**
     * Свойство хранит по-умолчанию код исключения.
     *
     * @var int
     */
    protected $code = 404;

    /**
     * Свойство хранит по-умолчанию сообщение исключения.
     *
     * @var string
     */
    protected $message = 'Сущность не найдена';
}
