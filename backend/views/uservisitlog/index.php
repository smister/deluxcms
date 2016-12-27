<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户登录日志';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'uservisitlog-grid-pjax']); ?>
            <?= \backend\grid\GridView::widget([
                'id' => 'uservisitlog-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'bulkActions' => ' ',
                'columns' => [
                    [
                        'attribute' => 'user_id',
                        'content' => function ($model, $key, $index, $column) {
                            return Html::a(isset($model->user) ? $model->user->username : '已删除', ['user/view', 'id' => $model->user_id], ['data-pjax' => 0]);
                        }
                    ],
                    'ip',
                    'user_agent',
                    'os',
                    'browser',
                    //'visit_time:datetime',
                    [
                        'class' => 'backend\grid\columns\DataDateColumn',
                        'attribute' => 'visit_time',
                        'format' => 'datetime',
                    ]
                ],
            ]); ?>
            <?php Pjax::end(); ?>
            </div>
        </div>
</div>