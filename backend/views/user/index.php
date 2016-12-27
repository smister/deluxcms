<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
            <?= Html::a('添加', ['create'], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'user-grid-pjax']); ?>
            <?= \backend\grid\GridView::widget([
                'id' => 'user-grid',
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
                        'buttonsTemplate' => '{view} {update} {grantAuthrity} {delete}',
                        'buttons' => [
                            'grantAuthrity' =>  function ($url, $model, $key, $column) {
                                $options = array_merge([
                                    'title' => '授权',
                                    'aria-label' => '授权',
                                    'data-pjax' => '0',
                                ], $column->buttonOptions);
                                return Html::a('授权', ['/rbac/default/grant-authrity', 'userId' => $model->id], $options);
                            }
                        ]
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