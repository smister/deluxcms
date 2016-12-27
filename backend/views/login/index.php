<?php

use backend\assets\LoginAsset;
use yii\helpers\Html;
use yii\captcha\Captcha;
LoginAsset::register($this);
?>
<div id="login_box">
    <h1>deluxcms后台管理系统</h1>
    <?= Html::beginForm('', 'post', ['id' => 'form']) ?>
      <ul>
         <li class="text">用户名：<?= Html::activeInput('text', $model, 'username', ['class' => 'input', 'id' => 'loginform-username']) ?></li>
         <li class="tip">&nbsp;<?= Html::error($model, 'username', ['class' => 'error'])?></li>
         <li>密　码：<?= Html::activeInput('password', $model, 'password', ['class' => 'input', 'id' => 'password']) ?></li>
         <li class="tip">&nbsp;<?= Html::error($model, 'password', ['class' => 'error'])?></li>
         <li style="position:relative;">验证码：
             <?= Captcha::widget([
                 'model' => $model,
                 'attribute' => 'verifyCode',
                 'captchaAction' => 'login/captcha',
                 'options' => [
                     'class' => 'input verifycode',
                     'id' => 'verifyCode',
                 ],
                 'imageOptions' => [
                    'class' => 'imagecode',
                     'id' => 'verifyCode-image',
                 ],
             ])?>
         </li>
         <li class="tip">&nbsp;<div class="error"></div></li>
         <li class="tip remember"><?= Html::activeCheckbox($model, 'rememberMe', ['id' => 'remember']) ?></li>
      </ul>
      <div>
          <?= Html::submitButton('登录', ['id' => 'login_submit']) ?>
      </div>
    <?= Html::endForm(); ?>
</div>
