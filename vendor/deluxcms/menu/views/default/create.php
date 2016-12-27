<?php

use yii\helpers\Html;

$this->title = '添加菜单';
$this->params['breadcrumbs'][] = ['label' => '菜单列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-create">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
