<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = '权限节点';
$this->params['breadcrumbs'][] = $this->title;

$nodes = \deluxcms\rbac\models\Node::getParentNodes();
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
            <?php Pjax::begin(['id' => 'node-grid-pjax']); ?>
            <?= \backend\grid\GridView::widget([
                'id' => 'node-grid',
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
                        'attribute' => 'nickname',
                    ],
                    [
                        'filter' => $nodes,
                        'attribute' => 'parent_id',
                        'content' => function ($model, $key, $index, $column) use ($nodes) {
                            return isset($nodes[$model->parent_id]) ? $nodes[$model->parent_id] : '无';
                        }
                    ],
                    'name',
                ],

            ]); ?>
            <?php Pjax::end(); ?>
            </div>
        </div>
</div>