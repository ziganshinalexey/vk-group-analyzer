<?php

namespace Userstory\ComponentApiServer\models\rest;

/**
 * Class Error.
 * Класс ошибки. Содержит данные для отправки пользователю.
 *
 * @SWG\Definition(
 *     type="object",
 *     definition="Error",
 * )
 *
 * @package Userstory\ComponentApiServer\models\rest
 */
class Error extends AbstractMessage
{
    const INTERNAL_ERROR      = 'A501';
    const INTERNAL_ERROR_TEXT = 'An internal server error occurred. See errors log for details';
}
