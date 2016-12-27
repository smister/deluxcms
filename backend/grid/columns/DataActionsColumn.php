<?php

namespace backend\grid\columns;

use yii\grid\DataColumn;
use yii\helpers\Url;
use yii\helpers\Html;

class DataActionsColumn extends DataColumn
{
    public $controller;
    public $buttonsTemplate = '{view} {update} {delete}';
    public $buttons = [];
    public $urlCreator;
    public $buttonOptions = [];
    public $action = 'view';
    public $template = '<span class="action-title">{title}</span><div class="quick-actions">{buttons}</div>';
    public $title;

    public function init()
    {
        parent::init();
        $this->initDefaultButtons();
    }

    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url, $model, $key, $column) {
                $options = array_merge([
                    'title' => '查看',
                    'aria-label' => '查看',
                    'data-pjax' => '0',
                ], $column->buttonOptions);
                return Html::a('查看', $url, $options);
            };
        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model, $key, $column) {
                $options = array_merge([
                    'title' => '更新',
                    'aria-label' => '更新',
                    'data-pjax' => '0',
                ], $column->buttonOptions);
                return Html::a('更新', $url, $options);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model, $key, $column) {
                $options = array_merge([
                    'title' => '删除',
                    'aria-label' =>'删除',
                    'data-confirm' => '您确定要删除吗？这是不可逆操作',
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ], $column->buttonOptions);
                return Html::a('删除', $url, $options);
            };
        }
    }

    public function createUrl($action, $model, $key, $index)
    {
        if (is_callable($this->urlCreator)) {
            return call_user_func($this->urlCreator, $action, $model, $key, $index);
        } else {
            $params = is_array($key) ? $key : ['id' => (string) $key];
            $params[0] = $this->controller ? $this->controller . '/' . $action : $action;

            return Url::toRoute($params);
        }
    }

    protected function renderDataCellContent($model, $key, $index)
    {
        $buttons = preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $key, $index) {
            $name = $matches[1];

            if (isset($this->buttons[$name])) {
                $url = $this->createUrl($name, $model, $key, $index);
                return call_user_func($this->buttons[$name], $url, $model, $key, $this);
            } else {
                return '';
            }
        }, $this->buttonsTemplate);

        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $key, $index, $buttons) {
            $name = $matches[1];

            if ($name == 'buttons') {
                return $buttons;
            } elseif ($name == 'title') {
                //return parent::renderDataCellContent($model, $key, $index);
                return $this->getTitle($model, $key);
            } else {
                return '';
            }
        }, $this->template);

    }

    protected function getTitle($model, $key)
    {
        if ($this->title instanceof \Closure) {
            return call_user_func($this->title, $model);
        } else {
            return Html::a($model[$this->attribute], [$this->controller ? $this->controller . '/' . $this->action : $this->action, 'id' => $key], ['data-pjax' => 0]);
        }
    }
}