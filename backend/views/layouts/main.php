<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use backend\assets\MetisMenuAsset;

AppAsset::register($this);
MetisMenuAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>deluxcms后台管理系统</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <?php
        NavBar::begin([
            'brandLabel' => 'deluxcms后台管理系统',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-static-top navbar',
                'style' => 'margin-bottom: 0',
            ],
            'innerContainerOptions' => [
                'class' => 'container-fluid',
            ]
        ]);
        $menuItems = [
            ['label' => '欢迎您！ ' . Yii::$app->user->getIdentity()->username, 'items' => [
                ['label' => '修改密码', 'url' => ['/user/update-password']],
                ['label' => '注销', 'url' => ['/login/logout']],
            ]],

        ];


        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
        ?>
        <!-- 后台左边菜单栏 -->
        <div class="navbar-default sidebar metismenu active" role="navigation">
            <?= \backend\widgets\Nav::widget([
                'options' => [
                    'class' => 'nav side-menu in',
                ],
                'encodeLabels' => false,
                'dropDownCaret' => '<span class="arrow"></span>',
                'items' => \deluxcms\menu\models\Menu::getMenu(\common\models\Setting::getBackendMenuId()),
            ])?>
		</div>
    </nav>
    <div id="page-wrapper" style="min-height: 840px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                    <?php if (Yii::$app->session->hasFlash('crudMessage')): ?>
                        <div class="alert alert-info alert-dismissible alert-crud" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        <?= Yii::$app->session->getFlash('crudMessage') ?>
                    </div>
                    <?php endif; ?>
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
