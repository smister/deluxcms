<?php

namespace deluxcms\authclient\assets;

use yii\web\AssetBundle;

class AuthClientAsset extends AssetBundle
{
    public $sourcePath = '@vendor/deluxcms/authclient/source';

    public $css = [
        'css/authclient.css',
    ];
}