<?php

use yii\helpers\Html;

$this->title = '图片管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- media -->
<div class="media-index">
<div class="row">
 <div class="col-sm-12">
  <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
 </div>
</div>
<?= \deluxcms\media\widgets\GalleryWidget::widget() ?>
</div>
<!-- media -->
