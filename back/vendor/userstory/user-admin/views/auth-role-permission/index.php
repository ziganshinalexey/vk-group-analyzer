<?php

use Userstory\ModuleAdmin\components\View;
use Userstory\ModuleAdmin\widgets\GridView\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/* @var View $this*/
/* @var ActiveDataProvider $dataProvider */

$this->title                   = 'Auth Role Permissions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-role-permission-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Auth Role Permission', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns'      => [
        ['class' => 'yii\grid\SerialColumn'],
        'roleId',
        'permission',
        'isGlobal',
        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
</div>
