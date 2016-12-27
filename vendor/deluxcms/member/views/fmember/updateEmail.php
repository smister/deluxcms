<?php

use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<?= Breadcrumbs::widget([
        'homeLink' => ['label' => '首页', 'url' => '/'],
        'links' => [
            ['label' => '会员中心', 'url' => ['index']],
            ['label' => '更新邮箱']
        ]
]) ?>

<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'email')->textInput(['id' => 'device']) ?>
    <?= $form->field($model, 'verifyCode')->widget(\deluxcms\sms\widgets\SmsWidget::className(), [
        'sendCodeUrl' => ['/site/send-code'],
    ])?>
    <div class="form-group">
        <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>