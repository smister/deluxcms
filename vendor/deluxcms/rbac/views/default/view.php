<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Test */

$this->title = '查看 - '. $model->description;
$this->params['breadcrumbs'][] = ['label' => '权限角色', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-view">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <div class="panel panel-default">
        <div class="panel-body">
        <?= Html::a('添加', ['create', 'id' => $model->name], ['class' => 'btn btn-sm btn-primary']) ?>
        <?= Html::a('更新', ['update', 'id' => $model->name], ['class' => 'btn btn-sm btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->name], [
            'class' => 'btn btn-sm btn-default',
            'data' => [
                'confirm' => '您确定删除吗？这是不可逆操作',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('返回', ['index'], ['class' => 'btn btn-sm btn-default']) ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <h3><?= $model->description ?></h3>
        </div>
    </div>

</div>
