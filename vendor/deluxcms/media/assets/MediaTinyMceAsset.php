<?php

namespace deluxcms\media\assets;

use yii\web\AssetBundle;

class MediaTinyMceAsset extends AssetBundle
{
    public $sourcePath = '@vendor/deluxcms/media/source';
    public $css = [];

    public $js = [
        'js/mediatinymce.js'
    ];

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}