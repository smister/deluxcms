<?php

namespace deluxcms\menu\assets;

use yii\web\AssetBundle;

class MenuAsset extends AssetBundle
{
    public $sourcePath = '@vendor/deluxcms/menu/source';
    public $css = [
        'css/menu.css',
    ];
    public $js = [
        'js/menu.js'
    ];

    public $depends = [
        'yii\jui\JuiAsset'
    ];
}