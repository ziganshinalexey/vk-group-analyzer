<?php

namespace Userstory\ComponentHelpers\helpers;

use DateTime;
use DateTimeZone;
use yii;

/**
 * Class DateHelper.
 * Класс хелпера дял работы с датой и временем.
 *
 * @package Userstory\ComponentHelpers\helpers
 */
class DateHelper
{
    /**
     * Дефолный формат даты в системе.
     *
     * @var string
     */
    const DEFAULT_DATE_FORMAT = 'Y-m-d';

    /**
     * Дефолный формат даты и времени в системе.
     *
     * @var string
     */
    const DEFAULT_DATETIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * Паттерн для всех дат, вводимых в интерфейсе.
     *
     * @var string
     */
    protected static $datePattern = '(0?[1-9]|[12][0-9]|3[01])\/(0?[1-9]|1[012])\/(20\d\d)';

    /**
     * Метод создает новый объект.
     *
     * @param string       $time     Строка даты для преобразования в объект.
     * @param DateTimeZone $timezone Объект временной зоны.
     *
     * @return DateTime
     */
    public static function create($time = 'now', DateTimeZone $timezone = null)
    {
        return new DateTime($time, $timezone);
    }

    /**
     * Метод создает объект на основе переданного формата.
     *
     * @param string       $format   Формат для нового объекта.
     * @param string       $time     Текущая даты/время для преобразования в объект.
     * @param DateTimeZone $timezone Временная зона.
     *
     * @return DateTime
     */
    public static function createFromFormat($format, $time, DateTimeZone $timezone = null)
    {
        if (null === $timezone) {
            $timezone = new DateTimeZone(Yii::$app->timeZone);
        }

        return DateTime::createFromFormat($format, $time, $timezone);
    }

    /**
     * Метод создает объект временной зоны.
     *
     * @param string $timezone Временная зона.
     *
     * @return DateTimeZone
     */
    public static function createTimezone($timezone)
    {
        return new DateTimeZone($timezone);
    }

    /**
     * Метод парсит диапазон дат и возвращает список DateTime.
     *
     * @param string $range Диапазон дат.
     *
     * @return DateTime[]
     */
    public static function getParsedRange($range)
    {
        $arr = explode('-', preg_replace('/\s+/', '', $range));
        if (2 === count($arr)) {
            list ($from, $to) = $arr;
        } else {
            $from = null;
            $to   = null;
        }

        $fromFormat = DateTime::createFromFormat('d/m/Y', $from);
        $toDate     = DateTime::createFromFormat('d/m/Y', $to);

        return [
            $fromFormat,
            $toDate,
        ];
    }

    /**
     * Метод возвращает паттерн проверки диапазона дат.
     *
     * @return string
     */
    public static function getRangePattern()
    {
        return '/' . self::$datePattern . '\s*-\s*' . self::$datePattern . '/';
    }

    /**
     * Метод возвращает сконвертированный формат даты для поиска в базе.
     *
     * @param DateTime|mixed $date Дата для конвертации.
     *
     * @return string
     */
    protected static function getDateFormatDB($date)
    {
        return $date instanceof DateTime ? $date->format('Y-m-d') : '';
    }

    /**
     * Метод преобразует дату в формате ISO-8601 в формат для базы либо другой заданный.
     *
     * @param string $date   Дата для преобразования.
     * @param string $format Конечный формат для преобразования.
     *
     * @return string
     */
    public static function convertFromISO8601($date, $format = 'Y-m-d H:i:s')
    {
        $dateTime = new DateTime($date);
        return $dateTime->format($format);
    }

    /**
     * Метод преобразует дату в формат ISO-8601.
     *
     * @param string $date   Дата для преобразования.
     * @param string $format Формат преобразуемой даты.
     *
     * @return string
     */
    public static function convertToISO8601($date = 'now', $format = null)
    {
        $dateTime = $format ? static::createFromFormat($format, $date) : static::create($date);
        return $dateTime->format(DateTime::ISO8601);
    }

    /**
     * Метод парсит диапазон дат и возвращает список дат в формате БД.
     *
     * @param string $range Диапазон дат.
     *
     * @return array
     */
    public static function getParsedDBRange($range)
    {
        list($from, $to) = self::getParsedRange($range);

        return [
            self::getDateFormatDB($from),
            self::getDateFormatDB($to),
        ];
    }

    /**
     * Форматирует таймстемп в указанный формат даты или использует дефолтный формат.
     *
     * @param integer     $unixtime Таймстемп, который нужно отформатировать.
     * @param string|null $format   Формат для вывода даты.
     *
     * @return false|string
     */
    public static function unixtimeDateFormat($unixtime, $format = null)
    {
        if (null === $format) {
            $format = isset(Yii::$app->params['dateFormat']) ? Yii::$app->params['dateFormat'] : static::DEFAULT_DATE_FORMAT;
        }
        return date($format, $unixtime);
    }
}
