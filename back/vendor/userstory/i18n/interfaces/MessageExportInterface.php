<?php

namespace Userstory\I18n\interfaces;

use Userstory\ComponentHelpers\helpers\exceptions\FileNotCloseException;
use Userstory\ComponentHelpers\helpers\exceptions\FileNotLockException;
use Userstory\ComponentHelpers\helpers\exceptions\FileNotOpenException;
use Userstory\ComponentHelpers\helpers\exceptions\FileNotUnlockException;
use Userstory\ComponentHelpers\helpers\exceptions\FileNotWriteException;
use Userstory\ComponentHelpers\helpers\exceptions\IsNotWritableException;
use yii\base\ExitException;
use yii\base\InvalidConfigException;
use yii\web\RangeNotSatisfiableHttpException;

/**
 * Интерфейс MessageExportInterface объявляет методы экспорта переводов.
 *
 * @package Userstory\I18n\interfaces
 */
interface MessageExportInterface
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
    public function send(LanguageInterface $language);

    /**
     * Получения пути до файла с переводами.
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
    public function getFilePath(LanguageInterface $language);
}
