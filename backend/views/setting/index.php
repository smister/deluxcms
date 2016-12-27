<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use deluxcms\media\widgets\FileInputWidget;
use deluxcms\media\widgets\TinyMceWidget;
use deluxcms\menu\models\Menu;

$this->title = '网站设置';
$this->params['breadcrumbs'][] = $this->title ;

$menu = \yii\helpers\ArrayHelper::merge(['' => '请选择一个菜单'], Menu::getMenuMap());

?>
<div class="test-update">
   <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
   <div class="user-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'logo')->widget(FileInputWidget::className(), [
                        'id' => 'logo',
                    ]) ?>
                    <?= $form->field($model, 'keyword')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'description')->textarea() ?>
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'backend_menu_id')->dropDownList($menu) ?>
                    <?= $form->field($model, 'frontend_menu_id')->dropDownList($menu) ?>
                    <?= $form->field($model, 'about_us')->widget(TinyMceWidget::className(), [
                        'id' => 'about_us',
                    ]) ?>
                    <?= $form->field($model, 'copyright')->widget(TinyMceWidget::className(), [
                        'id' => 'copyright',
                    ]) ?>
                    <div class="record-info">
                        <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
</div>
