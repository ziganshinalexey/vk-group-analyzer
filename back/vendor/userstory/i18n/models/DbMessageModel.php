<?php

namespace Userstory\I18n\models;

use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\I18n\components\I18NComponent;
use Userstory\I18n\entities\MessageActiveRecord as Message;
use Userstory\I18n\entities\SourceMessageActiveRecord as SourceMessage;
use Userstory\I18n\events\MissingTranslationEvent;
use Userstory\I18n\interfaces\MessageInterface;
use yii;
use yii\base\Exception as dbException;
use yii\base\InvalidConfigException;
use yii\i18n\DbMessageSource;
use yii\web\NotFoundHttpException;

/**
 * Данный класс расширяет класс \yii\i18n\DbMessageSource.
 * Он реализует возможность добавления в базу данных новых сообщений и их переводов.
 *
 * @package Userstory\I18n\models
 */
class DbMessageModel extends DbMessageSource
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
     * @throws dbException По какой-то причине не удалось сохранить сообщение.
     *
     * @return void
     */
    public static function missingTranslationHandler(MissingTranslationEvent $event)
    {
        // Получить свойства события и идентификатор языка
        $category    = $event->category;
        $message     = $event->message;
        $translation = $event->translation;
        /* @var I18NComponent $i18n */
        $i18n       = Yii::$app->i18n;
        $languageId = $i18n->getLanguageIdByCode($event->language);
        /* @var $sourceMessageModel SourceMessage */
        // Получаем исходное сообщение.
        if (null === ( $sourceMessageModel = $i18n->getSourceMessageByCategory($category, $message) )) {
            $sourceMessageModel = static::insertMessage($category, $message);
        }
        try {
            // Записываем перевод. Если сообщения нет, оно создастся.
            static::insertTranslation((integer)$sourceMessageModel->id, $languageId, $translation);
        } catch (dbException $e) {
            if (1000 === $e->getCode()) {
                $sourceMessageModel = static::insertMessage($category, $message);
                static::insertTranslation((integer)$sourceMessageModel->id, $languageId, $translation);
            } else {
                throw $e;
            }
        }
        $event->translatedMessage = $translation;
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
        $sourceMessage = Yii::createObject(SourceMessage::class);

        $sourceMessage->attributes = [
            'category' => $category,
            'message'  => $message,
        ];
        $sourceMessage->save();
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
        $i18n->saveMessageByDataModel($message, false);
        return $message;
    }

    /**
     * Данный метод обновляет в базе данных перевод указанного сообщения.
     *
     * @param Message $messageModel Модель перевода указанного сообщения.
     * @param integer $languageId   Целое число с идентификатором языка.
     * @param string  $translation  Строка с переводом.
     *
     * @return void
     */
    protected static function updateTranslation(Message $messageModel, $languageId, $translation)
    {
        $messageModel->attributes = [
            'languageId'  => $languageId,
            'translation' => $translation,
        ];

        $messageModel->save();
    }

    /**
     * Данный метод переводит указанное сообщение.
     *
     * @param string $category Строка с названием категории.
     * @param string $message  Строка с сообщением.
     * @param string $language Строка с кодом языка.
     * @param string $default  Строка с переводом по умолчанию.
     *
     * @return boolean|string
     *
     * @throws InvalidConfigException Генерирует в случает неверной конфигурации.
     */
    public function translateSourceMessage($category, $message, $language, $default)
    {
        $key = $language . '/' . $category;
        if (! isset($this->messages[$key])) {
            $this->messages[$key] = $this->loadMessages($category, $language);
        }
        if (isset($this->messages[$key][$message]) && '' !== $this->messages[$key][$message]) {
            return $this->messages[$key][$message];
        } elseif ($this->hasEventHandlers(static::EVENT_MISSING_TRANSLATION)) {
            /* @var MissingTranslationEvent $event */
            $event = Yii::createObject([
                'class'       => MissingTranslationEvent::class,
                'category'    => $category,
                'message'     => $message,
                'translation' => $default,
                'language'    => $language,
            ]);
            $this->trigger(static::EVENT_MISSING_TRANSLATION, $event);
            if (null !== $event->translatedMessage) {
                return $this->messages[$key][$message] = $event->translatedMessage;
            }
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
     * @throws InvalidConfigException Генерирует в случает неверной конфигурации.
     */
    protected function loadMessages($category, $language)
    {
        if (! $this->enableCaching) {
            return $this->loadMessagesFromDb($category, $language);
        }

        $key      = [
            __CLASS__,
            $category,
            $language,
        ];
        $messages = $this->cache->get($key);
        if (false === $messages) {
            $messages = $this->loadMessagesFromDb($category, $language);
            $this->cache->set($key, $messages, $this->cachingDuration);
        }

        return $messages;
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
     * @throws InvalidConfigException Генерирует в случает неверной конфигурации.
     */
    protected function loadMessagesFromDb($category, $language)
    {
        /* @var I18nComponent $i18n */
        $i18n       = Yii::$app->i18n;
        $languageId = $i18n->getLanguageIdByCode($language);
        $messages   = $i18n->getMessagesWithTranslations($category, $languageId);

        return ArrayHelper::map($messages, 'message', 'translation');
    }
}
