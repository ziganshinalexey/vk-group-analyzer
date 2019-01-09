<?php

declare(strict_types = 1);

namespace Userstory\Yii2Exceptions\exceptions\access;

/**
 * Исключение возникающее при запрете доступа.
 */
class AccessDeniedException extends BaseAccessException
{
    /**
     * Свойство хранит по-умолчанию код исключения.
     *
     * @var int
     */
    protected $code = 403;

    /**
     * Свойство хранит по-умолчанию сообщение исключения.
     *
     * @var string
     */
    protected $message = 'Доступ запрещен';
}
