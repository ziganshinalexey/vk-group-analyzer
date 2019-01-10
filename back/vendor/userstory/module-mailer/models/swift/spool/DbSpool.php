<?php

namespace Userstory\ModuleMailer\models\swift\spool;

use Exception;
use Swift_ConfigurableSpool;
use Swift_Mime_Message;
use Swift_Transport;
use Userstory\ModuleMailer\entities\Mailer;
use Userstory\ModuleMailer\models\swift\spool\traits\SpoolTrait;

/**
 * Class DbSpool.
 * Организация очереди рассылки через базу данных.
 *
 * @package Userstory\ModuleMailer\components\swift\spool
 */
class DbSpool extends Swift_ConfigurableSpool
{

    use SpoolTrait;

    /**
     * Имя модели для хранения очереди.
     *
     * @var string
     */
    private $modelName = Mailer::class;

    /**
     * Конструктор инициализация объекта очереди рассылки.
     *
     * @param integer $messageLimit ограничение на количество отправляемых писем.
     * @param string  $modelName    модель где хранится очередь.
     * @param string  $cacheKey     ключь хранения статуса занят/свободен.
     */
    public function __construct($messageLimit = 20, $modelName = null, $cacheKey = null)
    {
        if (null !== $modelName) {
            $this->modelName = $modelName;
        }

        $this->init($messageLimit, $cacheKey);
    }

    /**
     * Добавить в очередь рассылки база данных.
     *
     * @param Swift_Mime_Message $message подготовленное сообщение.
     *
     * @return boolean
     */
    public function queueMessage(Swift_Mime_Message $message)
    {
        $model = new $this->modelName();
        $model->setMessage($message);
        $model->priority = $message->getPriority();

        return $model->save();
    }

    /**
     * Отправление почты из очереди рассылки организованная через базу данных.
     *
     * @param Swift_Transport $transport        Транспорт отправки почты.
     * @param string          $failedRecipients Массив адресов для отчетов.
     *
     * @return array отчет операции.
     */
    public function flushQueue(Swift_Transport $transport, &$failedRecipients = null)
    {
        if ($this->isStarted()) {
            $this->reportException('Рассылка уже запущена. Принудительный сброс: yiic mailer/send/reset');

            return $this->getReport();
        }

        $this->start();

        $model = new $this->modelName();
        $items = $model->listItems($this->getMessageLimit());

        if (count($items) && ! $transport->isStarted()) {
            $transport->start();
        }

        foreach ($items as $item) {
            $message = $item->getMessage();
            try {
                if ($transport->send($message, $failedRecipients)) {
                    $this->reportSuccess($message);
                } else {
                    $this->reportError($message);
                }
            } catch (Exception $e) {
                $this->reportError($message);
            }
            $item->delete();
        }

        $this->stop();

        return $this->getReport();
    }
}
