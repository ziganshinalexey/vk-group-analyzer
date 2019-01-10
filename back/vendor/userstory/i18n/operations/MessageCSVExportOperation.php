<?php

namespace Userstory\I18n\operations;

use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\ComponentHelpers\helpers\CSVHelper;
use Userstory\ComponentHelpers\helpers\exceptions\FileNotCloseException;
use Userstory\ComponentHelpers\helpers\exceptions\FileNotLockException;
use Userstory\ComponentHelpers\helpers\exceptions\FileNotOpenException;
use Userstory\ComponentHelpers\helpers\exceptions\FileNotUnlockException;
use Userstory\ComponentHelpers\helpers\exceptions\FileNotWriteException;
use Userstory\ComponentHelpers\helpers\exceptions\IsNotWritableException;
use Userstory\ComponentHelpers\helpers\FileHelper;
use Userstory\I18n\interfaces\LanguageInterface;
use Userstory\I18n\interfaces\MessageExportInterface;
use yii;
use yii\base\ExitException;
use yii\base\InvalidConfigException;
use yii\web\RangeNotSatisfiableHttpException;

/**
 * Класс MessageCSVExportOperation реализует отправку файла клиенту.
 *
 * @package Userstory\I18n\operations
 */
class MessageCSVExportOperation extends AbstractMessageExportOperation implements MessageExportInterface
{
    /**
     * Метод отправки файла клиенту.
     *
     * @param LanguageInterface $language Сущность языка.
     *
     * @return void
     *
     * @throws ExitException Генерирует в случает неверной конфигурации.
     * @throws InvalidConfigException Генерирует в случает неверной конфигурации.
     * @throws RangeNotSatisfiableHttpException Генерирует в случает неверной конфигурации.
     */
    public function send(LanguageInterface $language)
    {
        $content = ArrayHelper::merge([$this->getColumnLabels()], $this->getContent($language->getId()));
        $csvData = CSVHelper::getCsv($content);
        Yii::$app->response->sendContentAsFile($csvData, 'constants_' . $language->getName() . '.csv');
        Yii::$app->end();
    }

    /**
     * Получения пути до файлас с переводами.
     *
     * @param LanguageInterface $language Сущность языка.
     *
     * @return string
     *
     * @throws InvalidConfigException Генерирует в случает неверной конфигурации.
     * @throws FileNotCloseException Генерирует в случае неправильной работы с файлами.
     * @throws FileNotLockException Генерирует в случае неправильной работы с файлами.
     * @throws FileNotOpenException Генерирует в случае неправильной работы с файлами.
     * @throws FileNotUnlockException Генерирует в случае неправильной работы с файлами.
     * @throws FileNotWriteException Генерирует в случае неправильной работы с файлами.
     * @throws IsNotWritableException Генерирует в случае неправильной работы с файлами.
     */
    public function getFilePath(LanguageInterface $language)
    {
        $tmpFileName = FileHelper::createTempFile('KIPS-csv-');
        $content     = ArrayHelper::merge([$this->getColumnLabels()], $this->getContent($language->getId()));
        $csvData     = CSVHelper::getCsv($content);
        FileHelper::fileWrite($tmpFileName, $csvData);
        return $tmpFileName;
    }
}
