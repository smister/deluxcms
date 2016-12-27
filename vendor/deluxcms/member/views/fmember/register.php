<?php

use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<?= Breadcrumbs::widget([
        'homeLink' => ['label' => '首页', 'url' => '/'],
        'links' => [
            ['label' => '会员注册']
        ]
]) ?>

<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'email')->textInput(['id' => 'device']) ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'repassword')->passwordInput() ?>
    <?= $form->field($model, 'verifyCode')->widget(\deluxcms\sms\widgets\SmsWidget::className())?>
    <div class="form-group">
        <?= Html::submitButton('注册', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>