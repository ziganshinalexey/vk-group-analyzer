<?php

namespace Userstory\I18n\models;

use Userstory\ComponentBase\models\Model;
use Userstory\I18n\interfaces\SourceMessageInterface;

/**
 * Класс SourceMessageModel реализует модель хранения однородных данных о переводе.
 * Сохранение модели должно осуществлятся только через компонент i18n.
 * Сохранение SourceMessageActiveRecord::save() может привести к нарушению целостности данных.
 *
 * @package Userstory\I18n\models
 */
class SourceMessageModel extends Model implements SourceMessageInterface
{
    /**
     * Свойство хранит идентификатор перевода.
     *
     * @var integer|null
     */
    protected $id;

    /**
     * Свойство хранит категорию переводов.
     *
     * @var string|null
     */
    protected $category;

    /**
     * Свойство хранит алиас переводов.
     *
     * @var string|null
     */
    protected $message;

    /**
     * Свойство хранит комментарий к переводам.
     *
     * @var string|null
     */
    protected $comment;

    /**
     * Свойство хранит флаг новой записи.
     *
     * @var string|null
     */
    protected $isNewRecord;

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
     * Метод задает категорию переводов.
     *
     * @param string $value Новое значение.
     *
     * @return void
     */
    public function setCategory($value)
    {
        $this->category = $value;
    }

    /**
     * Метод возвращает категорию переводов.
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Метод задает алиас переводов.
     *
     * @param string $value Новое значение.
     *
     * @return void
     */
    public function setMessage($value)
    {
        $this->message = $value;
    }

    /**
     * Метод возвращает алиас переводов.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Метод задает комментарий к переводам.
     *
     * @param string $value Новое значение.
     *
     * @return void
     */
    public function setComment($value)
    {
        $this->comment = $value;
    }

    /**
     * Метод возвращает комментарий к переводам.
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
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
     * Переопределенный метод возвращает список сценариев с активными атрибутами (Нужно для метода load).
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => [
                'id',
                'category',
                'message',
                'comment',
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
}
