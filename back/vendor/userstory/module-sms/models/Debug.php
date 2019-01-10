<?php

namespace Userstory\ModuleSms\models;

/**
 * Class Debug.
 * Провайдер Debug который ничего не отправляет, является заглушкой.
 *
 * @package Userstory\ModuleUser\components\SmsProvider
 */
class Debug extends AbstractProvider
{
    /**
     * Номер для отправки сообщения.
     *
     * @var null|string|integer
     */
    protected $number;

    /**
     * Сообщение для отправки получателю.
     *
     * @var null|string
     */
    protected $message;

    /**
     * Список обязательных параметров для пересылки.
     *
     * @var array
     */
    protected $required = [
        'number',
        'message',
    ];

    /**
     * Сам процесс отправки сообщения.
     *
     * @return boolean
     */
    protected function sent()
    {
        return true;
    }

    /**
     * Подготовка параметров к отправки.
     *
     * @return array
     */
    protected function preparePostFields()
    {
        return [];
    }

    /**
     * Ответ от провайдера преобразуем в удобный вид.
     *
     * @param string $response ответ в каком-то формате.
     *
     * @inherit
     *
     * @return void
     */
    protected function parseResponse($response)
    {
        $this->response = ['debug'];
    }

    /**
     * Наличие ошибок после отправки.
     *
     * @return boolean
     */
    protected function hasErrors()
    {
        return false;
    }

    /**
     * Указать получателя сообщения.
     *
     * @param string|integer $to номер телефона получателя.
     *
     * @return void
     */
    protected function setAttributeTo($to)
    {
        $this->setNumber($to);
    }

    /**
     * Указать текст сообщения для отправки.
     *
     * @param string $message текст сообщения.
     *
     * @return void
     */
    protected function setAttributeMessage($message)
    {
        $this->setMessage($message);
    }

    /**
     * Получить получателя сообщения.
     *
     * @return string|integer
     */
    protected function getAttributeTo()
    {
        return $this->getNumber();
    }

    /**
     * Получить текст сообщения.
     *
     * @return string
     */
    protected function getAttributeMessage()
    {
        return $this->getMessage();
    }

    /**
     * Устанавливаем значение для атрибута.
     *
     * @param string|integer $value значение для атрибута.
     *
     * @return static
     */
    public function setNumber($value)
    {
        $this->number = $value;
        return $this;
    }

    /**
     * Устанавливаем значение для атрибута.
     *
     * @param string $value значение для атрибута.
     *
     * @return static
     */
    public function setMessage($value)
    {
        $this->message = $value;
        return $this;
    }

    /**
     * Получаем значение для атрибута.
     *
     * @return integer|null|string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Получаем значение для атрибута.
     *
     * @return null|string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
