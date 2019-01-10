<?php

namespace Userstory\ComponentBase\queries;

use Userstory\ComponentHelpers\helpers\ArrayHelper;
use yii;
use yii\db\ActiveQuery as YiiActiveQuery;

/**
 * Class ActiveQuery.
 * Расширение базовых методов построителя запросов.
 *
 * @package Userstory\ComponentBase\queries
 */
class ActiveQuery extends YiiActiveQuery
{
    /**
     * Поиск по значению поля или массиву значений.
     *
     * @param string      $field      название поля.
     * @param mixed       $value      значение поля.
     * @param string|null $tableAlias алиас таблицы.
     *
     * @return string
     */
    public function by($field, $value, $tableAlias = null)
    {
        $numericTypes = [
            'integer',
            'smallint',
        ];
        $columnData   = Yii::$app->db->getTableSchema($this->getTableName())->getColumn($field);
        if (ArrayHelper::isIn($columnData->type, $numericTypes)) {
            $value = is_array($value)
                ? ArrayHelper::toInt($value)
                : (int)$value;
        }
        $tableAlias = null === $tableAlias ? $this->getAlias() : $tableAlias;

        return $this->andWhere([$tableAlias . '.{{' . $field . '}}' => $value]);
    }

    /**
     * Поиск по исключению значений поля или массиву значений.
     *
     * @param string      $field      название поля.
     * @param mixed       $value      значение поля.
     * @param string|null $tableAlias алиас таблицы.
     *
     * @return string
     */
    public function byNot($field, $value, $tableAlias = null)
    {
        $numericTypes = [
            'integer',
            'smallint',
        ];
        $columnData   = Yii::$app->db->getTableSchema($this->getTableName())->getColumn($field);
        if (ArrayHelper::isIn($columnData->type, $numericTypes)) {
            $value = is_array($value) ? ArrayHelper::toInt($value) : (int)$value;
        }
        $tableAlias = null === $tableAlias ? $this->getAlias() : $tableAlias;

        return $this->andWhere(['not in', $tableAlias . '.{{' . $field . '}}', $value]);
    }

    /**
     * Получение названия таблицы из родительского класса.
     *
     * @return string
     */
    protected function getTableName()
    {
        $modelClass = $this->modelClass;
        return $modelClass::tableName();
    }

    /**
     * Получить алиас для построения запросов.
     *
     * @return string
     */
    public function getAlias()
    {
        $tableName = $this->getTableName();
        $alias     = array_search($tableName, (array)$this->from);
        return false !== $alias ? $alias : $tableName;
    }

    /**
     * Указание алиаса для таблицы.
     *
     * @param string $alias новый алиас.
     *
     * @return static
     */
    public function alias($alias)
    {
        $oldAlias = $this->getAlias();
        parent::alias($alias);
        if ($oldAlias !== $this->getAlias()) {
            $this->where = $this->replaceAliasWhere($this->where, $oldAlias);
            $this->on    = $this->replaceAliasWhere($this->on, $oldAlias);
        }
        return $this;
    }

    /**
     * При смене алиаса замена в условиях запроса.
     *
     * @param string $items    условия запроса.
     * @param string $oldAlias старый алиас.
     *
     * @return mixed
     */
    protected function replaceAliasWhere($items, $oldAlias)
    {
        if (is_string($items)) {
            return str_replace($oldAlias, $this->getAlias(), $items);
        }
        if (is_array($items)) {
            foreach ($items as $key => $item) {
                $oldKey = $key;
                $key    = str_replace($oldAlias, $this->getAlias(), $oldKey);
                unset( $items[$oldKey] );
                $items[$key] = $this->replaceAliasWhere($item, $oldAlias);
            }
        }

        return $items;
    }

    /**
     * Выборка по дате до заданной.
     *
     * @param string $column колонка выборки.
     * @param string $date   исходная дата.
     * @param string $logic  логика и/или.
     *
     * @return static
     */
    public function dateBefore($column, $date, $logic = 'AND')
    {
        $params = [
            '<',
            $this->getAlias() . '.{{' . $column . '}}',
            $date,
        ];
        if ('AND' === $logic) {
            return $this->andWhere($params);
        }
        if ('OR' === $logic) {
            return $this->orWhere($params);
        }
    }

    /**
     * Выборка по дате после заданной.
     *
     * @param string $column колонка выборки.
     * @param string $date   исходная дата.
     * @param string $logic  логика и/или.
     *
     * @return static
     */
    public function dateAfter($column, $date, $logic = 'AND')
    {
        $params = [
            '>',
            $this->getAlias() . '.{{' . $column . '}}',
            $date,
        ];
        if ('AND' === $logic) {
            return $this->andWhere($params);
        }
        if ('OR' === $logic) {
            return $this->orWhere($params);
        }
    }
}
