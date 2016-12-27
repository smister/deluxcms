<div class="row">
    <div class="col-sm-9">
    <!-- 轮播图 -->
    <?= \deluxcms\slideshow\widgets\CarouselWidget::widget(['items' => \deluxcms\slideshow\models\Slideshow::getSlideshows()]);?>
    <!-- 轮播图 -->
    <div style="margin-top:20px;">
        <?=\deluxcms\post\widgets\PostListWidget::widget(['dataProvider' => \deluxcms\post\models\Post::getPostListDataProvider(10)]); ?>
        <!-- post-list -->
    </div>
    </div>
    <div class="col-sm-3">
        <?= \deluxcms\post\widgets\TagWidget::widget(['dataProvider' => \deluxcms\post\models\Tag::getTagDataProvider()])?>
        <?= \deluxcms\post\widgets\CategoryWidget::widget(['dataProvider' => \deluxcms\post\models\Category::getCategoryDataProvider()])?>
        <?= \deluxcms\post\widgets\PostHotListWidget::widget(['dataProvider' => \deluxcms\post\models\Post::getPostHotListDataProvider()]);?>

    </div>
</div>
