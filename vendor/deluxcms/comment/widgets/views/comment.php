<div class="media-left">
    <img class="media-object" src="<?= \deluxcms\media\components\ImageUtils::thumbnail($model->member->avatar, 50, 50)?>" alt="<?= $model->member->nickname?>" width="50">
</div>
<div class="media-body">
    <h5 class="media-heading"><?= $model->member->nickname?>：</h5>
    <div class="media-content pt0" style="min-height:60px;">
        <?= !empty($model->recomment) ? '@' . $model->recomment->member->nickname : ''?> <?= $model->content?>
        <p>
            <span><?= date('Y-m-d H:i:s', $model->created_at)?></span>&nbsp;&nbsp;
            <?php if ($commentSwitch) :?>
                <a href="#comment-box" class="recomment-user" data="<?= $model->getEncodeParentId() ?>">
                    <span class="glyphicon glyphicon-share-alt"></span>
                    回复
                </a>
            <?php endif; ?>
        </p>
    </div>
    <?php if ($model->parent_id == 0) :?>
        <?= \yii\widgets\ListView::widget([
            'dataProvider' => $model->getRecommentDataProvider(),
            'showOnEmpty' => true,
            'layout' => '{items}',
            'options' => [
                'tag' => 'div',
                'class' => 'media pd0 mt0',
            ],
            'itemOptions' => [
                'tag' => 'div',
            ],
            'itemView' => function ($model, $key, $index, $widget) use ($commentSwitch){
                return $this->renderFile('@vendor/deluxcms/comment/widgets/views/comment.php', [
                    'model' => $model,
                    'commentSwitch' => $commentSwitch,
                ]);
            }
        ])?>
    <?php endif; ?>
</div>