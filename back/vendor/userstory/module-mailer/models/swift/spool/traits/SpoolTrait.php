<?php

namespace Userstory\ModuleMailer\models\swift\spool\traits;

use Exception;
use Swift_Mime_Message;
use yii;
use yii\log\Logger;

/**
 * Class SpoolTrait.
 * Трейт объявляет дополнительный функционал для организации очереди рассылки.
 *
 * @package Userstory\ModuleMailer\models\swift\spool
 */
trait SpoolTrait
{
    /**
     * Ключь хранения статуса занят/свободен.
     *
     * @var string
     */
    private $cacheKey = 'MailerSendCommand';

    /**
     * Здесь будет вестись отчет о выполнении рассылки.
     *
     * @var array
     */
    private $report = [];

    /**
     * Общая инициализация для любого вида очереди.
     *
     * @param integer     $messageLimit ограничение на количество отправляемых писем.
     * @param string|null $cacheKey     ключь хранения статуса занят/свободен.
     *
     * @return void
     */
    protected function init($messageLimit = 20, $cacheKey = null)
    {
        $this->setMessageLimit($messageLimit);
        $this->cacheKey = $cacheKey ? : $this->cacheKey;
    }

    /**
     * Указываем что рассылка запущена.
     *
     * @return void
     */
    public function start()
    {
        Yii::$app->getCache()->set($this->cacheKey, date('d-m-Y H:i:s'), 3600);
    }

    /**
     * Указываем что рассылка завершена.
     *
     * @return void
     */
    public function stop()
    {
        Yii::$app->getCache()->delete($this->cacheKey);
    }

    /**
     * Узнать состояние рассылки.
     *
     * @return boolean
     */
    public function isStarted()
    {
        return (bool)Yii::$app->getCache()->get($this->cacheKey);
    }

    /**
     * Добавляем сообщение в лог.
     *
     * @param mixed $message сообщение в лог.
     *
     * @return void
     */
    public function logger($message)
    {
        try {
            Yii::$app->getLog()->getLogger()->log($message, Logger::LEVEL_INFO, 'USMailer');
        } catch (Exception $e) {
            // Ошибка логирования не должна влиять на рассылку.
            return;
        }
    }

    /**
     * Формирование отчета отправки сообщений.
     *
     * @param Swift_Mime_Message|null $message    отправляемое сообщение.
     * @param string                  $customText дополнительный текст.
     *
     * @return void
     */
    protected function reportMessage(Swift_Mime_Message $message = null, $customText = null)
    {
        if (null !== $message) {
            $emails     = [];
            $recipients = $this->getAllRecipients($message);

            foreach ($recipients as $key => $value) {
                if (is_int($key)) {
                    $emails[] = $value;
                } else {
                    $emails[] = $key;
                }
            }
            $text = $this->createLogMessage($message, $emails, $customText);
        } else {
            $text = $customText;
        }
        $this->logger($text);
        $this->report[] = $text;
    }

    /**
     * Получить всех получателей письма.
     *
     * @param Swift_Mime_Message $message сообщение которое отправлялось.
     *
     * @return array
     */
    protected function getAllRecipients(Swift_Mime_Message $message)
    {
        return array_merge((array)$message->getTo(), (array)$message->getCc(), (array)$message->getBcc());
    }

    /**
     * Шаблон генерируемого сообщения в лог.
     *
     * @param Swift_Mime_Message $message    сообщение которое отправлялось.
     * @param array              $emails     адреса куда отправлялось сообщение.
     * @param string             $customText произвольный текст для лога.
     *
     * @return string
     */
    protected function createLogMessage(Swift_Mime_Message $message, array $emails, $customText)
    {
        return $message->getSubject() . '" ' . implode(',', $emails) . ' ' . $customText;
    }

    /**
     * Запись сообщения в лог при исключительной ошибки.
     *
     * @param string $message сообщение в лог.
     *
     * @return void
     */
    protected function reportException($message)
    {
        $this->reportMessage(null, $message);
    }

    /**
     * Запись отчета в лог при ошибки.
     *
     * @param Swift_Mime_Message $message отправляемое сообщение.
     *
     * @return void
     */
    protected function reportError(Swift_Mime_Message $message)
    {
        $this->reportMessage($message, 'FAIL');
    }

    /**
     * Запись отчета в лог если письмо ушло.
     *
     * @param Swift_Mime_Message $message отправляемое сообщение.
     *
     * @return void
     */
    protected function reportSuccess(Swift_Mime_Message $message)
    {
        $this->reportMessage($message, 'OK');
    }

    /**
     * Выдать сформированные отчет.
     *
     * @return array
     */
    protected function getReport()
    {
        return $this->report;
    }
}
