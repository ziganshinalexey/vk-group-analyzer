<?php

declare(strict_types = 1);

use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\ModuleAdmin\widgets\GridView\ActionColumn;
use Userstory\ModuleAdmin\widgets\GridView\DataColumn;
use Userstory\ModuleAdmin\widgets\GridView\GridView;
use Userstory\ModuleAdmin\widgets\Modal;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use Ziganshinalexey\KeywordAdmin\assets\KeywordAdminAsset;
use Ziganshinalexey\KeywordAdmin\forms\keyword\FindForm;
use Ziganshinalexey\KeywordAdmin\forms\keyword\ViewForm;
use Ziganshinalexey\PersonType\components\PersonTypeComponent;

$this->title = Yii::t('Admin.Keyword.Keyword', 'title', 'Список ключевых фраз');
$this->params['contentTitle'] = $this->title;
$this->params['breadcrumbs'][] = $this->title;

KeywordAdminAsset::register($this);

/* @var ArrayDataProvider $dataProvider Содержит массив выводимых DTO */
/* @var FindForm $searchModel Форма поиска записей */

$dataContentFunction = function(ViewForm $form, $key, $index, DataColumn $columnData) {
    $attribute = $columnData->attribute;
    return [
        'class' => 'j-entry-item',
        'data'  => [
            'name'  => $attribute,
            'value' => $form->getDto()->$attribute,
        ],
    ];
};

function drawInputWithLabel($name, $value, $entryId, $optionId, $label)
{
    return '<input
        class="j-custom-btn-group-item"
        type="radio" id="' . $name . '-' . $entryId . '-' . $optionId . '"
        name="' . $name . '-' . $entryId . '"
        value="' . $optionId . '"' .
        ($value === $optionId ? ' checked' : '') . '
    ><label for="' . $name . '-' . $entryId . '-' . $optionId . '">' . $label . '</label>';
}

?>

<div class="language-index">
    <div class="nav-tabs-custom">
        <div class="timeline-header clearfix">
            <?php
            if (Yii::$app->user->can('Admin.Keyword.Keyword.Create')) {
                echo Html::a(Yii::t('Admin.Keyword.Keyword', 'create', 'Добавить'), ['create'], [
                    'class'       => 'btn btn-lg btn-info btn-flat pull-right',
                    'data-toggle' => 'modal',
                    'data-target' => '#modal',
                ]);
            }
            ?>
        </div>
        <div class="box-body">
            <?php
            /* @noinspection PhpUnhandledExceptionInspection */
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'  => $searchModel,
                'options'      => [
                    'class' => 'grid-view table-responsive clearfix',
                ],
                'layout'       => '{items}{summary}{pager}',
                'tableOptions' => [
                    'class' => 'table table-bordered table-hover',
                ],
                'rowOptions'   => [
                    'class' => 'j-entry',
                ],
                'columns'      => [
                    'text'             => [
                        'attribute'      => 'text',
                        'contentOptions' => $dataContentFunction,
                    ],
                    [
                        'attribute'      => 'personTypeId',
                        'filter'         => Html::activeDropDownList($searchModel, 'personTypeId', ArrayHelper::map($personTypeList, 'id', 'name'), [
                            'class'  => 'form-control',
                            'prompt' => 'Никакой',
                        ]),
                        'value'          => function(ViewForm $form) {
                            /* @var PersonTypeComponent $personTypeComponent */
                            $personTypeComponent = Yii::$app->get('personType');
                            $personType = $personTypeComponent->findOne()->byId((int)$form->getDto()->getPersonTypeId())->doOperation();
                            return $personType ? $personType->getName() : null;
                        },
                        'content'        => function(ViewForm $form, $key, $index, DataColumn $columnData) use ($personTypeList) {
                            $attribute = $columnData->attribute;
                            $inputs = '';
                            $options = ArrayHelper::map($personTypeList, 'id', 'name');
                            $value = $form->getDto()->$attribute;

                            $inputs .= drawInputWithLabel($attribute, $value, $key, null, 'Никакой');

                            foreach ($options as $optionId => $optionName) {
                                $inputs .= drawInputWithLabel($attribute, $value, $key, $optionId, $optionName);
                            }

                            return '<div class="custom-btn-group j-custom-btn-group" data-name="' . $attribute . '">' . $inputs . '</div>';
                        },
                        'contentOptions' => $dataContentFunction,
                    ],
                    'coincidenceCount' => [
                        'attribute'      => 'coincidenceCount',
                        'contentOptions' => $dataContentFunction,
                    ],
                    'ratio'            => [
                        'attribute'      => 'ratio',
                        'contentOptions' => $dataContentFunction,
                    ],
                    [
                        'class'          => ActionColumn::class,
                        'header'         => Yii::t('Admin.Keyword.Keyword', 'actionsHeader', 'Действия'),
                        'contentOptions' => [
                            'style' => 'width:1px',
                        ],
                        'template'       => '{update} {delete}',
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>

<?php
Modal::begin([
    'id'            => 'modal',
    'closeButton'   => false,
    'clientOptions' => false,
    'forceUpdate'   => true,
    'type'          => 'default',
]);
Modal::end();
?>
