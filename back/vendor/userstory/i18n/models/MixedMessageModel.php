<?php

namespace Userstory\I18n\models;

use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\I18n\components\I18NComponent;
use Userstory\I18n\entities\SourceMessageActiveRecord as SourceMessage;
use Userstory\I18n\events\MissingTranslationEvent;
use Userstory\I18n\interfaces\MessageInterface;
use yii;
use yii\base\InvalidConfigException;
use yii\i18n\PhpMessageSource;
use yii\web\NotFoundHttpException;

/**
 * Класс MixedMessageSource. Добавляем сообщения в базу из yii-файлов.
 *
 * @package Userstory\I18n\models
 */
class MixedMessageModel extends PhpMessageSource
{
    /**
     * Данное событие срабатывает в том случае, если перевод сообщения не найден или равен пустой строке.
     */
    const EVENT_MISSING_TRANSLATION = 'missingTranslation';

    /**
     * Массив с нуждающимися в переводе сообщениями.
     *
     * @var array
     */
    protected $messages = [];

    /**
     * Данный метод обрабатывает событие missingTranslation, то есть ситуацию, когда перевод сообщения не найден или
     * равен пустой строке.
     *
     * @param MissingTranslationEvent $event Событие 'перевод не найден'.
     *
     * @return void
     *
     * @throws InvalidConfigException Генерирует в случает неверной конфигурации.
     * @throws NotFoundHttpException Генерирует в случает неверной конфигурации.
     */
    public static function missingTranslationHandler(MissingTranslationEvent $event)
    {
        $category    = $event->category;
        $message     = $event->message;
        $translation = $event->translation;
        /* @var I18nComponent $i18n */
        $i18n       = Yii::$app->i18n;
        $languageId = $i18n->getLanguageIdByCode($event->language);
        /* @var $sourceMessageModel SourceMessage */
        // получаем исходное сообщение.
        $sourceMessageModel = static::insertMessage($category, $message);
        static::insertTranslation((integer)$sourceMessageModel->id, $languageId, $translation);
        $event->translatedMessage = $translation;
    }

    /**
     * Данный метод переводит сообщение.
     * В качестве источника сообщения рассматривается бд.
     * Если в бд не находится нужного сообщения - ищем в файле.
     *
     * @param string $category Категория, к которой принадежит сообщение.
     * @param string $message  Сообщение, которое нужно перевести.
     * @param string $language Код целевого языка.
     *
     * @return string|bool the translated message or false if translation wasn't found.
     *
     * @throws InvalidConfigException Генерирует в случает неверной конфигурации.
     */
    protected function translateMessage($category, $message, $language)
    {
        $key = $language . '/' . $category;
        if (! array_key_exists($key, $this->messages)) {
            $this->messages[$key] = $this->loadMessagesFromDb($category, $language);
        }
        if ($this->checkIsNotEmpty($key, $message)) {
            return $this->messages[$key][$message];
        }
        // Если в кеше сообщения не оказалось, то берём напрямик из базы.
        $this->messages[$key] = $this->loadMessagesFromDb($category, $language);
        if ($this->checkIsNotEmpty($key, $message)) {
            return $this->messages[$key][$message];
        }
        // Если и там нет... Берём из файла.
        $this->messages[$key] = $this->loadMessages($category, $language);
        /* @var MissingTranslationEvent $event */
        $event = Yii::createObject([
            'class'       => MissingTranslationEvent::class,
            'category'    => $category,
            'message'     => $message,
            'language'    => $language,
            'translation' => $this->checkIsNotEmpty($key, $message) ? $this->messages[$key][$message] : $message,
        ]);
        $this->trigger(self::EVENT_MISSING_TRANSLATION, $event);

        if (null !== $event->translatedMessage) {
            return $this->messages[$key][$message] = $event->translatedMessage;
        }
        return $this->messages[$key][$message] = false;
    }

    /**
     * Данный метод получает сообщения и их переводы для заданной категории и языка из базы данных. Он возвращает
     * массив, ключами которого являются сообщения, а значениями - их переводы.
     *
     * @param string $category Строка с названием категории.
     * @param string $language Строка с кодом языка.
     *
     * @return array
     *
     * @throws InvalidConfigException Генерирует в случае неверной конфигурации.
     */
    protected function loadMessagesFromDb($category, $language)
    {
        /* @var I18nComponent $i18n */
        $i18n       = Yii::$app->i18n;
        $languageId = $i18n->getLanguageIdByCode($language);
        $messages   = $i18n->getMessagesWithTranslations($category, $languageId);

        return ArrayHelper::map($messages, 'message', 'translation');
    }

