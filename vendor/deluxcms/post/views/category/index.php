<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '帖子分类列表';
$this->params['breadcrumbs'][] = $this->title;

$categorys = \deluxcms\post\models\Category::getCategorysMap();

?>
<div class="category-index">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
            <?= Html::a('添加', ['create'], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'category-grid-pjax']); ?>
            <?= \backend\grid\GridView::widget([
                'id' => 'category-grid',
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
                        'attribute' => 'name',
                    ],
                    [
                        'filter' => $categorys,
                        'attribute' => 'parent_id',
                        'content' => function ($model, $key, $index, $column) use($categorys) {
                            return isset($categorys[$model->parent_id]) ? trim($categorys[$model->parent_id], '　') : '';
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