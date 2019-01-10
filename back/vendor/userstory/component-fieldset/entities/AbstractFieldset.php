<?php

namespace Userstory\ComponentFieldset\entities;

use yii\base\InvalidCallException;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;

/**
 * Class AbstractFieldset.
 * Базовый класс для определения динамических форм.
 *
 * @package Userstory\ComponentFieldset\models
 *
 * @property integer $fieldsetPk
 * @property integer $relationId
 * @property integer $fieldsetId
 * @property string  $dataJson
 */
abstract class AbstractFieldset extends ActiveRecord
{
    /**
     * Массив, содержащий зарезервированный набор свойств формы.
     *
     * @var array
     */
    protected static $tableFields = [
        'fieldsetPk',
        'relationId',
        'fieldsetId',
        'dataJson',
        'creatorId',
        'createDate',
        'updaterId',
        'updateDate',
    ];

    /**
     * Правила валидации полей филдсета.
     *
     * @var null|array
     */
    protected static $rules;

    /**
     * Свойство класса, хранящее связанный Fieldset.
     *
     * @var Fieldset|null
     */
    protected $fieldset;

    /**
     * Массив полей динамической формы.
     *
     * @var array|null
     */
    protected $entityAttributes;

    /**
     * Метод должен возвращать название связанной с формой филдсетом.
     *
     * @return string
     */
    abstract public function getFieldsetName();

    /**
     * Заглушка метода, метод должен быть переопределен.
     *
     * @return void
     * @throws InvalidCallException исключение, если метод не был переопределен.
     */
    public static function tableName()
    {
        throw new InvalidCallException(sprintf('%s must be overrided.', __METHOD__));
    }

    /**
     * Метод возвращает связанный с формой филдсет.
     *
     * @return Fieldset
     *
     * @throws InvalidConfigException исключение для случая, когда указанный филдсет отсутствует в структуре СУБД.
     */
    public function getFieldset()
    {
        if ($this->fieldset instanceof Fieldset) {
            return $this->fieldset;
        }

        $this->fieldset = Fieldset::getByName($this->getFieldsetName());
        if (! $this->fieldset instanceof Fieldset) {
            throw new InvalidConfigException(sprintf('%s class must have relation with existing Fieldset.', static::class));
        }

        return $this->fieldset;
    }

    /**
     * Возвращает список имеющихся полей в динамической форме.
     *
     * @throws InvalidConfigException исключение для случая, когда указанный филдсет отсутствует в структуре СУБД.
     *
     * @return array
     */
    protected function getEntityAttributes()
    {
        if (null !== $this->entityAttributes) {
            return $this->entityAttributes;
        }

        $columns                = array_keys(static::getTableSchema()->columns);
        $values                 = array_fill(0, count($columns), null);
        $this->entityAttributes = array_combine($columns, $values);

        $fieldSettings = $this->getFieldset()->fieldSetting;
        foreach ($fieldSettings as $field) {
            $this->entityAttributes[$field->name] = $field->label;
        }

        return $this->entityAttributes;
    }

    /**
     * Возвращает название полей динамической формы.
     *
     * @throws InvalidConfigException исключение для случая, когда указанный филдсет отсутствует в структуре СУБД.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return $this->getEntityAttributes();
    }

    /**
     * Возвращает список атрибутов, используемых в форме.
     *
     * @throws InvalidConfigException исключение для случая, когда указанный филдсет отсутствует в структуре СУБД.
     *
     * @return array
     */
    public function attributes()
    {
        return array_keys($this->getEntityAttributes());
    }

    /**
     * Возвращает динамические правила валидации.
     *
     * @return array
     * @throws InvalidConfigException исключение для случая, когда указанный филдсет отсутствует в структуре СУБД.
     */
    public function rules()
    {
        if (! empty(self::$rules)) {
            return self::$rules;
        }
        self::$rules = [];
        foreach ($this->getFieldset()->fieldSetting as $field) {
            if (! is_array($field->rules)) {
                continue;
            }
            foreach ($field->rules as $rule) {
                array_unshift($rule, [$field->name]);
                self::$rules[] = $rule;
            }
        }
        return self::$rules;
    }

    /**
     * Преобразование в JSON объект данных объекта и сохранение его.
     *
     * @param boolean    $runValidation  следует ли запускать валидатор данных.
     * @param array|null $attributeNames массив проверяемых и сохраняемых столбцов.
     *
     * @throws InvalidParamException Если не известен текущий сценарий.
     * @throws InvalidConfigException исключение для случая, когда указанный филдсет отсутствует в структуре СУБД.
     *
     * @return boolean
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && ! $this->validate($attributeNames)) {
            return false;
        }
        $attributes       = array_diff(array_unique($this->attributes()), static::$tableFields);
        $data             = $this->getAttributes($attributes);
        $this->fieldsetId = $this->getFieldset()->id;
        if (! empty($data)) {
            $this->dataJson = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_BIGINT_AS_STRING);
        } elseif ($this->getIsNewRecord()) {
            $this->dataJson = json_encode([]);
        }
        return parent::save(false, static::$tableFields);
    }

    /**
     * Метод инициализирует объект из массива данных.
     *
     * @param mixed $record инициализирующийся объект.
     * @param mixed $row    массив с данными объекта.
     *
     * @return void
     */
    public static function populateRecord($record, $row)
    {
        parent::populateRecord($record, $row);
        $data       = is_array($record->dataJson) ? $record->dataJson : json_decode($record->dataJson, true, 512, JSON_BIGINT_AS_STRING);
        $attributes = array_diff(array_unique($record->attributes()), static::$tableFields);
        foreach ($attributes as $name) {
            $record->{$name} = isset($data[$name]) ? $data[$name] : null;
        }
    }
}
