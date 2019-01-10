<?php

namespace Userstory\ModuleMailer\entities;

use Swift_Mime_Message;
use yii\db\ActiveRecord;

/**
 * Класс модели для работы с таблицо us_mailer.
 *
 * @property integer $id
 * @property string  $to
 * @property string  $cc
 * @property string  $bcc
 * @property string  $subject
 * @property string  $message
 * @property integer $priority
 */
class Mailer extends ActiveRecord
{
    /**
     * Имя таблицы в базе данных.
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%mailer}}';
    }

    /**
     * Правила валидации данных.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'message',
                    'to',
                    'subject',
                ],
                'required',
            ],
            [
                [
                    'message',
                    'to',
                    'cc',
                    'bcc',
                ],
                'string',
            ],
            [
                ['priority'],
                'integer',
            ],
        ];
    }

    /**
     * Свернуть объект для хранения в базе данных.
     *
     * @param Swift_Mime_Message $message объект сообщения.
     *
     * @return void
     */
    public function setMessage(Swift_Mime_Message $message)
    {
        $this->to      = serialize($message->getTo());
        $this->cc      = serialize($message->getCc());
        $this->bcc     = serialize($message->getBcc());
        $this->subject = $message->getSubject();
        $this->message = base64_encode(serialize($message));
    }

    /**
     * Получить развернутый объект сообщения.
     *
     * @return Swift_Mime_Message
     */
    public function getMessage()
    {
        return unserialize(base64_decode($this->message));
    }

    /**
     * Выборка сообщения для отправки.
     *
     * @param integer $limit ограничение на выборку.
     *
     * @return \yii\db\ActiveRecord[]
     */
    public function listItems($limit)
    {
        return self::find()->orderBy(['priority' => SORT_ASC])->limit($limit)->all();
    }
}
