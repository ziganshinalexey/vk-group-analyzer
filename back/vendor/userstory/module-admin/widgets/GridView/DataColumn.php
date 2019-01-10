<?php

namespace Userstory\ModuleAdmin\widgets\GridView;

use Closure;
use Userstory\ModuleAdmin\widgets\StatusLabel;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\data\Sort;
use yii\grid\Column;
use yii\grid\DataColumn as YiiDataColumn;
use yii\helpers\Html;
use yii\helpers\Inflector;

/**
 * DataColumn - стандартный тип столбца по умолчанию для [[GridView]] виджета.
 */
class DataColumn extends YiiDataColumn
{
    /**
     * Параметры для выводит лейбла со статусом внутри ячейки.
     *
     * 'statusLabel' => [
     *      'text' => 'Some text',
     *      'type' => 'success',
     *      'alignRight' => true
     * ]
     *
     * @var array
     */
    public $statusLabel = [];

    /**
     * Html контент для показа во всплывающем бабле.
     *
     * @var string|null
     */
    public $popover;

    /**
     * Флаг отвечает за рендер фильтра столбца.
     *
     * @var boolean
     */
    public $hasFilter = true;

    /**
     * Рендер ячейки в шапке таблицы.
     *
     * @throws InvalidConfigException Если какой-то атрибут неизвестен.
     *
     * @return string
     */
    public function renderHeaderCell()
    {
        if ($this->enableSorting) {
            $hasClass                     = array_key_exists('class', $this->headerOptions);
            $this->headerOptions['class'] = $hasClass ? $this->headerOptions['class'] . ' table__sorted-column' : ' table__sorted-column';
        }
        return Html::tag('th', $this->renderHeaderCellContent(), $this->headerOptions);
    }

    /**
     * Рендер контента для ячейки в шапке таблицы.
     *
     * @throws InvalidConfigException Если какой-то атрибут неизвестен.
     *
     * @return string
     */
    protected function renderHeaderCellContent()
    {
        if (null !== $this->header || (null === $this->label && null === $this->attribute)) {
            return parent::renderHeaderCellContent();
        }

        $label = $this->getHeaderCellLabel();
        if ($this->encodeLabel) {
            $label = Html::decode($label);
        }

        $sort = $this->grid->dataProvider->getSort();
        if (null !== $this->attribute && $this->enableSorting && false !== $sort && $sort->hasAttribute($this->attribute)) {
            return $this->renderHeaderLink($sort, $this->attribute, array_merge($this->sortLinkOptions, ['label' => $label]));
        }
        return $label;
    }

    /**
     * Рендер ссылки для ячейки сорьтировки в шапке таблицы.
     *
     * @param Sort   $sort      Объект сортировки.
     * @param string $attribute Имя атрибута, по которому данные должны быть отсортированы.
     * @param array  $options   HTML-атрибуты.
     *
     * @todo переопределить \yii\data\Sort::link()
     *
     * @throws InvalidConfigException Если какой-то атрибут неизвестен.
     *
     * @return string
     */
    public function renderHeaderLink(Sort $sort, $attribute, array $options = [])
    {
        $class = 'text-black table__sorted-link';
        if (($direction = $sort->getAttributeOrder($attribute)) !== null) {
            if (SORT_DESC === $direction) {
                $class .= ' table__sorted-link_desc';
            } else {
                $class .= ' table__sorted-link_asc';
            }
        }
        if (isset($options['class'])) {
            $options['class'] .= ' ' . $class;
        } else {
            $options['class'] = $class;
        }

        $url                  = $sort->createUrl($attribute);
        $options['data-sort'] = $sort->createSortParam($attribute);

        if (isset($options['label'])) {
            $label = $options['label'];
            unset($options['label']);
        } else {
            if (isset($sort->attributes[$attribute]['label'])) {
                $label = $sort->attributes[$attribute]['label'];
            } else {
                $label = Inflector::camel2words($attribute);
            }
        }

        return Html::a($label, $url, $options);
    }

    /**
     * Рендер данных в ячейке таблицы.
     *
     * @param mixed   $model Модель данных.
     * @param mixed   $key   Ключ, связанный с моделью.
     * @param integer $index Индекс в массиве [dataProvider].
     *
     * @throws \Exception генерируется если не удалось создать объект виджета.
     *
     * @return string
     */
    public function renderDataCell($model, $key, $index)
    {
        if ($this->contentOptions instanceof Closure) {
            $options = call_user_func($this->contentOptions, $model, $key, $index, $this);
        } else {
            $options = $this->contentOptions;
        }

        if (null !== $this->popover) {
            $options['data-toggle'] = 'table-popover';
        }

        $content = $this->renderDataCellContent($model, $key, $index);

        if (! empty($this->statusLabel)) {
            $content = $this->renderStatusLabel($model, $key, $index, $content);
        }
        if (! empty($this->popover)) {
            $content .= ' ' . $this->renderDataPopover($model, $key, $index);
        }

        return Html::tag('td', $content, $options);
    }

    /**
     * Рендер тултипа для ячейки таблицы.
     *
     * @param mixed   $model Модель данных.
     * @param mixed   $key   Ключ, связанный с моделью.
     * @param integer $index Индекс в массиве [dataProvider].
     *
     * @return string
     */
    public function renderDataPopover($model, $key, $index)
    {
        if ($this->popover instanceof Closure) {
            $content = call_user_func($this->popover, $model, $key, $index, $this);
        } else {
            $content = $this->popover;
        }

        return Html::tag('div', $content, [
            'class' => 'table__popover-content',
        ]);
    }

