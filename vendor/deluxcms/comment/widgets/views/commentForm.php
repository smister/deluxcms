<?php

use yii\helpers\Html;
use yii\captcha\Captcha;

$member = Yii::$app->user->getIdentity();
?>
<!-- 发表评论 -->
<div class="mt30">
    <h4 class="h-title"><?= $title ?></h4>
    <div class="media pd10">
        <div class="media-left pr5">
            <img class="media-object" src="<?= \deluxcms\media\components\ImageUtils::thumbnail((empty($member) ? '' : $member->avatar), 50, 50) ?>" alt="头像" width="50">
        </div>
        <div class="media-body" id="comment-box">
            <?= Html::beginForm($action, 'post', ['id' => 'comment-form'])?>
                <?= Html::hiddenInput('postId', $postId) ?>
                <?= Html::hiddenInput('parentId', '', ['id' => 'comment-recomment']) ?>
                <div class="form-group" id="re-title" style="display:none;">
                    <a class="btn" id="remove-recomment" alt="点击移除回复">
                        <span id="recomment-user"></span>
                    </a>
                </div>
                <div class="form-group">
                    <?= Html::textarea('content', '', ['class' => 'form-control', 'id' => 'comment-content', 'placeholder' => '评论内容']) ?>
                </div>
                <div class="form-group">
                    <?= Captcha::widget([
                            'name' => 'verifyCode',
                            'options' => [
                                'class' => 'form-control',
                                'placeholder' => '请输入验证码',
                            ],
                            'captchaAction' => $captchaAction,
                            'template' => '{input}{image}',
                    ]) ?>
                </div>
                <?= Html::button('发表', ['class' => 'btn btn-primary', 'id' => 'comment', 'style' => 'float:right;']) ?>
            <?= Html::endForm(); ?>
        </div>
    </div>
</div>
<!-- 发表评论 -->