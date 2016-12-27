<?php

use deluxcms\media\components\ImageUtils;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$mode = Yii::$app->request->get('mode', '');

?>
<!-- 点击查看图片详情 -->
<div class="clearfix"></div>
<div class="clearfix">
    <a target="_blank" href="#">
        <img src="<?= ImageUtils::thumbnail($model->url)?>" alt="" />
    </a>
    <ul class="detail">
        <li><b>图片类型:</b> <?= $model->type ?></li>
        <li><b>上传时间:</b> <?= date('Y-m-d H:i:s', $model->created_at) ?></li>
        <li><b>更新时间:</b> <?= date('Y-m-d H:i:s', $model->updated_at) ?></li>
        <li><b>文件大小:</b> <?= $model->size ?>B</li>
    </ul>
</div>

<?php if ($mode == 'modal') :?>
    <br/>
    <?= Html::hiddenInput('url', $model->url, ['id' => 'media-input-filename']) ?>
    <?= Html::hiddenInput('originalUrl', $model->getOriginaUrl(), ['id' => 'media-original-url']) ?>
    <?= Html::hiddenInput('thumbnail', ImageUtils::thumbnail($model->url), ['id' => 'media-input-thumbnail']) ?>
    <?= Html::button("插入", ['class' => 'btn btn-primary', 'id' => 'insert-btn'])?>
<?php else :?>
<?php $form = ActiveForm::begin([
    'id' => 'control-form',
    'action' => ['/media/manage/update', 'id' => $model->id, 'mode' => $mode],
    'method' => 'post',
])?>
    <?= $form->field($model, 'filename')->textInput()?>
    <?= Html::submitButton("保存", ['class' => 'btn btn-primary']); ?>
    <?= Html::a('删除', ['/media/manage/delete', 'id' => $model->id, 'mode' => $mode], ['class' => 'btn btn-default', 'data-message' => '你确定要删除,这是不可能逆操作', 'data-id' => $model->id, 'role' => 'delete']) ?>
<?php $form->end()?>
<?php endif;?>
