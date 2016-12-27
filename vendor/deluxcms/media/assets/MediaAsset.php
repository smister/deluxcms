<?php

namespace deluxcms\media\assets;

use yii\web\AssetBundle;

class MediaAsset extends AssetBundle
{
    public $sourcePath = '@vendor/deluxcms/media/source';
    public $css = [
        'css/media.css'
    ];

    public $js = [
        'js/media.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset'
    ];
}