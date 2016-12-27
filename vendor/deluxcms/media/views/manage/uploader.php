<?php

use yii\helpers\Html;

$this->title = '图片上传';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div id="uploadManager">
            <p>
                <?= Html::a("←返回", $mode == 'modal' ? ['/media/manage/index', 'mode' => $mode] : ['/media/default/index'])?>
            </p>
            <?= \dosamigos\fileupload\FileUploadUI::widget([
                'model' => $model,
                'attribute' => 'file',
                //上传的路径
                'url' => ['upload'],
                //开启相册
                'gallery' => false,
                'fieldOptions' => [
                    'accept' => 'image/*'
                ],
                'clientOptions' => [
                    //上传文件的最大的容量
                    'maxFileSize' => 2000000
                ],
                //模板，formview是我们头部的按钮
                'formView' => '@vendor/deluxcms/media/views/manage/uploader/form',
                'uploadTemplateView' => '@vendor/deluxcms/media/views/manage/uploader/upload',
                'downloadTemplateView' => '@vendor/deluxcms/media/views/manage/uploader/download',
            ]); ?>
        </div>
    </div>
</div>