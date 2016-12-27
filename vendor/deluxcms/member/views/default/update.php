<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Test */

$this->title = '更新会员';
$this->params['breadcrumbs'][] = ['label' => '会员列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title ;
?>
<div class="member-update">
   <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
