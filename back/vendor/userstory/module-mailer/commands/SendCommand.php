<?php

namespace Userstory\ModuleMailer\commands;

use yii;
use yii\console\Controller;
use yii\helpers\Console;
use yii\helpers\VarDumper;

/**
 * Class SendCommand.
 * Класс для консольных комманд модуля.
 *
 * @package Userstory\ModuleMailer\commands
 */
class SendCommand extends Controller
{
    /**
     * Запуск рассылки из очереди.
     *
     * @return void
     */
    public function actionIndex()
    {
        $transport = Yii::$app->mailer->getTransport();

        $report = Yii::$app->queueMailer->getTransport()->getSpool()->flushQueue($transport);
        Console::output((string)VarDumper::export($report));
    }

    /**
     * Принудительный сброс статуса блокировки на очередную отправку.
     *
     * @return void
     */
    public function actionReset()
    {
        Yii::$app->queueMailer->getTransport()->getSpool()->stop();
    }
}
