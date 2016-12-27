<?php

use yii\helpers\Html;

$this->title = '添加菜单链接';
$this->params['breadcrumbs'][] = ['label' => '菜单列表', 'url' => ['/menu/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menulink-create">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
