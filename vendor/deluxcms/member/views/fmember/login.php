<?php
use yii\widgets\Breadcrumbs;
?>
<?= Breadcrumbs::widget([
        'homeLink' => ['label' => '首页', 'url' => '/'],
        'links' => [
            ['label' => '会员登录']
        ]
]) ?>

<?= \deluxcms\member\widgets\LoginWidget::widget([
    'model' => $model,
    'authClient' => true,
])?>
