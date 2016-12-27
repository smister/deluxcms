<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '用户授权';
$this->params['breadcrumbs'][] = ['label' => '用户列表', 'url' => ['/user/index']];
$this->params['breadcrumbs'][] = $this->title ;
?>
<div class="node-update">
   <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
   <div class="role-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= $form->field($user, 'username')->textInput(['disabled' => true]) ?>
                    <div class="form-group field-user-username required">
                        <label for="user-username" class="control-label">角色列表</label>
                        <?= Html::checkboxList('roles', $userRoles, $roles)?>
                        <div class="help-block"></div>
                    </div>
                    <?= Html::submitButton('授权', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
</div>