<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use deluxcms\media\components\ImageUtils;
use yii\widgets\ActiveForm;
use yii\grid\GridViewAsset;
use deluxcms\media\assets\MediaAsset;

GridViewAsset::register($this);
MediaAsset::register($this);

?>
<!-- 检索 -->
<div class="row">
 <div class="col-sm-12">
  <div class="panel panel-default">
   <div style="padding: 5px; height:50px;" class="panel-body">
    <?php $form = ActiveForm::begin([
        'id' => 'gallery',
        'action' => $mode == 'modal' ? ['/media/manage/index', 'mode' => $mode] : ['/media/default/index'],
        'class' => 'gridview-filter-form',
        'method' => 'get',
        'fieldConfig' =>[
            'template' => "{input}\n{hint}\n{error}",
        ]
    ]) ?>
       <table id="gallery-grid-filters" class="table table-striped filters">
          <thead>
           <tr id="user-visit-log-grid-filters" class="filters">
            <td style="width: auto;">
                <?= $form->field($searchModel, 'filename')->textInput(['placeholder' => '文件名称'])?>
            </td>
            <td style="width: auto;">
               <?= $form->field($searchModel, 'created_at')->widget(\yii\jui\DatePicker::className(), [
                   'dateFormat' => 'yyyy-MM-dd',
                   'language' => 'zh-cn',
                   'options' => [
                       'class' => 'form-control',
                       'placeholder' => '创建时间'
                   ]
               ])?>
            </td>
            <td style="width: 1%;">
                <?= Html::a('上传图片', ['/media/manage/uploader', 'mode' => $mode], ['class' => 'btn btn-primary pull-right'])?>
            </td>
           </tr>
          </thead>
         </table>
    <?php $form->end()?>
   </div>
  </div>
 </div>
</div>
<!-- 检索 -->

<!-- 列表数据 -->
<div class="row normal-media-frame">
 <!-- 左边列表数据 -->
 <div class="col-sm-8">
  <div class="panel panel-default">
   <div class="panel-body">
    <div id="media" data-frame-mode="normal" data-url-info="<?= Url::to(['/media/manage/info', 'mode' => $mode]) ?>">
     <?= ListView::widget([
         'dataProvider' => $dataProvider,
         'layout' => '<div class="items">{items}</div><div class="text-center">{pager}</div>',
         'options' => [
             'class' => 'list-view',
         ],
         'itemOptions' => [
            'class' => 'item',
         ],
         'itemView' => function ($model, $key, $index, $widget) {
             return Html::a(Html::img(ImageUtils::thumbnail($model->url)), '#mediafile', ['data-key' => $key]);
         }
     ]); ?>
    </div>
   </div>
  </div>
 </div>
 <!-- 左边列表数据 -->

 <!-- 右边详细数据 -->
 <div class="col-sm-4">
  <div class="panel panel-default">
   <div class="panel-body media-details">
    <div class="dashboard">
     <h5>图片详情:</h5>
     <div id="fileinfo">
        <h6>点击查看图片详情</h6>
     </div>
    </div>
   </div>
  </div>
 </div>
 <!-- 右边详细数据 -->
</div>
<!-- 列表数据 -->
<?php
//Init AJAX filter submit
$options = '{"filterUrl":"' . Url::to($mode == 'modal' ? ['media/manage/index', 'mode' => $mode] : ['media/default/index']) . '","filterSelector":"#gallery-grid-filters input, #gallery-grid-filters select"}';
$this->registerJs("jQuery('#gallery').yiiGridView($options);");
?>