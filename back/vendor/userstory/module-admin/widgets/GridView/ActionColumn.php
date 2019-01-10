<?php

namespace Userstory\ModuleAdmin\widgets\GridView;

use yii;
use yii\grid\ActionColumn as YiiActionColumn;
use yii\helpers\Html;

/**
 * ActionColumn представляет собой колонку для [[GridView]] виджета, который отображает кнопки.
 */
class ActionColumn extends YiiActionColumn
{
    /**
     * Инициализирует рендеринг кнопок по умолчанию.
     *
     * @return Html;
     */
    protected function initDefaultButtons()
    {
        if (! isset($this->buttons['view'])) {
            $this->buttons['view'] = function($url, $model, $key) {
                $options = array_merge([
                    'title'      => Yii::t('yii', 'View'),
                    'aria-label' => Yii::t('yii', 'View'),
                    'data-pjax'  => '0',
                ], $this->buttonOptions);
                return Html::a('<span class="table__action-icon fa fa-eye text-black"></span>', $url, $options);
            };
        }

        if (! isset($this->buttons['update'])) {
            $this->buttons['update'] = function($url, $model, $key) {
                $options = array_merge([
                    'title'      => Yii::t('yii', 'Update'),
                    'aria-label' => Yii::t('yii', 'Update'),
                    'data-pjax'  => '0',
                ], $this->buttonOptions);
                return Html::a('<span class="table__action-icon fa fa-pencil fa-pencil-alt text-black"></span>', $url, $options);
            };
        }

        if (! isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function($url, $model, $key) {
                $options = array_merge([
                    'title'        => Yii::t('yii', 'Delete'),
                    'aria-label'   => Yii::t('yii', 'Delete'),
                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'data-method'  => 'post',
                    // 'data-pjax'    => '0',
                ], $this->buttonOptions);
                return Html::a('<span class="table__action-icon fa fa-trash text-black"></span>', $url, $options);
            };
        }
    }
}
