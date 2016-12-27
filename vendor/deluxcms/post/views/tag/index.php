<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '标签列表';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="tag-index">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
            <?= Html::a('添加', ['create'], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'tag-grid-pjax']); ?>
            <?= \backend\grid\GridView::widget([
                'id' => 'tag-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'bulkActionOptions' => [
                    'actions' => [
                            Url::to(['bulk-delete']) => '删除'
                    ],
                ],
                'columns' => [
                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        'options' => [
                            'style' => 'width:10px'
                        ]
                    ],
                    [
                        'class' => 'backend\grid\columns\DataActionsColumn',
                        'attribute' => 'name',
                    ],
                    'created_at:datetime'
                ],

            ]); ?>
            <?php Pjax::end(); ?>
            </div>
        </div>
</div>