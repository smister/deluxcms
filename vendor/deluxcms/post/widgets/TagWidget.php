<?php

namespace deluxcms\post\widgets;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Url;

class TagWidget extends Widget
{
    public $dataProvider;
    public $showOnEmpty = true;
    public $layout = '<h4 class="h-title">标签云</h4>{items}';
    public $options = [
        'tag' => 'div',
        'class' => 'container-box'
    ];

    public $itemOptions = [
        'tag' => 'span',
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
                return '<a href="' . Url::to(['/tag/index', 'tagName' => $model->name]) . '" class="label-a"><span class="label ' . $model->getTagClass($key) . '">' . $model->name . '</span></a>';
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