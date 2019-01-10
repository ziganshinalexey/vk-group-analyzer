<?php

namespace Userstory\ModuleMailer\models\swift;

use Swift_Attachment;
use yii\swiftmailer\Message as SwiftMessage;

/**
 * Class Message.
 * Расширяем класс работы с почтовыми сообщениями.
 *
 * @package Userstory\ModuleMailer\models\swift
 */
class Message extends SwiftMessage
{
    /**
     * Кастомные заголовки для письма.
     *
     * @var array
     */
    private $customHeader = [];

    /**
     * Добавление почтовых адресов.
     *
     * @param string      $method  название метода.
     * @param string      $address емаил адрес.
     * @param string|null $name    имя владельца адреса.
     *
     * @return $this
     */
    private function addAddress($method, $address, $name = null)
    {
        if (is_array($address)) {
            if (is_string(key($address))) {
                $name    = current($address);
                $address = key($address);
            } else {
                $address = current($address);
                $name    = null;
            }
        }
        $this->getSwiftMessage()->{$method} ($address, $name);

        return $this;
    }

    /**
     * Удаление заголовка письма.
     *
     * @param string $name название заголовка.
     *
     * @return $this
     */
    public function clearHeader($name)
    {
        $this->getSwiftMessage()->getHeaders()->removeAll($name);
        return $this;
    }

    /**
     * Добавить отправителя письма.
     *
     * @param string      $address емаил адрес.
     * @param string|null $name    имя владельца адреса.
     *
     * @return Message
     */
    public function addFrom($address, $name = null)
    {
        return $this->addAddress('addFrom', $address, $name);
    }

    /**
     * Добавить получателя письма.
     *
     * @param string      $address емаил адрес.
     * @param string|null $name    имя владельца адреса.
     *
     * @return Message
     */
    public function addTo($address, $name = null)
    {
        return $this->addAddress('addTo', $address, $name);
    }

    /**
     * Добавить вторичных поучателей.
     *
     * @param string      $address емаил адрес.
     * @param string|null $name    имя владельца адреса.
     *
     * @return Message
     */
    public function addCc($address, $name = null)
    {
        return $this->addAddress('addCc', $address, $name);
    }

    /**
     * Добавить скрытых получателей.
     *
     * @param string      $address емаил адрес.
     * @param string|null $name    имя владельца адреса.
     *
     * @return Message
     */
    public function addBcc($address, $name = null)
    {
        return $this->addAddress('addBcc', $address, $name);
    }

    /**
     * Выставить приоритет письма.
     *
     * @param integer $priority номер приоритета.
     *
     * @return $this
     */
    public function setPriority($priority)
    {
        $this->getSwiftMessage()->setPriority($priority);

        return $this;
    }

    /**
     * Получить приоритет письма.
     *
     * @return integer
     */
    public function getPriority()
    {
        return $this->getSwiftMessage()->getPriority();
    }

    /**
     * Установить дату отсылки письма.
     *
     * @param string $date дата письма.
     *
     * @return $this
     */
    public function setDate($date)
    {
        $this->getSwiftMessage()->setDate($date);

        return $this;
    }

    /**
     * Получить дату письма отсылки.
     *
     * @return integer
     */
    public function getDate()
    {
        return $this->getSwiftMessage()->getDate();
    }

    /**
     * Получить адррес получателя отчета о недоставленом сообщении.
     *
     * @return string
     */
    public function getReturnPath()
    {
        return $this->getSwiftMessage()->getReturnPath();
    }

    /**
     * Адррес получателя отчета о недоставленом сообщении.
     *
     * @param string $address емаил получателя.
     *
     * @return $this
     */
    public function setReturnPath($address)
    {
        $this->getSwiftMessage()->setReturnPath($address);

        return $this;
    }

    /**
     * Оповещение о прочтении письма.
     *
     * @param string $address емайл кого уведомить.
     *
     * @return $this
     */
    public function setReadReceiptTo($address)
    {
        $this->getSwiftMessage()->setReadReceiptTo($address);

        return $this;
    }

    /**
     * Получить уведомителя о прочтении письма.
     *
     * @return string
     */
    public function getReadReceiptTo()
    {
        return $this->getSwiftMessage()->getReadReceiptTo();
    }

    /**
     * Указать уникальный индификатор письма.
     *
     * @param string $id айдишник письма.
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->getSwiftMessage()->setId($id);

        return $this;
    }

    /**
     * Получить айдишник письма.
     *
     * @return string
     */
    public function getId()
    {
        return $this->getSwiftMessage()->getId();
    }

    /**
     * Добавить произвольный заголовок письма.
     *
     * @param string      $name  ключь заголовка.
     * @param string|null $value значение заголовка.
     *
     * @return $this
     */
    public function setCustomHeader($name, $value = null)
    {
        if (in_array($name, $this->customHeader)) {
            $this->customHeader[] = $name;
        }
        $this->getSwiftMessage()->getHeaders()->addTextHeader($name, $value);

        return $this;
    }

    /**
     * Узнать были ли вложения к письму.
     *
     * @return boolean
     */
    public function hasAttach()
    {
        $childrens = $this->getSwiftMessage()->getChildren();
        if (! count($childrens)) {
            return false;
        }

        foreach ($childrens as $child) {
            if ($child instanceof Swift_Attachment) {
                return true;
            }
        }
        return false;
    }

    /**
     * Удалить все произвольные заголовки.
     *
     * @return $this
     */
    public function clearCustomHeader()
    {
        foreach ($this->customHeader as $name) {
            $this->clearHeader($name);
        }
        return $this;
    }

    /**
     * Удалить получателей письма.
     *
     * @return Message
     */
    public function clearTo()
    {
        return $this->clearHeader('To');
    }

    /**
     * Удалить отправителей письма.
     *
     * @return Message
     */
    public function clearFrom()
    {
        return $this->clearHeader('From');
    }

    /**
     * Удалить вторичных получателей.
     *
     * @return Message
     */
    public function clearCc()
    {
        return $this->clearHeader('Cc');
    }

    /**
     * Удалить скрытых получателейю.
     *
     * @return Message
     */
    public function clearBcc()
    {
        return $this->clearHeader('Bcc');
    }

    /**
     * Удалить адрес получателя отчета.
     *
     * @return Message
     */
    public function clearReplyTo()
    {
        return $this->clearHeader('Reply-To');
    }

    /**
     * Удалить всех получателей.
     *
     * @return Message
     */
    public function clearAllRecipients()
    {
        return $this->clearTo()->clearCc()->clearBcc();
    }

    /**
     * Удалить все вложения к письму.
     *
     * @return $this
     */
    public function clearAttach()
    {
        foreach ($this->getSwiftMessage()->getChildren() as $child) {
            if ($child instanceof Swift_Attachment) {
                $this->getSwiftMessage()->detach($child);
            }
        }

        return $this;
    }
}
