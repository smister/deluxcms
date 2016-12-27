<?php

use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<?= Breadcrumbs::widget([
        'homeLink' => ['label' => '首页', 'url' => '/'],
        'links' => [
            ['label' => '会员中心', 'url' => ['index']],
            ['label' => '修改密码'],
        ]
]) ?>

<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'oldpassword')->passwordInput() ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'repassword')->passwordInput() ?>
    <div class="form-group">
        <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>