    /**
     * Проверяем, загружен ли у нас перевод для заданного сообщения с определённой категорией и языком.
     *
     * @param string $key     Ключ, прендставляет собой следующую конструкцию : язык/категория.
     * @param string $message Сообщение, которое желаем перевести.
     *
     * @return boolean
     */
    protected function checkIsNotEmpty($key, $message)
    {
        return ( array_key_exists($message, $this->messages[$key]) && ( '' !== $this->messages[$key][$message] ) );
    }

    /**
     * Загружает сообщения из файла.
     *
     * @param string $category Строка с названием категории.
     * @param string $language Строка с кодом языка.
     *
     * @return array the loaded messages. The keys are original messages, and the values are the translated messages.
     */
    protected function loadMessages($category, $language)
    {
        $messageFile            = $this->getMessageFilePath($category, $language);
        $messages               = $this->loadMessagesFromFile($messageFile);
        $fallbackLanguage       = substr($language, 0, 2);
        $fallbackSourceLanguage = substr($this->sourceLanguage, 0, 2);

        if ($language !== $fallbackLanguage) {
            $messages = $this->loadAdditionalMessages($category, $fallbackLanguage, $messages);
        } elseif ($language === $fallbackSourceLanguage) {
            $messages = $this->loadAdditionalMessages($category, $this->sourceLanguage, $messages);
        }
        if (null === $messages) {
            return [];
        }
        return (array)$messages;
    }

    /**
     * Метод вызывается в loadMessages, чтобы загрузить дополнительные переводы на определенный язык(для En-Us, допустим, En).
     *
     * @param string     $category         Строка с названием категории.
     * @param string     $fallbackLanguage Строка с обрезанным кодом языка.
     * @param array|null $messages         Массив сообщений-переводов, которые удалось загрузить ранее
     *                                     (Может быть и пустым массивом и null).
     *
     * @return array|null Ключи - оригинальные сообщения, Значения - сообщения на искомом языке.
     */
    protected function loadAdditionalMessages($category, $fallbackLanguage, $messages)
    {
        $fallbackMessageFile = $this->getMessageFilePath($category, $fallbackLanguage);
        $fallbackMessages    = $this->loadMessagesFromFile($fallbackMessageFile);
        $isNotSourceLanguage = ( ( $fallbackLanguage !== $this->sourceLanguage ) && ( 0 !== strpos($this->sourceLanguage, $fallbackLanguage) ) );
        if (( null === $messages ) && ( null === $fallbackMessages ) && $isNotSourceLanguage) {
            return null;
        } elseif (empty($messages)) {
            return $fallbackMessages;
        } elseif (( null !== $fallbackMessages ) && ( 0 !== count($fallbackMessages) )) {
            foreach ($fallbackMessages as $key => $value) {
                if (( '' !== $value ) && empty($messages[$key])) {
                    $messages[$key] = $fallbackMessages[$key];
                }
            }
        }

        return (array)$messages;
    }

    /**
     * Данный метод добавляет в базу данных новое сообщение и возвращает объект модели SourceMessage.
     *
     * @param string $category Строка с названием категории.
     * @param string $message  Строка с сообщением.
     *
     * @return SourceMessage
     *
     * @throws InvalidConfigException Генерирует в случает неверной конфигурации.
     */
    protected static function insertMessage($category, $message)
    {
        /* @var I18nComponent $i18n */
        $i18n = Yii::$app->i18n;
        // Получаем сообщение напрямую из базы.
        if (null !== ( $sourceMessage = $i18n->getSourceMessageByCategory($category, $message) )) {
            return $sourceMessage;
        }
        /* @var SourceMessage $sourceMessage */
        $sourceMessage = Yii::createObject(SourceMessage::class);
        $sourceMessage->setAttributes([
            'category' => $category,
            'message'  => $message,
        ], false);
        $sourceMessage->save(false);
        return $sourceMessage;
    }

    /**
     * Данный метод добавляет в базу данных перевод сообщения с указанным идентификатором.
     *
     * @param integer $id          Целое число с идентификатором перевода.
     * @param integer $languageId  Целое число с идентификатором языка.
     * @param string  $translation Строка с переводом или null.
     *
     * @return MessageInterface
     *
     * @throws InvalidConfigException Генерирует в случает неверной конфигурации.
     * @throws NotFoundHttpException Генерирует в случает неверной конфигурации.
     */
    protected static function insertTranslation($id, $languageId, $translation)
    {
        /* @var I18nComponent $i18n */
        $i18n    = Yii::$app->i18n;
        $message = $i18n->setMessageTranslation($id, $languageId, $translation);
        $i18n->saveMessageByDataModel($message);
        return $message;
    }
}
