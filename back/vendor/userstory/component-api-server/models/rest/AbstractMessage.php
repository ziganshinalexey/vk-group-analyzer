<?php

namespace Userstory\ComponentApiServer\models\rest;

use yii\base\BaseObject;

/**
 * Class AbstractMessage.
 * Базовый класс для пользовательских сообщений.
 *
 * @SWG\Definition(
 *     type="object",
 *     definition="Error",
 * )
 *
 * @property integer $code   Код сообщения.
 * @property string  $title  Заголовок сообщения.
 * @property string  $detail Подробное описание сообщения.
 * @property mixed   $data   Дополнительные данные сообщения.
 *
 * @package Userstory\ComponentApiServer\models\rest
 */
class AbstractMessage extends BaseObject
{
    /**
     * Числовой идентификатор сообщения.
     *
     * @var integer|null
     *
     * @SWG\Property()
     */
    protected $code;

    /**
     * Краткое описание сообщения для отправки.
     *
     * @var string|null
     *
     * @SWG\Property()
     */
    protected $title;

    /**
     * Детальное описание сообщения для отправки.
     *
     * @var string|null
     *
     * @SWG\Property()
     */
    protected $detail;

    /**
     * Дополнительные данные идентифицирующие сообщение.
     *
     * @var mixed|null
     *
     * @SWG\Property(@SWG\Items())
     */
    protected $data;

    /**
     * Сеттер для установки числового идентификатора сообщения.
     *
     * @param integer $code Идентификатор сообщения.
     *
     * @return static
     */
    protected function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Геттер возвращает числовой идентификатор сообщения.
     *
     * @return integer
     */
    protected function getCode()
    {
        return $this->code;
    }

    /**
     * Сеттер для установки описания сообщения.
     *
     * @param string $title Описание сообщения.
     *
     * @return static
     */
    protected function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Геттер возвращает описание сообщения.
     *
     * @return string
     */
    protected function getTitle()
    {
        return $this->title;
    }

    /**
     * Сеттер для установки детального описания сообщения.
     *
     * @param string $detail Детальное описание сообщения.
     *
     * @return static
     */
    protected function setDetail($detail)
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * Геттер возвращает детальное описание сообщения.
     *
     * @return string
     */
    protected function getDetail()
    {
        return $this->detail;
    }

    /**
     * Сеттер для установки дополнительных данных по сообщения.
     *
     * @param mixed $data Дополнительные данные.
     *
     * @return static
     */
    protected function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Геттер возвращает дополнительные данные по сообщению.
     *
     * @return mixed
     */
    protected function getData()
    {
        return $this->data;
    }
}
