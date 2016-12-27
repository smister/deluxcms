<?php

use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<?= Breadcrumbs::widget([
        'homeLink' => ['label' => '首页', 'url' => '/'],
        'links' => [
            ['label' => '会员中心', 'url' => ['index']],
            ['label' => '更新个人信息']
        ]
]) ?>

<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'nickname')->textInput() ?>
    <?= $form->field($model, 'address')->textInput() ?>
    <?= $form->field($model, 'sex')->radioList([1 => '男', 0 => '女']) ?>
    <div class="form-group">
        <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>