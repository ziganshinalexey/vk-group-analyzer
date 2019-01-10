<?php

namespace Userstory\I18n\events;

use yii\i18n\MissingTranslationEvent as YiiMissingTranslationEvent;

/**
 * Данный класс расширяет класс \yii\i18n\MissingTranslationEvent.
 * В нем определяется свойство translation, что необходимо для добавления в базу данных сообщений и их переводов.
 */
class MissingTranslationEvent extends YiiMissingTranslationEvent
{
    /**
     * Строка с переводом сообщения по умолчанию.
     *
     * @var string|null
     */
    protected $translation;

    /**
     * Метод задает значение перевода.
     *
     * @param string $value Новое значение.
     *
     * @return void
     */
    public function setTranslation($value)
    {
        $this->translation = $value;
    }

    /**
     * Метод возвращает значение перевода.
     *
     * @return string
     */
    public function getTranslation()
    {
        return $this->translation;
    }
}
