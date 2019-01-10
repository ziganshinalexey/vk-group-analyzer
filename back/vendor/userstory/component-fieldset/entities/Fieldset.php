<?php

namespace Userstory\ComponentFieldset\entities;

use Userstory\ComponentBase\traits\ModifierAwareTrait;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Fieldset.
 * Базовый классс для работы с динамическими формами.
 *
 * @package  Userstory\ComponentFieldset
 * @property integer        $id
 * @property string         $name
 * @property string         $description
 * @property boolean        $canModified
 * @property integer        $creatorId
 * @property string         $createDate
 * @property integer        $updaterId
 * @property string         $updateDate
 * @property FieldSetting[] $fieldSetting
 */
class Fieldset extends ActiveRecord
{
    use ModifierAwareTrait {
        ModifierAwareTrait::beforeSave as private beforeSaveFromTrait;
    }

    /**
     * закешированные Объекты филдсетов.
     *
     * @var array
     */
    public static $cachedFieldsets = [];

    /**
     * Переменная определяющая класс полей формы.
     *
     * @var string
     */
    protected $fieldSettingClass = FieldSetting::class;

    /**
     * Получить филдсет по названию.
     *
     * @param string $name название филдсета.
     *
     * @return static
     */
    public static function getByName($name)
    {
        if (! isset( static::$cachedFieldsets[$name] )) {
            static::$cachedFieldsets[$name] = static::find()->where(['name' => $name])->with('fieldSetting')->one();
        }
        return static::$cachedFieldsets[$name];
    }

    /**
     * Метод определяет название таблицы.
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%fieldset}}';
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
                ['name'],
                'required',
            ],
            [
                ['name'],
                'string',
                'max' => 50,
            ],
            [
                ['description'],
                'safe',
            ],
        ]);
    }

    /**
     * Метод запрещает сохранение в случае, если установлена защина на обновление данных.
     *
     * @param boolean $insert параметр, определяющий вставку или обновление данных.
     *
     * @return boolean
     */
    public function beforeSave($insert)
    {
        if (! $insert && ! $this->oldAttributes['canModified']) {
            return false;
        }
        return $this->beforeSaveFromTrait($insert);
    }

    /**
     * Определение связанных данных - набора полей с непосредственно полями.
     *
     * @return ActiveQuery
     */
    public function getFieldSetting()
    {
        return $this->hasMany($this->fieldSettingClass, ['fieldsetId' => 'id'])->indexBy('name')->inverseOf('fieldset');
    }
}
