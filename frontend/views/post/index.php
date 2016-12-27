<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;


$tags = $post->getTagsName();
?>
<div class="row">
    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => '首页', 'url' => '/'],
        'links' => [
            ['label' => '帖子列表', 'url' => ['/post/list']],
            ['label' => $post->title]
        ]
    ]) ?>
    <div class="col-sm-9">
    <div style="margin-top:20px;">
        <h1><?= $post->title ?></h1>
            <small>分类：<?= isset($post->category) ? Html::a($post->category->name, ['/post/list', 'cid' => $post->category->id]) : '无';?>&nbsp;&nbsp;&nbsp;浏览次数：<?= $post->count ?>&nbsp;&nbsp;&nbsp;发布时间：<?= date('Y-m-d H:i:s', $post->published_at) ?></small>
            <p>
                <small>
                    <?php
                        if (!empty($tags)) :
                            foreach ($tags as $key => $tag) :
                    ?>
                        <a href="<?= Url::to(['/tag', 'tagName' => $tag['name']])?>" class="label-a"><span class="label <?= \deluxcms\post\models\Tag::getTagClass($key) ?>"><?= $tag['name'] ?></span></a>
                    <?php
                            endforeach;
                        endif;
                    ?>
                </small>
            </p>
            <div class="mt15">
                <?= $post->content ?>
            </div>
            <!--分享插件-->
            <div class="bdsharebuttonbox bdshare-button-style0-16" data-bd-bind="1477391170241"><a href="#" class="bds_more" data-cmd="more">分享到：</a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间">QQ空间</a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博">新浪微博</a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博">腾讯微博</a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信">微信</a></div>
            <?= \deluxcms\comment\widgets\CommentListWidget::widget(['dataProvider' => \deluxcms\comment\models\Comment::getCommentsDataProvider($post->id, 10)])?>
            <?= \deluxcms\comment\widgets\CommentFormWidget::widget(['postId' => $post->id]); ?>
    </div>
    </div>
    <div class="col-sm-3">
        <?= \deluxcms\post\widgets\TagWidget::widget(['dataProvider' => \deluxcms\post\models\Tag::getTagDataProvider()])?>
        <?= \deluxcms\post\widgets\CategoryWidget::widget(['dataProvider' => \deluxcms\post\models\Category::getCategoryDataProvider()])?>
        <?= \deluxcms\post\widgets\PostHotListWidget::widget(['dataProvider' => \deluxcms\post\models\Post::getPostHotListDataProvider()]);?>

    </div>
</div>
<?php $this->registerJs(<<<JS
     var article_share_content = "《{$post->title}》 {$post->intro}";
     window._bd_share_config={"common":{"bdSnsKey":{},"bdText":article_share_content,"bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{"bdSize":16}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
JS
); ?>