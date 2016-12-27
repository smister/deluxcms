<?php

use yii\helpers\Html;
use deluxcms\post\models\Tag;
use yii\helpers\Url;

?>
<div class="media-left">
    <a href="<?= $model->slug ? Url::to(['/post/index', 'id' => $model->id, 'slug' => $model->slug]) : Url::to(['/post/index', 'id' => $model->id]) ?>">
        <img class="media-object" src="<?= \deluxcms\media\components\ImageUtils::thumbnail($model->image, 200, 140)?>" alt="<?= $model->title ?>">
    </a>
</div>
<div class="media-body">
    <h4 class="media-heading"><a href="<?= $model->slug ? Url::to(['/post/index', 'id' => $model->id, 'slug' => $model->slug]) : Url::to(['/post/index', 'id' => $model->id]) ?>"><?= $model->title ?></a></h4>
    <div class="media-info">分类：<?= empty($model->category) ? '无' : Html::a($model->category->name, ['/post/list', 'cid' => $model->category->id]); ?>&nbsp;&nbsp;浏览次数：<?= $model->count ?></div>
    <?php
        $tags = $model->getTagsName();
        if (!empty($tags)) :
    ?>
        <div class="media-info">标签：
            <?php foreach ($tags as $key => $tag) : ?>
                <a href="<?= Url::to(['/tag', 'tagName' => $tag['name']]) ?>"><span class="label <?= Tag::getTagClass($key) ?>"><?= $tag['name']; ?></span></a>
            <?php endforeach; ?>
        </div>
    <?php
        endif;
    ?>
    <div class="media-content">
        <?= $model->intro; ?>
    </div>
</div>