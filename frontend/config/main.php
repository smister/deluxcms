<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'media' => [
            'class' => 'deluxcms\media\Media',
            'webUrl' => 'http://delux.com:8080/',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'deluxcms\member\models\Member',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false, //直接发送，不存在 runtime 中
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.sina.com',
                'username' => 'yuekemall@sina.cn',
                'password' => 'qwer123456',
                'port' => '25',
                'encryption' => 'tls',
            ],
        ],
        'sms' => [
            'class' => 'deluxcms\sms\components\SmsUtils',
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'weibo' => [
                    'class' => 'deluxcms\authclient\clients\Weibo',
                    'clientId' => 'weibo_client_id',
                    'clientSecret' => 'weibo_client_secret',
                ],
                'qq' => [
                    'class' => 'deluxcms\authclient\clients\Qq',
                    'clientId' => 'qq_client_id',
                    'clientSecret' => 'qq_client_secret',
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix' => '.html',
            'rules' => [
                '<controller:post>/<id:\d+>/<slug:[\w\-]+>' => '<controller>/index',
                '<controller:post>/<id:\d+>' => '<controller>/index',
                'index' => 'site/index',
                '<controller:post>-<action:list>-<cid:\d+>' => '<controller>/<action>',
                '<controller:post>-<action:list>' => '<controller>/<action>',
                '<controller:tag>/<tagName:.+>' => '<controller>',
                '<controller:tag>/<tagName:.+>' => '<controller>/index',
                '<action:register|login|forget-password>' => 'member/<action>',
            ],
        ],
    ],
    'params' => $params,
];
