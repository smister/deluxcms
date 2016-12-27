<?php

namespace deluxcms\comment\widgets;

use Yii;
use deluxcms\comment\assets\CommentFormAsset;
use yii\base\InvalidConfigException;
use yii\base\Widget;

class CommentFormWidget extends Widget
{
    public $title = '发表评论';
    public $postId;
    public $captchaAction = '/site/captcha';
    public $action = ['/post/comment'];

    public function init()
    {
        parent::init();
        if ($this->postId === null) {
            throw new InvalidConfigException("PostId 不能为空");
        }
    }

    public function run()
    {
        $this->registerClientOptions();

        return $this->renderFile('@vendor/deluxcms/comment/widgets/views/commentForm.php', [
            'title' => $this->title,
            'postId' => $this->postId,
            'captchaAction' => $this->captchaAction,
            'action' => $this->action,
        ]);
    }

    protected function registerClientOptions()
    {
        CommentFormAsset::register(Yii::$app->view);
    }
}