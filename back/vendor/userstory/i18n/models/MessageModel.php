<?php

namespace Userstory\I18n\models;

use yii\base\Model;
use Userstory\I18n\interfaces\LanguageInterface;
use Userstory\I18n\interfaces\MessageInterface;
use Userstory\I18n\interfaces\SourceMessageInterface;

/**
 * Класс MessageModel реализует модель хранения данных о переводе.
 * Сохранение модели должно осуществлятся только через компонент i18n.
 * Сохранение MessageActiveRecord::save() может привести к нарушению целостности данных.
 *
 * @package Userstory\I18n\models
 */
class MessageModel extends Model implements MessageInterface
{
    /**
     * Свойство хранит идентификатор перевода.
     *
     * @var integer|null
     */
    protected $id;

    /**
     * Свойство хранит идентификатор языка.
     *
     * @var integer|null
     */
    protected $languageId;

    /**
     * Свойство хранит текст перевода.
     *
     * @var string|null
     */
    protected $translation;

    /**
     * Свойство хранит флаг новой записи.
     *
     * @var string|null
     */
    protected $isNewRecord;

    /**
     * Свойство хранит язык привязанный к сущности.
     *
     * @var LanguageInterface|null
     */
    protected $language;

    /**
     * Свойство хранит общие данные переводов.
     *
     * @var SourceMessageInterface|null
     */
    protected $sourceMessage;

    /**
     * Метод задает идентификатор перевода.
     *
     * @param integer $value Новое значение.
     *
     * @return void
     */
    public function setId($value)
    {
        $this->id = $value;
    }

    /**
     * Метод возвращает идентификатор перевода.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Метод задает идентификатор языка.
     *
     * @param integer $value Новое значение.
     *
     * @return void
     */
    public function setLanguageId($value)
    {
        $this->languageId = $value;
    }

    /**
     * Метод возвращает идентификатор языка.
     *
     * @return integer
     */
    public function getLanguageId()
    {
        return $this->languageId;
    }

    /**
     * Метод задает текст перевода.
     *
     * @param integer $value Новое значение.
     *
     * @return void
     */
    public function setTranslation($value)
    {
        $this->translation = $value;
    }

    /**
     * Метод возвращает текст перевода.
     *
     * @return integer
     */
    public function getTranslation()
    {
        return $this->translation;
    }

    /**
     * Метод задает флаг новой записи.
     *
     * @param integer $value Новое значение.
     *
     * @return void
     */
    public function setIsNewRecord($value)
    {
        $this->isNewRecord = $value;
    }

    /**
     * Метод возвращает флаг новой записи.
     *
     * @return integer
     */
    public function getIsNewRecord()
    {
        if (null === $this->isNewRecord) {
            return true;
        }
        return $this->isNewRecord;
    }

    /**
     * Метод задает язык записи.
     *
     * @param LanguageInterface $value Новое значение.
     *
     * @return void
     */
    public function setLanguage(LanguageInterface $value)
    {
        $this->language = $value;
    }

    /**
     * Метод возвращает язык записи.
     *
     * @return LanguageInterface
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Метод задает общие данные переводов.
     *
     * @param SourceMessageInterface $value Новое значение.
     *
     * @return void
     */
    public function setSourceMessage(SourceMessageInterface $value)
    {
        $this->sourceMessage = $value;
    }

    /**
     * Метод возвращает общие данные переводов.
     *
     * @return mixed
     */
    public function getSourceMessage()
    {
        return $this->sourceMessage;
    }

    /**
     * Переопределенный метод возвращает список сценариев с активными атрибутами (Нужно для метода load).
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => [
                'id',
                'languageId',
                'translation',
                'isNewRecord',
            ],
        ];
    }

    /**
     * Переопределенный метод возвращает список атрибутов для модели (Нужно для метода getAttributes).
     *
     * @return array
     */
    public function attributes()
    {
        return $this->scenarios()[$this->getScenario()];
    }

    /**
     * Метод копирования объекта.
     *
     * @return MessageInterface
     */
    public function copy()
    {
        return new static();
    }
}
