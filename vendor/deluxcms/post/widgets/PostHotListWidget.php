<?php

namespace deluxcms\post\widgets;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Url;

class PostHotListWidget extends Widget
{
    public $dataProvider;
    public $showOnEmpty = true;
    public $layout = '<h4 class="h-title">热门帖子</h4><ul class="media-list">{items}</ul>';
    public $options = [
        'tag' => 'div',
        'class' => 'container-box mt15'
    ];

    public $itemOptions = [
        'tag' => 'li',
        'class' => 'media',
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
                    return '<div class="media-body">
                            <a href="' . ($model->slug ? Url::to(['/post/index', 'id' => $model->id, 'slug' => $model->slug]) : Url::to(['/post/index', 'id' => $model->id]) ) . '" class="cl333 media-list-links ">
                                ' . $model->title . '
                                <br/>
                                <small class="cl999">分类：' . (isset($model->category) ? $model->category->name : '无')  . '　浏览量：' . $model->count . '</small>
                            </a>
                        </div>';
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