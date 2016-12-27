<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '会员列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-index">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
            <?= Html::a('添加', ['create'], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'member-grid-pjax']); ?>
            <?= \backend\grid\GridView::widget([
                'id' => 'member-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        'options' => [
                            'style' => 'width:10px'
                        ]
                    ],
                    [
                        'class' => 'backend\grid\columns\DataActionsColumn',
                        'attribute' => 'username',
                    ],
                    'email',
                    'created_at:datetime',
                    [
                        'class' => 'backend\grid\columns\DataStatusColumn',
                        'attribute' => 'status',
                    ]
                ],

            ]); ?>
            <?php Pjax::end(); ?>
            </div>
        </div>
</div>