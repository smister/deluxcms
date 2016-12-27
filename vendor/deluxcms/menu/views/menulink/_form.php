<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use deluxcms\menu\models\Menu;
use deluxcms\menu\components\FA;

?>

<div class="menulink-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="record-info">
                        <?= $form->field($model, 'menu_id')->dropDownList(Menu::getMenuMap()) ?>
                        <?= $form->field($model, 'image')->dropDownList(FA::getIconsList(), [
                            'class' => 'clearfix non-styler form-control fa-font-family',
                            'encode' => false,
                        ]) ?>
                    </div>
                </div>
            </div>
             <div class="panel panel-default">
                <div class="panel-body">
                    <div class="record-info">
                        <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('返回', ['/menu/default/index'], ['class' => 'btn btn-default']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
