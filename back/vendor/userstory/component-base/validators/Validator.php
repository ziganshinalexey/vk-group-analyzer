<?php

namespace Userstory\ComponentBase\validators;

use yii\validators\DateValidator;
use yii\validators\DefaultValueValidator;
use yii\validators\EachValidator;
use yii\validators\ExistValidator;
use yii\validators\SafeValidator;
use yii\validators\UniqueValidator;
use yii\validators\Validator as YiiValidator;

/**
 * Class Validator.
 * Базовый класс для всех валидаторов.
 * Переопределение требуется что бы можно мыло использовать jquery3.
 *
 * @deprecated функциональность jquery3 теперь уже есть в Yii
 */
class Validator extends YiiValidator
{
    /**
     * Список предопределенных валидаторов.
     *
     * @var array
     */
    public static $builtInValidators = [
        'boolean'  => BooleanValidator::class,
        'captcha'  => 'yii\captcha\CaptchaValidator',
        'compare'  => CompareValidator::class,
        'date'     => DateValidator::class,
        'default'  => DefaultValueValidator::class,
        'double'   => NumberValidator::class,
        'each'     => EachValidator::class,
        'email'    => EmailValidator::class,
        'exist'    => ExistValidator::class,
        'file'     => FileValidator::class,
        'filter'   => FilterValidator::class,
        'image'    => ImageValidator::class,
        'in'       => RangeValidator::class,
        'integer'  => [
            'class'       => NumberValidator::class,
            'integerOnly' => true,
        ],
        'match'    => RegularExpressionValidator::class,
        'number'   => NumberValidator::class,
        'required' => RequiredValidator::class,
        'safe'     => SafeValidator::class,
        'string'   => StringValidator::class,
        'trim'     => [
            'class'       => FilterValidator::class,
            'filter'      => 'trim',
            'skipOnArray' => true,
        ],
        'unique'   => UniqueValidator::class,
        'url'      => UrlValidator::class,
        'ip'       => IpValidator::class,
    ];
}
