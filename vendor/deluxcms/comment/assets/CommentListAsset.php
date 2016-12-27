<?php

namespace deluxcms\comment\assets;

use yii\web\AssetBundle;

class CommentListAsset extends AssetBundle
{
    public $sourcePath = '@vendor/deluxcms/comment/source';
    public $css = [];
    public $js = [
        'js/commentList.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}