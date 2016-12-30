# deluxcms
------------------------------
deluxcms是主要是以模块化开发为主，将功能模块化，然后再进行组合使用，从而达到了快速独立开发， 在使用上可以按需安装自己需要的模块，无须像传统的所有功能都耦合在一起。 核心功能有后台用户， 网站设置， 用户设置。 外置模块分为图片管理， 帖子， RBAC 权限管理，API 登录，会员系统，轮播图等

安装
------------
目前为一个完整的包,直接通过git下载
	
```
git clone git连接 本地目录
```

配置
-------------
1) 将数据库导入到本地
2) 编辑common/config/main-local.php，配置数据库
```php
	'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yiicms', //host:主机名称，dbname:数据库名称
            'username' => 'root', //用户名
            'password' => '',     //密码
            'charset' => 'utf8',
            'tablePrefix' => 's_',  //表前缀
    ],
```
3) 编辑frontend和backend的config/main.php
```php
'modules' => [
        'media' => [
            'class' => 'deluxcms\media\Media',
			//前端访问图片的地址,更多了解https://github.com/smister/deluxcms-media
            'webUrl' => 'http://delux.com:8080/',  
        ],
],
```
4) 在frontend/config/main.php修改mailer跟authClientCollection
```php
'modules' => [
	'mailer' => [
		'class' => 'yii\swiftmailer\Mailer',
		'useFileTransport' => false, //直接发送，不存在runtime 中
		'transport' => [
			'class' => 'Swift_SmtpTransport',
			'host' => 'smtp服务器名称',
			'username' => '用户名',
			'password' => '密码',
			'port' => '25',
			'encryption' => 'tls',
		],
	],
	'authClientCollection' => [
		'class' => 'yii\authclient\Collection',
		'clients' => [//目前只支持微博和qq
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
],
```
5)权限控制在backend/controllers/BaseController.php
```php
	if (!Rbac::auth(Yii::$app->user->id, $action)) {
		throw new NotFoundHttpException("没有使用权限");
	}
```
6)访问demo
前台:http://www.deluxcms.com:81/
后台:http://b.deluxcms.com:81/
账号密码都是smister和123456

更多
-----------
相关赞助教程 http://www.smister.com/lesson/6.html
由于缺少充裕时间测试，deluxcms会不断更新，欢迎提出意见和BUG QQ群177193746
