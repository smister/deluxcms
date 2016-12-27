<?php

namespace backend\assets;

use yii\web\AssetBundle;

class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/login.css'
    ];

    public $js = [

    ];

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}