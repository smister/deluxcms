<?php

namespace deluxcms\media\assets;

use yii\web\AssetBundle;

class TinyMceAsset extends AssetBundle
{
    public $sourcePath = '@vendor/tinymce/tinymce';
    public $js = [
        'tinymce.jquery.js'
    ];
    public $css = [];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}