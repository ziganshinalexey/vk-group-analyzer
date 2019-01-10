<?php

namespace Userstory\User\models;

use yii\base\BaseObject;

/**
 * Class ResultModel.
 * Класс результата аутентификации позаимоствован у ZendFramework2.
 *
 * @package   Userstory\User\Authentication
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
class ResultModel extends BaseObject
{
    /**
     * Общая ошибка аутентификации без выраженных причин.
     */
    const FAILURE = 0;

    /**
     * Ошибка аутентификации для случая когда логин не найден.
     */
    const FAILURE_IDENTITY_NOT_FOUND = - 1;

    /**
     * Ошибка аутентификации для случая двусмысленности (несколько логинов).
     */
    const FAILURE_IDENTITY_AMBIGUOUS = - 2;

    /**
     * Ошибка аутентификации для случае неверного пароля.
     */
    const FAILURE_CREDENTIAL_INVALID = - 3;

    /**
     * Ошибка аутентификации для некатегоризированных случаев.
     */
    const FAILURE_UNCATEGORIZED = - 4;

    /**
     * Аутентификация была успешно осуществлена.
     */
    const SUCCESS = 1;

    /**
     * Свойство, содержащее код результата аутентификации.
     *
     * @var integer|null
     */
    protected $code;

    /**
     * Профиль пользователя при успешной аутентификации.
     *
     * @var mixed|null
     */
    protected $identity;

    /**
     * Массив причин, почему попытка аутентификации была не успешной.
     *
     * Для успешной аутентификации массив должен быть пустым.
     *
     * @var array|null
     */
    protected $messages;

    /**
     * Конструктор класса, устанавливает код результата аутентификации, профайл и (если необходимо) причины неудачной аутентификации.
     *
     * @param integer     $code     код результата аутентификации.
     * @param mixed       $identity профиль аутентифицированного пользователя.
     * @param array       $messages массив причин, по которым аутентификация была не успешной.
     * @param array|mixed $config   Конфигурация объекта.
     */
    public function __construct($code, $identity, array $messages = [], $config = [])
    {
        $this->code     = (int)$code;
        $this->identity = $identity;
        $this->messages = $messages;

        parent::__construct($config);
    }

    /**
     * Возвращает истину для случая успешнноой аутентификации.
     *
     * @return boolean
     */
    public function isValid()
    {
        return $this->code > 0;
    }

    /**
     * Возвращает код результата аутентификации.
     *
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Возвращает профиль пользователя.
     *
     * @return mixed
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * Возвращает массив причин по которым аутентификация не была успешна.
     *
     * Если аутентификация была успешно, будет возвращено null значение.
     *
     * @return array|null
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Метод задает код результата аутентификации.
     *
     * @param integer|null $code Значение для установки.
     *
     * @return static
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Метод задает профиль пользователя при успешной аутентификации.
     *
     * @param mixed|null $identity Значение для установки.
     *
     * @return static
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
        return $this;
    }

    /**
     * Метод задает массив причин, почему попытка аутентификации была не успешной.
     *
     * @param array|null $messages Значение для установки.
     *
     * @return static
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;
        return $this;
    }
}
