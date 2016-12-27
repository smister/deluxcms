<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '评论列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'comment-grid-pjax']); ?>
            <?= \backend\grid\GridView::widget([
                'id' => 'comment-grid',
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
                        'attribute' => 'content',
                        'buttonsTemplate' => '{delete}',
                    ],
                    [
                        'attribute' => 'post_id',
                        'content' => function ($model, $key, $index, $column) {
                            return empty($model->post) ? '无' : $model->post->title;
                        }
                    ],
                    [
                        'attribute' => 'member_id',
                        'content' => function ($model, $key, $index, $column) {
                            return empty($model->member) ? '无' : $model->member->nickname;
                        }
                    ],
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