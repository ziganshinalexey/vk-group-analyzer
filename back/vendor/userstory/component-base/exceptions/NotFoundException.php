<?php

namespace Userstory\ComponentBase\exceptions;

use Exception;

/**
 * Исключение NotFoundException.
 * Исключение отсутствия сущности.
 *
 * @deprecated Следует использовать Userstory\Yii2Exceptions\exceptions\NotFoundException.
 */
class NotFoundException extends Exception
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
