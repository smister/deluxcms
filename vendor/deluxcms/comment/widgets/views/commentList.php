<?php

use yii\widgets\Pjax;

?>
<!-- 评论列表 -->
<div class="mt30">
    <h4 class="h-title"><?= $title ?></h4>
    <?php Pjax::begin(['id' => 'comment-list']); ?>
        <?= $listView; ?>
    <?php Pjax::end(); ?>
</div>
<!-- 评论列表 -->