<?php

namespace backend\grid;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Url;

class GridBulkActions extends Widget
{
    public $wapperClass = 'form-inline';
    public $gridId;
    public $dropDownClass = 'form-control input-sm';
    public $promptText = '-- 请选择 --';
    public $actions;
    public $buttonClass = 'btn btn-sm btn-default';
    public $confirmText = '您确定要删除吗？这是不可撤销操作';

    public function init()
    {
        parent::init();
        if ($this->gridId === null) {
            throw new InvalidConfigException("没有找到girdId");
        }
    }

    public function run()
    {
        $this->setDefaultOptions();
        return $this->render('bulk-actions');
    }


    protected function setDefaultOptions()
    {
        if ($this->actions === null) {
            $this->actions = [
                Url::to(['bulk-activate']) => '开启',
                Url::to(['bulk-deactivate']) => '禁用',
                Url::to(['bulk-delete']) => '删除',
            ];
        }

        $this->js();
    }

    protected function js()
    {
        \Yii::$app->view->registerJs(<<<JS
        // Select values in bulk actions list
        $(document).off('change', '[name="grid-bulk-actions"]').on('change', '[name="grid-bulk-actions"]', function () {
            var _t = $(this);
            //data-ok-button
            var okButton = $(_t.data('ok-button'));

            if (_t.val()) {
                okButton.removeClass('disabled');
            }
            else {
                okButton.addClass('disabled');
            }
        });

        // Clicking OK button
        $(document).off('click', '.grid-bulk-ok-button').on('click', '.grid-bulk-ok-button', function () {
            var _t = $(this);
            //data-list
            var list = $(_t.data('list'));

            if (list.val().indexOf('bulk-delete') >= 0) {
                if ( ! confirm('{$this->confirmText}') )
                    return false;
            }
            //data-grid
            $.post(list.val(), $(_t.data('grid') + ' [name="selection[]"]').serialize() )
                .done(function(){
                    _t.addClass('disabled');
                    list.val('');
                    //data-pjax
                    $.pjax.reload({container: _t.data('pjax')});
                });
        });
JS
);
    }

}