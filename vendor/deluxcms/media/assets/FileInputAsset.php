<?php

namespace deluxcms\media\assets;

use yii\web\AssetBundle;

class FileInputAsset extends AssetBundle
{
    public $sourcePath = '@vendor/deluxcms/media/source';
    public $css = [];

    public $js = [
        'js/fileinput.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}