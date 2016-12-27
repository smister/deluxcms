<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="<?= \frontend\components\Setting::getInstance()->getKeywords() ?>" />
    <meta name="description" content="<?= \frontend\components\Setting::getInstance()->getDescription() ?>" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(\frontend\components\Setting::getInstance()->getTitle()) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => \frontend\components\Setting::getInstance()->getName(),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => '首页', 'url' => ['/site/index']],
        //['label' => '文章列表', 'url' => ['/post/list']],
    ];

    $frontMenuItems = \deluxcms\menu\models\Menu::getMenu(\frontend\components\Setting::getInstance()->getFrontMenuId());
    $menuItems = array_merge($menuItems, $frontMenuItems);

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '注册', 'url' => ['/member/register']];
        $menuItems[] = ['label' => '登录', 'url' => ['/member/login']];
    } else {
         $menuItems[] = ['label' => Yii::$app->user->getIdentity()->username, 'items' => [
             ['label' => '个人中心', 'url' => ['/member/index']],
             ['label' => '修改密码', 'url' => ['/member/update-password']],
             ['label' => '注销', 'url' => ['/member/logout']],
         ]];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <?= \frontend\components\Setting::getInstance()->getCopyright()?>
    </div>
</footer>

<?php \yii\bootstrap\Modal::begin([
    'header' => '<h6>&nbsp;</h6>',
    'headerOptions' => [
    'class' => 'modal-header modal-header-fix'
    ],
    'id' => 'msg-alter',
])?>
<div id="alter-msg" class="text-center"></div>
<?php \yii\bootstrap\Modal::end()?>


<!-- 登录框 -->
<?php if (Yii::$app->user->isGuest) :?>
    <?php \yii\bootstrap\Modal::begin([
        'header' => '<h4>登陆</h4>',
        'id' => 'loginModal',
    ])?>
    <?= \deluxcms\member\widgets\LoginWidget::widget(['loginAjax' => true]) ?>
    <?php \yii\bootstrap\Modal::end()?>
<!-- 登录框 -->
<?php endif; ?>




<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
