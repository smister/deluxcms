<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use deluxcms\menu\assets\MenuAsset;
use yii\helpers\Url;
use yii\bootstrap\Alert;

MenuAsset::register($this);

$this->title = '菜单列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
            <?= Html::a('添加菜单', ['create'], ['class' => 'btn btn-sm btn-primary']) ?>
            <?= Html::a('添加菜单链接', ['/menu/menulink/create'], ['class' => 'btn btn-sm btn-primary']) ?>


            <?= Alert::widget([
                'options' => [
                    'class' => 'alert-primary menu-link-alert',
                ],
                'body' => '<span class="glyphicon glyphicon-refresh glyphicon-spin"></span>',
            ])?>

            <?= Alert::widget([
                'options' => [
                    'class' => 'alert-danger menu-link-alert',
                ],
                'body' => '保存菜单错误',
            ])?>

            <?= Alert::widget([
                'options' => [
                    'class' => 'alert-info menu-link-alert',
                ],
                'body' => '保存成功',
            ])?>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php Pjax::begin(['id' => 'menu-grid-pjax']); ?>
                    <?= \backend\grid\GridView::widget([
                        'id' => 'menu-grid',
                        'dataProvider' => $dataProvider,
                        'layout' => '{items}',
                        'columns' => [
                            [
                                'class' => 'backend\grid\columns\DataActionsColumn',
                                'attribute' => 'title',
                                'title' => function ($model) {
                                    return Html::a($model->title, ['/menu', "MenuLinkSearch[menu_id]" => $model->id], ['data-pjax' => 0]);
                                }
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="sortable-container menu-itemes">
                <?= $this->render('links', [
                    'menuLinkSearch' => $menuLinkSearch,
                    'params' => ['parent_id' => 0],
                ])?>
            </div>
        </div>
    </div>
</div>
    </div>
</div>
<script>
    var saveOrdersUrl = '<?= Url::to(['/menu/menulink/save-orders']) ?>';
</script>