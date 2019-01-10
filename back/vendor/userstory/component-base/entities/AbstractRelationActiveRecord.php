<?php

namespace Userstory\ComponentBase\entities;

use Exception as GlobalException;
use Userstory\ComponentBase\traits\ValidatorTrait;
use yii;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use yii\db\Exception;

/**
 * Class RelationActiveRecord.
 * Класс, поддерживающий взаимодействие с многими связями. Позволяет со связью работать как с обычным элементом.
 * $data = [
 *      'id' => 1,
 *      'name' => 'testing',
 *      'creator' => [
 *          'id' => 1,
 *          'login' => 'admin',
 *      ],
 * ];
 * $obj->load($data); // инициализируются связанными объекты и загружаются данными
 * $obj->validate(); // валидации данных, включая валидацию установленных связей
 * $obj->save(); // сохранение данных, включая сохранение связынных объектов
 * В definedRelation следует указывать только зависимые от объекта связи.
 *
 * @package Userstory\ComponentBase\models
 */
abstract class AbstractRelationActiveRecord extends ActiveRecord
{
    use ValidatorTrait;
    /**
     * Массив может содержать только зависимые от объекта связанные сущности.
     *
     * @var array
     */
    protected $definedRelations = [];

    /**
     * Магический метод получения значения свойства по его имени.
     *
     * @param string $name имя атрибута или имя связи.
     *
     * @return mixed
     *
     * @throws InvalidParamException связь не найдена.
     */
    public function __get($name)
    {
        $value = parent::__get($name);
        if (empty($value) && $this->isRelationPopulated($name) && in_array($name, $this->definedRelations)) {
            return $this->createRelation($name);
        }
        return $value;
    }

    /**
     * Метод инициализирует связь.
     *
     * @param string $relationName имя создаваемой связи.
     *
     * @return mixed
     *
     * @throws InvalidParamException связь не найдена.
     */
    protected function createRelation($relationName)
    {
        $activeQuery = $this->getRelation($relationName);
        $className   = $activeQuery->modelClass;
        $relation    = new $className();
        if ($activeQuery->multiple) {
            $relation = [$relation];
        }
        $this->populateRelation($relationName, $relation);
        return $relation;
    }

    /**
     * Переопределение стандартной загрузки данных.
     *
     * @param mixed  $data     массив данных, полученных от пользователя.
     * @param string $formName имя формы с данными.
     *
     * @return boolean
     *
     * @throws InvalidParamException связь не найдена.
     */
    public function load($data, $formName = null)
    {
        if (! parent::load($data, $formName)) {
            return false;
        }

        return $this->loadRelation($data);
    }

    /**
     * Метод инициализирует связи и заполняет их данными.
     *
     * @param array $data данные, полученные от пользователя.
     *
     * @return boolean
     *
     * @throws InvalidParamException связь не найдена.
     */
    protected function loadRelation(array $data)
    {
        foreach ($this->definedRelations as $relationName) {
            $relationQuery = $this->getRelation($relationName);
            $className     = $relationQuery->modelClass;
            $formName      = (new $className)->formName();
            if (! isset($data[$formName])) {
                continue;
            }

            if ($relationQuery->multiple) {
                if (! is_array($data[$formName]) || empty($data[$formName])) {
                    continue;
                }
                $relations = $this->isNewRecord ? [] : $this->{$relationName};
                foreach ($data[$formName] as $key => $v) {
                    $relations[$key] = isset($relations[$key]) ? $relations[$key] : new $className();
                }
                $this->populateRelation($relationName, $relations);
                if (! $className::loadMultiple($this->{$relationName}, $data)) {
                    return false;
                }
            } else {
                if (! $this->{$relationName}->load($data)) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Переопределенная функция проверки валидации сущности.
     *
     * @param string|array $attributeNames проверяемые атрибуты.
     * @param boolean      $clearErrors    очищать ошибки.
     *
     * @return boolean
     *
     * @throws InvalidParamException неизвестный сценарий.
     */
    public function validate($attributeNames = null, $clearErrors = true)
    {
        if (! parent::validate($attributeNames, $clearErrors)) {
            return false;
        }

        return $this->validateRelations($attributeNames, $clearErrors);
    }

    /**
     * Проверка валидности данных для связанных сущностей.
     *
     * @param string|array $attributeNames проверяемые атрибуты.
     * @param boolean      $clearErrors    очистить предварительно ошибки.
     *
     * @return boolean
     *
     * @throws InvalidParamException связь не найдена.
     */
    protected function validateRelations($attributeNames = null, $clearErrors = true)
    {
        foreach ($this->definedRelations as $relationName) {
            if (! $this->isRelationPopulated($relationName)) {
                continue;
            }
            $relationAttributeNames = isset($attributeNames[$relationName]) ? $attributeNames[$relationName] : null;
            $relationQuery          = $this->getRelation($relationName);
            $className              = $relationQuery->modelClass;
            if ($relationQuery->multiple) {
                if (! $className::validateMultiple($this->{$relationName}, $relationAttributeNames)) {
                    return false;
                }
            } elseif (! $this->{$relationName}->validate($relationAttributeNames, $clearErrors)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Переопределение базового метода сохранения сущности, для вызова сохранения в связях.
     *
     * @param boolean      $runValidation  запускать/нет предварительно валидатор.
     * @param string|array $attributeNames проверяемые/сохраняемые атрибуты.
     *
     * @return boolean
     *
     * @throws GlobalException            Ошибка при сохранении в бд.
     * @throws InvalidParamException неизвестный сценарий при валидации.
     * @throws Exception ошибка при откате транзакции.
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && ! $this->validate($attributeNames)) {
            Yii::info('Model not saved due to validation error.', __METHOD__);
            return false;
        }

        $transaction = static::getDb()->beginTransaction();
        try {
            $result = parent::save(false, $attributeNames) && $this->saveRelations(false, $attributeNames);
            if (false === $result) {
                $transaction->rollBack();
            } else {
                $transaction->commit();
            }
            return $result;
        } catch (GlobalException $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * Сохранение сущностей, объявленных в связях.
     *
     * @param boolean      $runValidation  запускать/нет предварительно валидатор.
     * @param string|array $attributeNames проверяемые/сохраняемые атрибуты.
     *
     * @return boolean
     *
     * @throws InvalidParamException связь не найдена.
     * @throws GlobalException ошибка при сохранении в бд.
     * @throws Exception ошибка при откате транзакции.
     */
    protected function saveRelations($runValidation = true, $attributeNames = null)
    {
        foreach ($this->definedRelations as $relationName) {
            if (! $this->isRelationPopulated($relationName)) {
                continue;
            }
            $relationAttributeNames = isset($attributeNames[$relationName]) ? $attributeNames[$relationName] : null;
            $relationQuery          = $this->getRelation($relationName);
            if ($relationQuery->multiple) {
                /* @var RelationActiveRecord $relation */
                foreach ($this->{$relationName} as $relation) {
                    foreach ($relationQuery->link as $key => $value) {
                        $relation->{$key} = $this->{$value};
                    }
                    if (! $relation->save($runValidation, $relationAttributeNames)) {
                        return false;
                    }
                }
            } else {
                foreach ($relationQuery->link as $key => $value) {
                    $this->{$relationName}->{$key} = $this->{$value};
                }
                if (! $this->{$relationName}->save($runValidation, $relationAttributeNames)) {
                    return false;
                }
            }
        }
        return true;
    }
}
