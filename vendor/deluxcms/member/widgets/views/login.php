<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\captcha\Captcha;

?>
<?php $form = ActiveForm::begin([
        'id' => empty($id) ? $model->formName() : $id,
        'action' => $action
]); ?>
    <?php if ($authClient):?>
        <?= \deluxcms\authclient\widgets\AuthClientWidget::widget([
             'baseAuthUrl' => $authUrl,
             'popupMode' => $popupMode,
             'options' => $authClientOptions
        ]); ?>
    <?php endif; ?>
    <?= Html::hiddenInput('loginAjax', $loginAjax); ?>
    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
        'captchaAction' => $captchAction,
        'template' => '{input}{image}',
    ])?>
    <div style="color:#999;margin:1em 0">
        <?= Html::a('注册新用户', ['/member/register']) ?> |
        <?= Html::a('忘记密码？', ['/member/forget-password']) ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('登录', ['class' => 'btn btn-primary']) ?>
	</div>
<?php ActiveForm::end(); ?>

<?php

?>
