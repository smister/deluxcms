<?php

use yii\widgets\Breadcrumbs;

?>
<div class="row">
    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => '首页', 'url' => '/'],
        'links' => empty($category) ? [['label' => '帖子列表']] : [['label' => '帖子分类', 'url' => ['/post/list']], ['label' => $category->name]]
    ]) ?>
    <div class="col-sm-9">
    <div style="margin-top:20px;">
        <?=\deluxcms\post\widgets\PostListWidget::widget(['showOnEmpty' => false, 'dataProvider' => \deluxcms\post\models\Post::getPostListDataProvider(false, 10, ['category_id' => (empty($category) ? '' : $category->id)])]); ?>
        <!-- post-list -->
    </div>
    </div>
    <div class="col-sm-3">
        <?= \deluxcms\post\widgets\TagWidget::widget(['dataProvider' => \deluxcms\post\models\Tag::getTagDataProvider()])?>
        <?= \deluxcms\post\widgets\CategoryWidget::widget(['dataProvider' => \deluxcms\post\models\Category::getCategoryDataProvider()])?>
        <?= \deluxcms\post\widgets\PostHotListWidget::widget(['dataProvider' => \deluxcms\post\models\Post::getPostHotListDataProvider()]);?>

    </div>
</div>