<?php

namespace deluxcms\sms\assets;

use yii\web\AssetBundle;

class SmsAsset extends AssetBundle
{
    public $sourcePath = '@vendor/deluxcms/sms/source';

    public $js = [
        'js/sms.js'
    ];

    public $css = [
        'css/sms.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}