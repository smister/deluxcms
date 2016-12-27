<?php
    use yii\helpers\Html;
?>
<div class="<?= $this->context->wapperClass; ?>">
    <?= Html::dropDownList(
        'grid-bulk-actions',
        null,
        $this->context->actions,
        [
            'id' => $this->context->gridId . "-bulk-actions",
            'class' => $this->context->dropDownClass,
            'data-ok-button' => "#" . $this->context->gridId . "-ok-button",
            'prompt' => $this->context->promptText,
        ]
    )?>
    <span id="<?= $this->context->gridId ?>-ok-button" class="grid-bulk-ok-button <?= $this->context->buttonClass ?> disabled" data-list="#<?= $this->context->gridId ?>-bulk-actions" data-pjax="#<?= $this->context->gridId ?>-pjax" data-grid="#<?= $this->context->gridId ?>">提交</span>
</div>