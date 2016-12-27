<?php

namespace deluxcms\post\assets;

use yii\web\AssetBundle;

class MagicsuggestAsset extends AssetBundle
{
    public $sourcePath = '@vendor/nicolasbize/magicsuggest';

    public $css = [
        'magicsuggest-min.css'
    ];

    public $js = [
        'magicsuggest-min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}