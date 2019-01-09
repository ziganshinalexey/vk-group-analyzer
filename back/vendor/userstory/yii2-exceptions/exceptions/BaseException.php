<?php

declare(strict_types = 1);

namespace Userstory\Yii2Exceptions\exceptions;

use Exception;
use Throwable;
use yii;

/**
 * Самое общее исключение. От него должны наследоваться все эксепшены.
 */
class BaseException extends Exception
{
    /**
     * Конструктор. Вызывает родителя и пишет запись в лог.
     *
     * @param string    $message  Текст сообщения об ошибке.
     * @param int       $code     Код Ошибки.
     * @param Throwable $previous Предыдущее исключение, если исключение вложенное.
     */
    public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        Yii::error($message);
    }
}
