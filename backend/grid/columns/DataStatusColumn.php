<?php

namespace backend\grid\columns;

use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\bootstrap\Html;
use yii\grid\DataColumn;
use yii\helpers\Url;

class DataStatusColumn extends DataColumn
{
    public $labelOptions;

    public $dataOption;
    public $dataOptionClass;
    public $toggleUrl;
    public $toggle = true;

    public $controller;
    public $action = 'toggle-attribute';

    public function init()
    {
        parent::init();
        $this->setDefaultOptions();
        $this->handlerDataOption();
        $this->setDefaultContent();
    }

    protected function setDefaultOptions()
    {
        if (empty($this->labelOptions['style'])) {
            $this->labelOptions['style'] = 'font-size:85%;cursor:pointer;';
        }

        if (empty($this->labelOptions['data-type'])) {
            $this->labelOptions['data-type'] = 'grid-toggle-pjax';
        }

        if (empty($this->labelOptions['class'])) {
            $this->labelOptions['class'] = 'label ';
        }

        if ($this->dataOption === null) {
            $this->dataOption = [
                [1, '开启', 'primary'],
                [0, '禁用', 'info']
            ];
        }

        if ($this->toggle) {
            $this->js();
        }
    }

    protected function handlerDataOption()
    {
        try {
            foreach ($this->dataOption as $data) {
                $this->filter[$data[0]] = $data[1];
                $this->dataOptionClass[$data[0]] = $data[2];
            }
        } catch (Exception $e) {
            throw new InvalidConfigException("dataOption的数据格式错误");
        }
    }

    protected function setDefaultContent()
    {
        if ($this->content === null) {
            $this->content = function ($model, $key, $index, $column) {
                $labelOptions = $this->labelOptions;
                $labelOptions['class'] .= 'label-' . ($this->dataOptionClass[$model[$column->attribute]] ?  $this->dataOptionClass[$model[$column->attribute]] : 'info');
                $labelOptions['data-url'] = $this->toggleUrl === null ? Url::to([$this->controller ? $this->controller . '/' . $this->action : $this->action, 'attribute' => $column->attribute, 'id' => $model->id]) : call_user_func($this->toggleUrl, $model, $key, $index, $column);
                return Html::tag('span', $this->filter[$model[$column->attribute]] ? $this->filter[$model[$column->attribute]] : '', $labelOptions);
            };
        }
    }

    protected function js()
    {
        \Yii::$app->view->registerJs(<<<JS
            $(document).off('click', "[data-type='grid-toggle-pjax']").on('click', "[data-type='grid-toggle-pjax']", function () {
                $.get($(this).data('url')).success(function(){
                    $.pjax.reload({container: '#{$this->grid->id}-pjax'});
                });
            });
JS
);
    }
}