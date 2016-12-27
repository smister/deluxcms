<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Test */

$this->title = '更新权限节点';
$this->params['breadcrumbs'][] = ['label' => '权限节点', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title ;
?>
<div class="node-update">
   <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
