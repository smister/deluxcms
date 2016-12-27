<?php

use yii\helpers\Html;

$this->title = '更新菜单链接';
$this->params['breadcrumbs'][] = ['label' => '菜单列表', 'url' => ['/menu/default/']];
$this->params['breadcrumbs'][] = $this->title ;
?>
<div class="menulink-update">
   <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
