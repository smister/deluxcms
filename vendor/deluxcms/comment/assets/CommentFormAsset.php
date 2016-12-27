<?php

namespace deluxcms\comment\assets;

use yii\web\AssetBundle;

class CommentFormAsset extends AssetBundle
{
    public $sourcePath = '@vendor/deluxcms/comment/source';
    public $css = [];
    public $js = [
        'js/commentForm.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}