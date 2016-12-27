<h4 class="bb-dashed-ccc pd10"><span class="glyphicon glyphicon-fire"></span> <?= empty($model->post) ? '' : $model->post->title ?></h4>
<div class="mt15">
    <?= $this->renderFile('@vendor/deluxcms/comment/widgets/views/memberCommentPost.php', ['model' => $model, 'dataProvider' => \deluxcms\comment\models\Comment::getMemberCommentPost($model->post_id, $model->member_id), 'isFirst' => true]);?>
</div>