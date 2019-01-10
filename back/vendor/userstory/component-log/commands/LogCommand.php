<?php

namespace Userstory\ComponentLog\commands;

use DateInterval;
use DateTime;
use Userstory\ComponentLog\loggers\FileTarget;
use yii;
use yii\base\InvalidParamException;
use yii\console\Controller;
use yii\helpers\Console;
use yii\helpers\VarDumper;
use Userstory\ComponentHelpers\helpers\FileHelper;

/**
 * Class LogController.
 * Консольные комманды по управлению логов смс.
 *
 * @package Userstory\ModuleMailer\commands
 */
class LogCommand extends Controller
{
    /**
     * Удаление старых логов, запускаем с крона.
     *
     * @throws InvalidParamException Если алиас неверный.
     *
     * @return void
     */
    public function actionRemove()
    {
        foreach (Yii::$app->getLog()->getLogger()->dispatcher->targets as $target) {
            if (! $target instanceof FileTarget) {
                continue;
            }
            $path = Yii::getAlias($target->logPath);
            $days = $target->daysLife;
            if ($files = $this->searchFiles($path, $days)) {
                $this->removeFiles($files);
                Console::output((string)VarDumper::export($files));
            } else {
                Console::output('Файлов для удаления не найдено!');
            }
        }
    }

    /**
     * Поиск файлов на удаление.
     *
     * @param string  $path Путь до папки где хранятся файлы логов.
     * @param integer $days Время жизни файлов лога, в днях.
     *
     * @throws InvalidParamException Если $path не верный.
     *
     * @return array|boolean
     */
    protected function searchFiles($path, $days)
    {
        if (empty($path) || ! $days || (! FileHelper::isDirectory($path))) {
            return false;
        }
        $result = [];

        $files = FileHelper::findFiles($path);

        $date     = new DateTime();
        $lastDate = $date->sub(new DateInterval('P' . $days . 'D'))->getTimestamp();

        foreach ($files as $file) {
            if ($lastDate >= filemtime($file)) {
                $result[] = $file;
            }
        }

        return count($result) ? $result : false;
    }

    /**
     * Удаление файлов лога по списку.
     *
     * @param array $files спсисок путей до файлов, которые будем удалять.
     *
     * @return void
     */
    protected function removeFiles(array $files)
    {
        foreach ($files as $file) {
            if (! (FileHelper::isFile($file) && FileHelper::isWritable($file) && FileHelper::unlink($file))) {
                Console::output('Файл не найден или недостаточно прав для удаления: ' . $file);
            }
        }
    }
}
