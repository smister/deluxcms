<?php

namespace deluxcms\media\assets;

use yii\web\AssetBundle;

class ModalAsset extends AssetBundle
{
    public $sourcePath = '@vendor/deluxcms/media/source';
    public $css = [
        'css/modal.css'
    ];

    public $js = [];

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}