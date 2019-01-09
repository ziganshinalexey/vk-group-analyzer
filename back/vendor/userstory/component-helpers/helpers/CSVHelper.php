<?php

namespace Userstory\ComponentHelpers\helpers;

use yii\base\Exception;

/**
 * Class CSVHelper.
 * Класс-помощник для работы с csv файлами.
 *
 * @package Userstory\ComponentHelpers\helpers
 */
class CSVHelper
{
    /**
     * Метод конвертирует массив c константами в csv.
     *
     * @param array  $data      Массив с данными.
     * @param string $delimiter Используемый разделитель.
     *
     * @return string
     */
    public static function getCsv(array $data, $delimiter = ';')
    {
        $csv = fopen('php://temp', 'rb+');
        foreach ($data as $row) {
            FileHelper::putCsv($csv, $row, $delimiter);
        }

        rewind($csv);
        $output = stream_get_contents($csv);
        fclose($csv);
        return $output;
    }

    /**
     * Метод конвертирует CSV в массив данных.
     *
     * @param string $filePath  Путь к файлу с данными.
     * @param string $delimiter Используемый разделитель.
     *
     * @throws Exception Исключение, если не удалось открыть файл.
     *
     * @return array
     */
    public static function fromCsv($filePath, $delimiter = ';')
    {
        if (false === ( $handle = fopen($filePath, 'rb') )) {
            throw new Exception('Cannot open input CSV file');
        }

        $result = [];

        while (false !== ( $data = FileHelper::getCsv($handle, 0, $delimiter) )) {
            $result[] = $data;
        }

        fclose($handle);

        return $result;
    }
}
