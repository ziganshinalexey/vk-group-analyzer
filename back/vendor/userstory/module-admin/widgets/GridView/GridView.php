<?php

namespace Userstory\ModuleAdmin\widgets\GridView;

use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\ModuleAdmin\widgets\GridView\assets\GridViewAsset;
use yii\base\InvalidCallException;
use yii\grid\GridView as YiiGridView;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * GridView виджет используется для отображения данных в сетке.
 */
class GridView extends YiiGridView
{

    /**
     * HTML-атрибуты для контейнера таблицы.
     *
     * @var array
     * @see \yii\helpers\Html::renderTagAttributes()
     */
    public $options = ['class' => 'grid-view table-responsive clearfix'];

    /**
     * HTML-атрибуты для таблицы.
     *
     * @var array
     */
    public $tableOptions = ['class' => 'table table-bordered table-hover'];

    /**
     * HTML-атрибуты для строки поиска в таблице.
     *
     * @var array
     */
    public $filterRowOptions = ['class' => 'active'];

    /**
     * Лейаут определяющий какие разделы и в каком порядке должны присутствовать.
     *
     * @var string
     */
    public $layout = "{items}\n{summary}\n{pager}";

    /**
     * Включена ли подсветка найденных значений в ячейке.
     *
     * @var array|false
     */
    public $filterMarker = false;

    /**
     * Класс, который будет использован для вывода данных.
     *
     * @var string
     */
    public $dataColumnClass = '\Userstory\ModuleAdmin\widgets\GridView\DataColumn';

    /**
     * Запускает виджет.
     * Переопределение требуется, что бы можно было использовать JQuery3.
     *
     * @throws InvalidCallException если количество вызовой `beginField()` и `endField()` не совпадают.
     * @throws \yii\base\InvalidParamException если параметры какого-то из вызываемых методоы неверны.
     *
     * @return void
     */
    public function run()
    {
        $id      = $this->options['id'];
        $options = Json::htmlEncode($this->getClientOptions());
        $view    = $this->getView();
        GridViewAsset::register($view);
        $view->registerJs('jQuery(\'#' . $id . '\').yiiGridView(' . $options . ');');
        if ($this->showOnEmpty || $this->dataProvider->getCount() > 0) {
            $content = preg_replace_callback('/{\w+}/', function($matches) {
                $content = $this->renderSection($matches[0]);

                return false === $content ? $matches[0] : $content;
            }, $this->layout);
        } else {
            $content = $this->renderEmpty();
        }

        $options = $this->options;
        $tag     = ArrayHelper::remove($options, 'tag', 'div');
        echo Html::tag($tag, $content, $options);
    }
}
