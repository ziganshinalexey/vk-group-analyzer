<?php

namespace Userstory\ModuleSms\models;

use Userstory\ModuleSms\exceptions\SmsProviderException;
use yii\base\Component;
use yii\base\UnknownPropertyException;
use yii\log\Logger;
use yii;

/**
 * Class AbstractProvider.
 * Абстрактный класс провайдера отправки сообщений на телефон.
 *
 * @package Userstory\ModuleUser\components\SmsProvider
 */
abstract class AbstractProvider extends Component
{
    /**
     * Название события перед отправкой сообщения.
     */
    const EVENT_BEFORE_SEND = 'beforeSend';

    /**
     * Название события после отправки сообщения.
     */
    const EVENT_AFTER_SEND = 'afterSend';

    /**
     * Название категории для логирования.
     */
    const LOG_CATEGORY_NAME = 'USSms';

    /**
     * Ссылка куда слать запрос.
     *
     * @var null|string
     */
    protected $url;

    /**
     * Список обязательных параметров для пересылки.
     *
     * @var array
     */
    protected $required = [];

    /**
     * Тут будет хранится ответ.
     *
     * @var null|mixed
     */
    protected $response;

    /**
     * Значения для параметров пересылки.
     *
     * @var array
     */
    protected $options = [];

    /**
     * Получить Список обязательных параметров для пересылки.
     *
     * @return array
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * Указать Список обязательных параметров для пересылки.
     *
     * @param array $value обязательные параметры.
     *
     * @return void
     */
    public function setRequired(array $value)
    {
        $this->required = $value;
    }

    /**
     * Получить Ссылку куда слать запрос.
     *
     * @return null|string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Указать Ссылку куда слать запрос.
     *
     * @param string $value ссылка запроса.
     *
     * @return void
     */
    public function setUrl($value)
    {
        $this->url = $value;
    }

    /**
     * Проверка на заполнение всех обязательных полей.
     *
     * @return boolean
     *
     * @throws SmsProviderException в случае неуспеха выкидываем исключение.
     * @throws UnknownPropertyException Если свойство не определено.
     */
    protected function check()
    {
        foreach ($this->required as $name) {
            if (null === $this->{$name}) {
                throw new SmsProviderException('не указан обязательный параметр: ' . $name);
            }
        }

        return true;
    }

    /**
     * Общий метод для отправки сообщения.
     *
     * @param null|string $to      кому, если ранеене определн.
     * @param null|string $message сообщение, если ранее не определено.
     *
     * @return boolean
     *
     * @throws SmsProviderException исключение в случае незаполнения всех обязательный параметров.
     */
    public function send($to = null, $message = null)
    {
        $this->response = null;
        null !== $to && $this->setAttributeTo($to);
        null !== $message && $this->setAttributeMessage($message);

        $this->check();
        $this->trigger(self::EVENT_BEFORE_SEND);
        $this->response = $this->parseResponse($this->sent());
        $this->trigger(self::EVENT_AFTER_SEND);

        $this->addMessageInLog($this->getFormatMessageInLog());

        return ! $this->hasErrors();
    }

    /**
     * Формирование сообщения для лога.
     *
     * @return string
     */
    protected function getFormatMessageInLog()
    {
        $message = $this->getAttributeTo() . ' ' . $this->getAttributeMessage();
        $message .= $this->hasErrors() ? ' FAIL' : ' OK';

        return $message;
    }

    /**
     * Добавляем в лог сообщение.
     *
     * @param string  $message  текстовое сообщение.
     * @param integer $level    уровень логирования.
     * @param string  $category категория логирования.
     *
     * @return void
     */
    protected function addMessageInLog($message, $level = Logger::LEVEL_INFO, $category = self::LOG_CATEGORY_NAME)
    {
        Yii::$app->getLog()->getLogger()->log($message, $level, $category);
    }

    /**
     * Ответ от провайдера преобразуем в удобный вид.
     *
     * @param mixed $response ответ в каком-то формате.
     *
     * @return mixed
     */
    abstract protected function parseResponse($response);

    /**
     * Сам процесс отправки сообщения.
     *
     * @return mixed
     */
    abstract protected function sent();

    /**
     * Наличие ошибок после отправки.
     *
     * @return boolean
     */
    abstract protected function hasErrors();

    /**
     * Указать получателя сообщения.
     *
     * @param string $to номер телефона получателя.
     *
     * @return void
     */
    abstract protected function setAttributeTo($to);

    /**
     * Получить получателя сообщения.
     *
     * @return string
     */
    abstract protected function getAttributeTo();

    /**
     * Указать текст сообщения для отправки.
     *
     * @param string $message текст сообщения.
     *
     * @return void
     */
    abstract protected function setAttributeMessage($message);

    /**
     * Получить текст сообщения.
     *
     * @return string
     */
    abstract protected function getAttributeMessage();
}
