<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '授权管理列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-index">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'auth-grid-pjax']); ?>
            <?= \backend\grid\GridView::widget([
                'id' => 'auth-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'bulkActions' => ' ',
                'columns' => [
                    [
                        'attribute' => 'member_id',
                        'content' => function ($model) {
                            return empty($model->member) ? '' : $model->member->nickname;
                        },
                    ],
                    'source',
                    'source_id',
                ],

            ]); ?>
            <?php Pjax::end(); ?>
            </div>
        </div>
</div>