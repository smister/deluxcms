<?php

namespace deluxcms\comment\widgets;

use yii\base\Widget;
use yii\data\Pagination;
use yii\widgets\Pjax;

class MemberCommentWidget extends Widget
{
    public $title = '评论列表';
    public $dataProvider;
    public $layout = '<div class="mt30"><h4 class="h-title">{title}</h4>{items}{pager}</div>';
    public $options =[
        'tag' => 'ul',
        'class' => 'media-list mt15 pl15',
    ];
    public $itemOptions = [
        'tag' => 'li',
        'class' => 'media',
    ];

    public $itemView;
    public $pjax = true;

    public function init()
    {
        if ($this->dataProvider === null) {
            throw new InvalidConfigException("DataProvider不能为空");
        }

        if ($this->itemView === null) {
            $this->itemView = function ($model, $key, $index, $widget) {
                return $this->renderFile('@vendor/deluxcms/comment/widgets/views/memberCommentPosts.php', ['model' => $model]);
            };
        }
    }

    public function run()
    {
        $this->layout = str_replace('{title}', $this->title, $this->layout);
        return \yii\widgets\ListView::widget([
            'dataProvider' => $this->dataProvider,
            'layout' => $this->layout,
            'options' => $this->options,
            'itemOptions' => $this->itemOptions,
            'itemView' => $this->itemView,
        ]);
    }
}