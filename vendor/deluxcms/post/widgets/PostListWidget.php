<?php

namespace deluxcms\post\widgets;

use yii\base\InvalidConfigException;
use yii\base\Widget;

class PostListWidget extends Widget
{
    public $dataProvider;
    public $showOnEmpty = true;
    public $layout = "{items}\n{pager}";
    public $options = [
        'tag' => 'ul',
        'class' => 'media-list'
    ];

    public $itemOptions = [
        'tag' => 'li',
        'class' => 'media pd10 bb-dashed-ccc',
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
                return $this->renderFile('@vendor/deluxcms/post/widgets/views/postlist.php', [
                    'model' => $model,
                ]);
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