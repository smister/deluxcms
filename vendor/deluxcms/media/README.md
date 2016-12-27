# deluxcms-media for deluxcms
------------------------------
deluxcms-media是deluxcms中一个多媒体模块，主要是图片管理

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
        'media' => [
            'class' => 'deluxcms\media\Media',
            'webUrl' => 'http://delux.com:8080/', //*必须配置, 提供访问的域名
			'useController' => true, //使用时候控制器，一般后台管理时才开启
			//'webRoot' => '@frontend/web',  //保存的相对地址
			//'allowTypes' => ['image/gif', 'image/jpeg', 'image/png'], //允许的上传类型
			//'uploadDir' => 'uploads', //保存图片的文件夹 , 都是相对于webRoot
			//'thumbnailDir' => 'thumbnails', //缩略图的文件夹 , 都是相对于webRoot
			//'noImage' => '@vendor/deluxcms/media/source/images/no_picture.png', //找不到图片时显示的
        ],
    ],
```

使用
-------------
利用ImageUtils生成缩略图，获取没有图片
```php
	/**
	 * 获取图片缩略图
	 * @param string $image 图片地址
	 * @param int $width 缩略图的宽度
	 * @param int $height 缩略图的高度
	 * @param string $noImage 找不到图片时展示的图片
	 * @param string  $mode 裁剪还是填充，默认是填充
	*/
	\deluxcms\media\components\ImageUtils::thumbnail($image, $width = 100, $height = 100, $noImage = '', $mode = ImageInterface::THUMBNAIL_INSET)
	
	
	/**
	 * 读取默认图片(找不到图片 )
	 * @param string $image 图片地址
	 * @param int $width 缩略图的宽度
	 * @param int $height 缩略图的高度
	 * @param string  $mode 裁剪还是填充，默认是填充
	*/
	\deluxcms\media\components\ImageUtils::getNoImage($image = '', $width = 100, $height = 100, $mode = ImageInterface::THUMBNAIL_INSET)
```