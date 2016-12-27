<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = '权限角色';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="node-index">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
            <?= Html::a('添加', ['create'], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'role-grid-pjax']); ?>
            <?= \backend\grid\GridView::widget([
                'id' => 'role-grid',
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
                        'attribute' => 'description',
                    ],
                    'name',
                ],

            ]); ?>
            <?php Pjax::end(); ?>
            </div>
        </div>
</div>