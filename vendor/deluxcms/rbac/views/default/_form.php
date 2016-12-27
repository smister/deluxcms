<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Test */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="role-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong><span class="glyphicon glyphicon-th"></span>权限节点</strong>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <?php $nodes = \deluxcms\rbac\models\Node::getNodes();?>
                                <?php foreach ($nodes as $node) :?>
                                <div class="col-sm-12">
                                    <fieldset>
                                        <legend>
                                            <?= Html::checkbox('parent', false, ['class' => 'parentNode']); ?>&nbsp;<?= $node['nickname']?>
                                        </legend>
                                        <?= Html::checkboxList(
                                            'Role[nodes]',
                                            $model->nodes,
                                            $node['nodes']
                                        )?>
                                    </fieldset>
                                    <br>
                                </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                    <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('返回', ['index'], ['class' => 'btn btn-default']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php $this->registerJs(<<<JS
    $(function(){
        $(".parentNode").click(function(){
        $(this).parent().parent().find("input[name*='Role[nodes]']").prop('checked',
        $(this).get(0).checked);
    });
    });
JS
)?>