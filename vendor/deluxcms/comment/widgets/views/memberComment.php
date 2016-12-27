<div class="media-left">
   <img class="media-object" src="<?= \deluxcms\media\components\ImageUtils::thumbnail($model->member->avatar)?>" alt="头像" width="40">
</div>
<div class="media-body">
  <!-- 个人评论 -->
  <h5 class="media-heading"><?= $model->member_id == Yii::$app->user->getId() ? '我' : $model->member->nickname ?></h5>
  <div class="media-content pt0" style="min-height:30px;">
    <?= $model->content ?>
  </div>
    <?php if (!empty($isFirst)) :?>
        <?= $this->renderFile('@vendor/deluxcms/comment/widgets/views/memberCommentPost.php', ['model' => $model, 'dataProvider' => \deluxcms\comment\models\Comment::getMemberComment($model->id), 'isFirst' => false]);?>
    <?php endif;?>
</div>

