<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Test */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="member-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'repassword')->passwordInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'avatar')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'registration_ip')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="record-info">
                        <?= $form->field($model, 'sex')->dropDownList([1 => '男', 0 => '女']) ?>
                        <?= $form->field($model, 'email_validate')->dropDownList([0 => '未验证', 1 => '已验证']) ?>
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
