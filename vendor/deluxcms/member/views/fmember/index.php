<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>
<?= Breadcrumbs::widget([
        'homeLink' => ['label' => '首页', 'url' => '/'],
        'links' => [
            ['label' => '会员中心']
        ]
]) ?>

<div class="media">
    <div class="media-left">
        <img src="<?= \deluxcms\media\components\ImageUtils::thumbnail($member->avatar, 100, 100)?>">
    </div>
    <div class="media-body">
        <p class="mb5">
            <span class="pull-left">昵称：<?= $member->nickname ?></span>
            <a href="<?= Url::to(['update']) ?>" class="pull-right hover_noline">
                <span class="glyphicon glyphicon-pencil"></span> 编辑
            </a>
        </p>
        <p class="mb5 clear">性别：<?= $member->sex == 1 ? '男' : '女' ?></p>
        <p class="mb5">
            Emial：<?= $member->email ?>
            <?php if ($member->email_validate) :?>
                <a href="<?= Url::to(['verify-email']) ?>" class="small">修改</a>
            <?php elseif ($member->email) :?>
                <a href="<?= Url::to(['update-email']) ?>" class="small">验证</a>
            <?php else :?>
                <a class="small" href="<?= Url::to(['update-email']) ?>>">绑定邮箱</a>
            <?php endif;?>
        </p>
        <p class="mb5">地址：<?= $member->address ?></p>
    </div>
</div>
<?php Pjax::begin(['id' => 'member_comment'])?>
<?= \deluxcms\comment\widgets\MemberCommentWidget::widget([
    'dataProvider' => \deluxcms\comment\models\Comment::getMemberCommentPosts(Yii::$app->user->getId(), 1),
])?>
<?php Pjax::end();?>
