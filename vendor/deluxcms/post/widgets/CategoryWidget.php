<?php

namespace deluxcms\post\widgets;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;

class CategoryWidget extends Widget
{
    public $dataProvider;
    public $showOnEmpty = true;
    public $layout = '<h4 class="h-title">分类</h4><ul class="nav nav-pills nav-stacked">{items}</ul>';
    public $options = [
        'tag' => 'div',
        'class' => 'container-box mt15'
    ];

    public $itemOptions = [
        'tag' => 'li',
        'role' => 'presentation',
    ];

    public $itemView;

    public function init()
    {
        parent::init();

        if ($this->dataProvider === null) {
            throw new InvalidConfigException("dataProvider不能为空");
        }

        if ($this->itemView === null) {
            $this->itemView = function ($model, $key, $index, $widget) {
                    return Html::a($model->getCategoryName(), ['/post/list', 'cid' => $model->id], ['class' => 'color-gray']);
            };
        }
    }

    public function run()
    {
        return \yii\widgets\ListView::widget([
                'dataProvider' => $this->dataProvider,
                'showOnEmpty' => $this->showOnEmpty,
                'layout' => $this->layout,
                'options' => $this->options,
                'itemOptions' => $this->itemOptions,
                'itemView' => $this->itemView
            ]);
    }
}