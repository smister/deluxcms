<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Test */
/* @var $form yii\widgets\ActiveForm */

$categorys = \deluxcms\post\models\Category::getCategorysMap('', '', [0 => '请选择一个分类']);
?>

<div class="post-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'image')->widget(\deluxcms\media\widgets\FileInputWidget::className(), [
                        'id' => 'image',
                    ]) ?>
                    <?= $form->field($model, 'intro')->textarea(['maxlength' => true]) ?>
                    <?= $form->field($model, 'content')->widget(\deluxcms\media\widgets\TinyMceWidget::className(), [
                        'id' => 'content',
                    ]); ?>
                    <?= $form->field($model, 'tags')->widget(\deluxcms\post\widgets\MagicsuggestWidget::className(), [
                        'items' => \deluxcms\post\models\Tag::getAllTags(),
                    ]) ?>
                    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'seo_description')->textarea(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="record-info">
                        <?= $form->field($model, 'category_id')->dropDownList($categorys) ?>
                        <?= $form->field($model, 'order')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'count')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'published_at')->widget(\yii\jui\DatePicker::className(), [
                            'dateFormat' => 'yyyy-MM-dd',
                            'language' => 'zh-cn',
                            'options' => [
                                'class' => 'form-control',
                            ]
                        ]) ?>
                        <?= $form->field($model, 'comment_status')->dropDownList([1 => '开启', 0 => '禁用']) ?>
                        <?= $form->field($model, 'status')->dropDownList([1 => '开启', 0 => '禁用']) ?>
                    </div>
                </div>
            </div>

             <div class="panel panel-default">
                <div class="panel-body">
                    <div class="record-info">
                        <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('返回', ['index'], ['class' => 'btn btn-default']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>