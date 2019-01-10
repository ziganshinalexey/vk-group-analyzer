<?php

namespace Userstory\ComponentLog\loggers;

use DateTime;
use yii;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\log\FileTarget as YiiFileTarget;
use Userstory\ComponentHelpers\helpers\FileHelper;

/**
 * Class FileTarget.
 * Переопределяем вид записи логов для очереди рассылки.
 *
 * @package Userstory\ComponentBase\logs
 */
class FileTarget extends YiiFileTarget
{
    /**
     * Список PHP-переменных, которые должны добавлятьсяк к каждому сообщению,
     * тут они не нужны, поэтому переопределяем в пустой массив.
     *
     * @var array
     */
    public $logVars = [];

    /**
     * Путь до папки куда будут складироваться файлы.
     *
     * @var string
     */
    protected $logPath = '';

    /**
     * Количество дней жизни лог-файла, если ноль то удаляться не будут.
     *
     * @var integer;
     */
    protected $daysLife = 0;

    /**
     * Путь до шаблона записи в лог-файл.
     *
     * @var null|string
     */
    protected $templatePath;

    /**
     * Указать Путь до шаблона записи в лог-файл.
     *
     * @param string $value путь до папки.
     *
     * @return void
     */
    public function setTemplatePath($value)
    {
        $this->templatePath = $value;
    }

    /**
     * получить Путь до шаблона записи в лог-файл.
     *
     * @return null|string
     */
    public function getTemplatePath()
    {
        return $this->templatePath;
    }

    /**
     * Инициализация, переопределяем название файла лога.
     *
     * @return void
     * @throws Exception если забыли указать путь в конфиге.
     */
    public function init()
    {
        if (empty( $this->logPath )) {
            throw new Exception('Не определен logPath,  путь до папки где будут сохраниться файлы логов.');
        }
        parent::init();
    }

    /**
     * Получить Количество дней жизни лог-файла.
     *
     * @return integer
     */
    public function getDaysLife()
    {
        return $this->daysLife;
    }

    /**
     * Указать Количество дней жизни лог-файла.
     *
     * @param integer $value колличество дней.
     *
     * @return void
     */
    public function setDaysLife($value)
    {
        $this->daysLife = $value;
    }

    /**
     * Получить Путь до папки куда будут складироваться файлы.
     *
     * @return string
     */
    public function getLogPath()
    {
        return $this->logPath;
    }

    /**
     * Указать Путь до папки куда будут складироваться файлы.
     *
     * @param string $value путь до папкт с логами.
     *
     * @return void
     */
    public function setLogPath($value)
    {
        $this->logPath = $value;
    }

    /**
     * Здесь формируется сообщение в нужный вид перед записью в лог.
     *
     * @param array|null $message сообщение, массив формируется как-то в родительском классе.
     *
     * @return null|string
     *
     * @throws InvalidParamException не найден файл-шаблон (templatePath) формата сообщения.
     */
    public function formatMessage($message)
    {
        if (empty( $this->templatePath )) {
            return parent::formatMessage($message);
        }
        list( $text, $level, $category, $timestamp ) = $message;

        $this->logFile = $this->getLogFilePath($category);

        $date = new DateTime();
        $date->setTimestamp($timestamp);

        $params = [
            'text'     => $text,
            'level'    => $level,
            'category' => $category,
            'date'     => $date,
        ];

        return Yii::$app->getView()->render($this->getTemplatePath(), $params);
    }

    /**
     * Возвращает путь формата <директория с логами>/<сущность>/<год>/<месяц>/<день>.log.
     *
     * @param string $category имя категории.
     *
     * @return string
     */
    protected function getLogFilePath($category)
    {
        $ds       = DIRECTORY_SEPARATOR;
        $datetime = new DateTime();
        $year     = $datetime->format('Y');
        $month    = $datetime->format('m');
        $day      = $datetime->format('d');
        $path     = Yii::getAlias($this->logPath) . $ds . $category . $ds . $year . $ds . $month;

        if (! FileHelper::fileExists($path)) {
            FileHelper::createDirectory($path);
        }

        return $path . $ds . $day . '.log';
    }
}
