<?php

namespace Userstory\I18n\entities;

use yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use Userstory\ComponentBase\traits\ModifierAwareTrait;

/**
 * Модель переводов сообщений.
 *
 * @property integer                   $id            Уникальный номер перевода.
 * @property integer                   $languageId    Язык перевода.
 * @property string                    $translation   Перевод.
 *
 * @property LanguageActiveRecord      $language      Объект языка перевода.
 * @property SourceMessageActiveRecord $sourceMessage Объект основных данных перевода.
 */
class MessageActiveRecord extends ActiveRecord
{
    use ModifierAwareTrait;

    /**
     * Данный метод возвращает имя связанной с моделью таблицы.
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%language_message}}';
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
                [
                    'id',
                    'languageId',
                ],
                'required',
            ],
            [
                [
                    'id',
                    'languageId',
                ],
                'integer',
            ],
            [
                ['translation'],
                'string',
                'max' => 255,
            ],
        ];
    }

    /**
     * Определение заголовков свойств модели.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id'                 => Yii::t('Admin.I18N.Message', 'Message Id', 'Айди сообщения'),
            'languageId'         => Yii::t('Admin.I18N.Message', 'Language ID', 'Айди языка'),
            'translation'        => Yii::t('Admin.I18N.Message', 'Translation', 'Перевод'),
            'defaultTranslation' => Yii::t('Admin.I18N.Message', 'Default Translation', 'Перевод на языке по умолчанию'),
        ];
    }

    /**
     * Определение связи language для класса Message.
     *
     * @return ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(LanguageActiveRecord::class, ['id' => 'languageId']);
    }

    /**
     * Определение связи sourceMessage для класса Message.
     *
     * @return ActiveQuery
     */
    public function getSourceMessage()
    {
        return $this->hasOne(SourceMessageActiveRecord::class, ['id' => 'id']);
    }
}
