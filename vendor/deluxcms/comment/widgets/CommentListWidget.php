<?php

namespace deluxcms\comment\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use deluxcms\comment\assets\CommentListAsset;

class CommentListWidget extends Widget
{
    public $title = '评论列表';
    public $dataProvider;
    public $layout = '{items}<div class="text-right">{pager}</div>';
    public $options = [
        'tag' => 'ul',
        'class' => 'media-list mt15 pl15',
    ];
    public $itemOptions = [
        'tag' => 'li',
        'class' => 'media'
    ];

    public $itemView;
    public $commentSwitch = true;

    public function init()
    {
        if ($this->dataProvider === null) {
            throw new InvalidConfigException("DataProvider不能为空");
        }

        if ($this->itemView === null) {
            $this->itemView = function ($model, $key, $index, $widget) {
                return $this->renderFile('@vendor/deluxcms/comment/widgets/views/comment.php', [
                    'model' => $model,
                    'commentSwitch' => $this->commentSwitch,
                ]);
            };
        }
    }

    public function run()
    {
        $listView = \yii\widgets\ListView::widget([
            'dataProvider' => $this->dataProvider,
            'layout' => $this->layout,
            'options' => $this->options,
            'itemOptions' => $this->itemOptions,
            'itemView' => $this->itemView,
        ]);

        $this->registerClientOptions();
        return $this->preJs() . $this->renderFile('@vendor/deluxcms/comment/widgets/views/commentList.php', [
            'listView' => $listView,
            'title' => $this->title,
        ]);
    }

    protected function registerClientOptions()
    {
        CommentListAsset::register(Yii::$app->view);
    }

    protected function preJs()
    {
        return '<script>var isGuest = "' . Yii::$app->user->isGuest . '"</script>';
    }
}