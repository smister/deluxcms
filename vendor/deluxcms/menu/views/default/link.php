<?php

use yii\helpers\Html;

?>
<div class="sortable-item-content" data-linkid="<?= $model->id ?>">
    <div class="pull-left" style="padding: 3px 15px 0 0;">
        <i class="fa fa-<?= $model->image ?> fa-lg fa-fw"></i>
    </div>
    <div class="pull-left">
        <b><?= $model->label ?></b><br>
        <span class="menu-link"><?= $model->link ? '[ '. $model->link .' ]' : '' ?></span>
    </div>
    <div class="menu-link-actions">
        <?= Html::a('[ 编辑 ]', ['/menu/menulink/update', 'id' => $model->id], ['data-pjax' => 0])?>
        <br>
        <?= Html::a('[ 删除 ]', ['/menu/menulink/delete', 'id' => $model->id], ['data-pjax' => 0, 'data-confirm' => '您确定要删除吗？这是不可逆操作', 'data-method' => 'post'])?>
    </div>
</div>
<span class="sortable-drag-icon glyphicon glyphicon-move"></span>
<?= $this->render('links', [
    'menuLinkSearch' => $menuLinkSearch,
    'params' => ['parent_id' => $model->id],
])?>