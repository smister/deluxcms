<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Test */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="node-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="record-info">
                        <?= $form->field($model, 'parent_id')->dropDownList(\deluxcms\rbac\models\Node::getParentNodes()) ?>
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
