<?php

namespace backend\assets;

use yii\web\AssetBundle;

class MetisMenuAsset extends AssetBundle
{
    public $sourcePath = '@vendor/onokumus/metismenu/dist';

    public $css = [
        'metisMenu.css'
    ];

    public $js = [
        'metisMenu.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];

}