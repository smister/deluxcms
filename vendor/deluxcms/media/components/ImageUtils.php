<?php

namespace deluxcms\media\components;

use Imagine\Image\Box;
use Imagine\Image\Point;
use Yii;
use Imagine\Image\ImageInterface;
use yii\imagine\Image;

class ImageUtils
{
    public static function thumbnail($image, $width = 100, $height = 100, $noImage = '', $mode = ImageInterface::THUMBNAIL_INSET)
    {
        if (!empty($image)) {
            $webRoot = Yii::$app->getModule('media')->getWebRoot();
            if (strpos($image, 'http://') === 0 || strpos($image, 'https://') === 0) {
                //例如http://www.smister.com/mrs.jpg
                return $image;
            } elseif (file_exists($image) || file_exists($webRoot . $image)) {
                $webUrl = Yii::$app->getModule('media')->getWebUrl();

                //我们文件的物理路径
                $image = file_exists($image) ? $image : $webRoot . $image;
                //获取文件信息
                $fileInfo = pathinfo($image);

                //上传缩略图的相对路径
                $thumbnailDir = Yii::$app->getModule('media')->getThumbnailDir();
                if (!is_dir($webRoot . $thumbnailDir)) {
                    @mkdir($webRoot . $thumbnailDir, 0777, true);
                }

                $thumbnailFile = $fileInfo['filename'] . "-{$width}x{$height}." . $fileInfo['extension'];
                if (!file_exists($webRoot . $thumbnailDir . $thumbnailFile)) {
                    //如果不存在缩略图，就生成
                    //缩略图， 当原始图片小于我们缩略图的大小时，就返回自身了
                    //Image::thumbnail($image, $width, $height, $mode)->save($webRoot . $thumbnailDir . $thumbnailFile);
                    $thunbnailImage = Image::thumbnail($image, $width, $height, $mode);
                    if ($thunbnailImage->getSize()->getWidth() < $width || $thunbnailImage->getSize()->getHeight() < $height) {
                        $startX = ($width - $thunbnailImage->getSize()->getWidth()) / 2;
                        $startY = ($height - $thunbnailImage->getSize()->getHeight()) / 2;
                        $thunbnailImage = Image::getImagine()->create(new Box($width, $height))->paste($thunbnailImage, new Point($startX, $startY));
                    }
                    $thunbnailImage->save($webRoot . $thumbnailDir . $thumbnailFile);
                }

                return $webUrl . $thumbnailDir . $thumbnailFile;
            }
        }

        return self::getNoImage($noImage, $width, $height);
    }

    public static function getNoImage($image = '', $width = 100, $height = 100, $mode = ImageInterface::THUMBNAIL_INSET)
    {
        $noImage = Yii::getAlias(empty($image) ? Yii::$app->getModule('media')->getNoImage() : $image);
        return self::thumbnail($noImage, $width, $height, $mode);
    }

}