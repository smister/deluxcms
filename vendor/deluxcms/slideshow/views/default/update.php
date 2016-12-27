<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Test */

$this->title = '更新轮播图';
$this->params['breadcrumbs'][] = ['label' => '轮播图管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title ;
?>
<div class="slideshow-update">
   <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