    /**
     * Рендер лейбла со статусом внутри ячейки.
     *
     * @param mixed   $model   Модель данных.
     * @param mixed   $key     Ключ, связанный с моделью.
     * @param integer $index   Индекс в массиве [dataProvider].
     * @param string  $content Исходное содержимое ячейки.
     *
     * @throws \Exception генерируется если не удалось создать объект виджета.
     * @return string
     */
    public function renderStatusLabel($model, $key, $index, $content)
    {
        if ($this->statusLabel instanceof Closure) {
            $options = call_user_func($this->statusLabel, $model, $key, $index, $this);
        } else {
            $options = $this->statusLabel;
        }
        $align = ! empty($options['align']) ? $options['align'] : '';
        unset($options['align']);
        if ('left' === $align) {
            $left  = StatusLabel::widget($options);
            $right = $content;
        } else {
            $left  = $content;
            $right = StatusLabel::widget($options);
        }

        $rightAlignString = 'right' === $align ? ' class="nav-justified no-margin no-border"' : '';
        $leftAlignString  = 'right' === $align ? ' class="text-right"' : '';

        $result = sprintf('<table%s><tr><td>%s</td><td%s>&nbsp;%s</td></tr></table>', $rightAlignString, $left, $leftAlignString, $right);
        return $result;
    }

    /**
     * Рендер поля для поиска в таблице.
     *
     * @param mixed $model Модель данных.
     *
     * @return string
     */
    public function renderFilterInput($model)
    {
        if (array_key_exists('icon', $this->filterInputOptions) && (false !== $this->filterInputOptions['icon'])) {
            $defaultOptions = [
                'class' => 'form-control table__filter-input',
                'icon'  => 'search',
            ];
        } else {
            $defaultOptions = [
                'class' => 'form-control',
            ];
        }

        $options = array_merge($defaultOptions, $this->filterInputOptions);
        $input   = Html::activeTextInput($model, $this->attribute, $options);

        // Если иконка выключена.
        if (! array_key_exists('icon', $this->filterInputOptions) || (false === $this->filterInputOptions['icon'])) {
            return $input;
        }

        $icon = Html::tag('span', null, ['class' => 'table__filter-icon fa fa-' . $options['icon']]);

        return Html::tag('div', $input . $icon, ['class' => 'table__filter']);
    }

    /**
     * Рендер контента для ячейки с полем поиска.
     *
     * @return string
     */
    protected function renderFilterCellContent()
    {
        if (! $this->enableSorting) {
            // TODO: hotfix.
            return '';
        }
        if (is_string($this->filter)) {
            return $this->filter;
        }

        $model = $this->grid->filterModel;

        if (false !== $this->filter && $model instanceof Model && null !== $this->attribute && $model->isAttributeActive($this->attribute)) {
            if ($model->hasErrors($this->attribute)) {
                Html::addCssClass($this->filterOptions, 'has-error');
                $error = ' ' . Html::error($model, $this->attribute, $this->grid->filterErrorOptions);
            } else {
                $error = '';
            }
            if (is_array($this->filter)) {
                $options = array_merge(['prompt' => ''], $this->filterInputOptions);
                return Html::activeDropDownList($model, $this->attribute, $this->filter, $options) . $error;
            }
            if ('boolean' === $this->format) {
                $options = array_merge(['prompt' => ''], $this->filterInputOptions);
                $values  = [
                    1 => $this->grid->formatter->booleanFormat[1],
                    0 => $this->grid->formatter->booleanFormat[0],
                ];
                return Html::activeDropDownList($model, $this->attribute, $values, $options) . $error;
            }
            return $this->renderFilterInput($model) . $error;
        }
        return parent::renderFilterCellContent();
    }

    /**
     * Метод рендерит содержимое ячейки фильтра.
     *
     * @return string
     */
    public function renderFilterCell()
    {
        if (! $this->hasFilter) {
            return '';
        }

        return Html::tag('td', $this->renderFilterCellContent(), $this->filterOptions);
    }

    /**
     * Метод рендерит сожержимое ячейки данных.
     *
     * @param mixed   $model Текущая модель.
     * @param mixed   $key   Ключ ассоциированный с моделью.
     * @param integer $index Индекс модели в списке.
     *
     * @return string
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        if (null === $this->content) {
            $content = $this->grid->formatter->format($this->getDataCellValue($model, $key, $index), $this->format);
        } else {
            $content = Column::renderDataCellContent($model, $key, $index);
        }

        $filterMarker = $this->grid->filterMarker;

        if (false === $filterMarker || ! isset($filterMarker['attribute'])) {
            return $content;
        }

        $attributeValue = $this->grid->filterModel->{$filterMarker['attribute']};

        if ('' === $attributeValue || null === $attributeValue) {
            return $content;
        }

        $value = $this->grid->formatter->format($attributeValue, $this->format);
        $value = preg_quote($value, '/');

        return preg_replace_callback('~' . $value . '~iu', [
            $this,
            'putMarker',
        ], $content);
    }

    /**
     * Метод формирует итоговую подсветку маркера.
     *
     * @param array $matches Список найденных вариантов для замены.
     *
     * @return string
     */
    protected function putMarker(array $matches)
    {
        if (! isset($this->grid->filterMarker['replacement'])) {
            return $matches[0];
        }

        return call_user_func($this->grid->filterMarker['replacement'], $matches[0], $this->attribute);
    }
}
