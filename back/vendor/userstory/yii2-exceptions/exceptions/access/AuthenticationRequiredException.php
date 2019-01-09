<?php

declare(strict_types = 1);

namespace Userstory\Yii2Exceptions\exceptions\access;

/**
 * Исключение возникающее при необходимости авторизации.
 */
class AuthenticationRequiredException extends BaseAccessException
{
    /**
     * Свойство хранит по-умолчанию код исключения.
     *
     * @var int
     */
    protected $code = 401;

    /**
     * Свойство хранит по-умолчанию сообщение исключения.
     *
     * @var string
     */
    protected $message = 'Требуется авторизация';
}
