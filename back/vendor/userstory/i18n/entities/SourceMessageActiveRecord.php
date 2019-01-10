<?php

namespace Userstory\I18n\entities;

use Userstory\I18n\interfaces\SourceMessageInterface;
use yii;
use yii\db\ActiveRecord;
use Userstory\ComponentBase\traits\ModifierAwareTrait;

/**
 * Модель нуждающихся в переводе сообщений.
 *
 * @property integer $id
 * @property string  $category
 * @property string  $message
 * @property string  $comment
 * @property integer $creatorId
 * @property string  $createDate
 * @property integer $updaterId
 * @property string  $updateDate
 */
class SourceMessageActiveRecord extends ActiveRecord implements SourceMessageInterface
{
    use ModifierAwareTrait;

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
     * Данный метод возвращает имя связанной с моделью таблицы.
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%language_source_message}}';
    }

    /**
     * Данный метод возвращает массив, содержащий правила валидации атрибутов.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [
                ['message'],
                'string',
            ],
            [
                [
                    'category',
                    'comment',
                ],
                'string',
                'max' => 255,
            ],
        ];
    }

    /**
     * Данный метод возвращает массив, содержащий метки атрибутов.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id'       => Yii::t('Admin.I18N.SourceMessage', 'Source Message Id', 'Айди исходного сообщения'),
            'category' => Yii::t('Admin.I18N.SourceMessage', 'Category', 'Категория'),
            'message'  => Yii::t('Admin.I18N.SourceMessage', 'Message', 'Сообщение'),
            'comment'  => Yii::t('Admin.I18N.SourceMessage', 'Comment', 'Комментарий'),
        ];
    }

    /**
     * Определение связи messages для класса SourceMessage.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(MessageActiveRecord::class, ['id' => 'id'])->indexBy('languageId');
    }
}
