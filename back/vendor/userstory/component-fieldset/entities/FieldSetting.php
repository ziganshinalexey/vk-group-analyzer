<?php

namespace Userstory\ComponentFieldset\entities;

use Userstory\ComponentBase\traits\ModifierAwareTrait;
use yii\db\ActiveRecord;

/**
 * Class FieldSetting.
 * Класс определяющий параметры поля динамической формы.
 *
 * @package Userstory\ComponentFieldset\models
 *
 * @property integer  $id
 * @property integer  $fieldsetId
 * @property string   $name
 * @property string   $fieldType
 * @property string   $label
 * @property string   $rulesJson
 * @property string   $description
 * @property integer  $creatorId
 * @property string   $createDate
 * @property integer  $updaterId
 * @property string   $updateDate
 *
 * @property array    $rules
 * @property Fieldset $fieldset
 */
class FieldSetting extends ActiveRecord
{
    use ModifierAwareTrait;

    /**
     * Переменная определяющая класс формы, членом которой является поле.
     *
     * @var string
     */
    protected $fieldsetClass = Fieldset::class;

    /**
     * Метод определяет название таблицы.
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%field_setting}}';
    }

    /**
     * Метод определяет параметры валидации формы.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge_recursive(parent::rules(), [
            [
                [
                    'name',
                    'fieldType',
                ],
                'required',
            ],
            [
                ['name'],
                'string',
                'max' => 50,
            ],
            [
                [
                    'label',
                    'fieldType',
                ],
                'string',
                'max' => 255,
            ],
            [
                ['description'],
                'safe',
            ],
            [
                'isPublic',
                'filter',
                'filter' => function($model) {
                    return (bool)$model->isPublic;
                },
            ],
        ]);
    }

    /**
     * Метод определяет связанную с полем форму.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFieldset()
    {
        return $this->hasOne($this->fieldsetClass, ['id' => 'fieldsetId']);
    }

    /**
     * Возвращает правила валидации для текущего поля.
     *
     * @return mixed
     */
    public function getRules()
    {
        return json_decode($this->rulesJson, true, 512, JSON_BIGINT_AS_STRING);
    }

    /**
     * Сеттер для правила валидации филдсета.
     *
     * @param array $value массив правил без полей.
     *
     * @return void
     */
    public function setRules(array $value)
    {
        $this->rulesJson = json_encode($value, JSON_BIGINT_AS_STRING | JSON_UNESCAPED_UNICODE);
    }
}
