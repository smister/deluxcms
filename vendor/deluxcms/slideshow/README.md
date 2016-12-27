# deluxcms-slideshow
--------------------
deluxcms轮播图模块

安装
------------
可以通过composer安装
	
```
compser require deluxcms/deluxcms-media
```

配置
-------------
在配置文件中添加media模块
```php
	'modules' => [
        'slideshow' => [
            'class' => 'deluxcms\slideshow\Slideshow',
        ],
    ],
```