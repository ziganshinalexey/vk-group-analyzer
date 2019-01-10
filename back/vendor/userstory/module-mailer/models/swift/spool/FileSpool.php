<?php

namespace Userstory\ModuleMailer\models\swift\spool;

use DirectoryIterator;
use Swift_FileSpool;
use Swift_Transport;
use Userstory\ModuleMailer\models\swift\spool\traits\SpoolTrait;
use Userstory\ComponentHelpers\helpers\FileHelper;

/**
 * Class FileSpool.
 * Организация очереди рассылки через файлы.
 *
 * @package Userstory\ModuleMailer\models\swift\spool
 */
class FileSpool extends Swift_FileSpool
{

    use SpoolTrait;

    /**
     * Путь где будет распологаться хранилище.
     *
     * @var string|null
     */
    private $path;

    /**
     * Конструктор инициализация объекта очереди рассылки.
     *
     * @param string      $path         путь где будет распологаться хранилище.
     * @param integer     $messageLimit ограничение на количество отправляемых писем.
     * @param string|null $cacheKey     ключь хранения статуса занят/свободен.
     *
     * @throws \Swift_IoException наследуемое исключение.
     */
    public function __construct($path, $messageLimit = 20, $cacheKey = null)
    {
        parent::__construct($path);
        $this->path = $path;
        $this->init($messageLimit, $cacheKey);
    }

    /**
     * Отправление почты из очереди рассылки организованная через файловое хранилище.
     *
     * @param Swift_Transport   $transport        Транспорт отправки почты.
     * @param string|array|null $failedRecipients Массив адресов для отчетов.
     *
     * @return array отчет операции.
     */
    public function flushQueue(Swift_Transport $transport, &$failedRecipients = null)
    {
        if ($this->isStarted()) {
            $this->reportException('Рассылка уже запущена. Принудительный сброс: yiic mailer/send/reset');

            return $this->getReport();
        }

        $failedRecipients  = (array)$failedRecipients;
        $directoryIterator = new DirectoryIterator($this->path);
        $count             = 0;
        $time              = time();

        $this->start();

        $this->transportStart($transport, $directoryIterator);

        foreach ($directoryIterator as $file) {

            $file = $file->getRealPath();

            if ($this->skipIteration($file)) {
                continue;
            }

            $message = unserialize(file_get_contents($file . '.sending'));

            if ($transport->send($message, $failedRecipients)) {
                ++ $count;
                $this->reportSuccess($message);
            } else {
                $this->reportError($message);
            }
            FileHelper::unlink($file . '.sending');

            if ($this->checkLimit($count, $time)) {
                break;
            }
        }
        $this->stop();
        return $this->getReport();
    }

    /**
     * Разрешаем работу по отправке, если есть наличие фалов.
     *
     * @param Swift_Transport   $transport         Транспорт отправки почты.
     * @param DirectoryIterator $directoryIterator подготовленный интерпритатор директорий.
     *
     * @return void
     */
    protected function transportStart(Swift_Transport &$transport, DirectoryIterator $directoryIterator)
    {
        if (! $transport->isStarted()) {
            foreach ($directoryIterator as $file) {
                if (substr($file->getRealPath(), - 8) === '.message') {
                    $transport->start();
                    break;
                }
            }
        }
    }

    /**
     * Необходимость прирвать рассылку, если вышел лимит по количеству или по времени.
     *
     * @param integer $count сколько уже было отправленно.
     * @param string  $time  время начала выолнения скрипта.
     *
     * @return boolean
     */
    protected function checkLimit($count, $time)
    {
        if ($this->getMessageLimit() && $count >= $this->getMessageLimit()) {
            return true;
        }

        if ($this->getTimeLimit() && (time() - $time) >= $this->getTimeLimit()) {
            return true;
        }

        return false;
    }

    /**
     * Пропустить итерацию отправки, если файл уже в обработке.
     *
     * @param string $file путь до файла с сообщением.
     *
     * @return boolean
     */
    protected function skipIteration($file)
    {
        if (substr($file, - 8) !== '.message' || ! FileHelper::rename($file, $file . '.sending')) {
            return true;
        }

        return false;
    }
}
