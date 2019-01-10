<?php

namespace Userstory\UserAdmin\operations;

use yii\base\BaseObject;

/**
 * Class NotifyOperation.
 * Класс операций для работы с уведомлениями.
 *
 * @property string  $emailFrom
 * @property string  $emailFromName
 * @property string  $emailSubject
 * @property string  $emailText
 * @property string  $smsText
 * @property boolean $isActivateEmail
 * @property boolean $isActivateSms
 *
 * @package Userstory\UserAdmin\operations
 */
class NotifyOperation extends BaseObject
{
    /**
     * С какого ящика идет уведомление юзера о смене включенности.
     *
     * @var string|null
     */
    protected $emailFrom;

    /**
     * Имя от которого идет уведомление юзера о смене включенности.
     *
     * @var string|null
     */
    protected $emailFromName;

    /**
     * Заголовок письма-уведомления о смене вклченности.
     *
     * @var string|null
     */
    protected $emailSubject;

    /**
     * Текст письма-уведомления о смене вклченности.
     *
     * @var string|null
     */
    protected $emailText;

    /**
     * Текст sms-уведомления о смене вклченности.
     *
     * @var null|string
     */
    protected $smsText;

    /**
     * Необходимость отправки сообщения об успешной активации аккаунта на емайл.
     *
     * @var boolean
     */
    protected $isActivateEmail = true;

    /**
     * Необходимость отправки сообщения об успешной активации аккаунта на телефон.
     *
     * @var boolean
     */
    protected $isActivateSms = true;

    /**
     * Метод возвращает с какого ящика идет уведомление юзера о смене включенности.
     *
     * @return string
     */
    public function getEmailFrom()
    {
        return $this->emailFrom;
    }

    /**
     * Метод задает с какого ящика идет уведомление юзера о смене включенности.
     *
     * @param string $emailFrom Значение для установки.
     *
     * @return static
     */
    public function setEmailFrom($emailFrom)
    {
        $this->emailFrom = $emailFrom;
        return $this;
    }

    /**
     * Метод возвращает имя от которого идет уведомление юзера о смене включенности.
     *
     * @return string
     */
    public function getEmailFromName()
    {
        return $this->emailFromName;
    }

    /**
     * Метод задает имя от которого идет уведомление юзера о смене включенности.
     *
     * @param string $fromName Значение для установки.
     *
     * @return static
     */
    public function setEmailFromName($fromName)
    {
        $this->emailFromName = $fromName;
        return $this;
    }

    /**
     * Метод возвращает заголовок письма-уведомления о смене включенности.
     *
     * @return string
     */
    public function getEmailSubject()
    {
        return $this->emailSubject;
    }

    /**
     * Метод задает заголовок письма-уведомления о смене включенности.
     *
     * @param string $emailSubject Значение для установки.
     *
     * @return static
     */
    public function setEmailSubject($emailSubject)
    {
        $this->emailSubject = $emailSubject;
        return $this;
    }

    /**
     * Метод возвращает текст письма-уведомления о смене включенности.
     *
     * @return string
     */
    public function getEmailText()
    {
        return $this->emailText;
    }

    /**
     * Метод задает текст письма-уведомления о смене включенности.
     *
     * @param array|string $emailText Значение для установки.
     *
     * @return static
     */
    public function setEmailText($emailText)
    {
        $this->emailText = is_array($emailText) ? implode("\n\n", $emailText) : $emailText;
        return $this;
    }

    /**
     * Получить статус необходимости отправки на телефон.
     *
     * @return boolean
     */
    public function getIsActivateSms()
    {
        return $this->isActivateSms;
    }

    /**
     * Установить значение необходимости отправки сообщения на телефон.
     *
     * @param boolean $activateSms новое значение.
     *
     * @return static
     */
    public function setIsActivateSms($activateSms)
    {
        $this->isActivateSms = $activateSms;
        return $this;
    }

    /**
     * Получить статус необходимости отправки на емайл.
     *
     * @return boolean
     */
    public function getIsActivateEmail()
    {
        return $this->isActivateEmail;
    }

    /**
     * Установить значение необходимости отправки сообщения на емайл.
     *
     * @param boolean $activateEmail новое значение.
     *
     * @return static
     */
    public function setIsActivateEmail($activateEmail)
    {
        $this->isActivateEmail = $activateEmail;
        return $this;
    }

    /**
     * Получить текст sms-уведомления.
     *
     * @return null|string
     */
    public function getSmsText()
    {
        return $this->smsText;
    }

    /**
     * Указать текст sms-уведомления.
     *
     * @param null|string $smsText текст сообщения.
     *
     * @return static
     */
    public function setSmsText($smsText)
    {
        $this->smsText = $smsText;
        return $this;
    }
}
