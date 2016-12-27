<?php

namespace deluxcms\media\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use yii\helpers\Url;
use deluxcms\media\components\ImageUtils;

class Media extends ActiveRecord
{
    public $file;

    public static function tableName()
    {
        return '{{%media}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [['filename', 'url'], 'string', 'max' => 255, 'tooLong' => '长度不能大于255'],
            ['type', 'string', 'max' => 127, 'tooLong' => '长度不能大于127'],
            ['size', 'integer'],
            ['file', 'file'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'filename' => '文件名称',
            'created_at' => '上传时间',
        ];
    }

    public function upload()
    {
        //上传物理目录
        //frontend/web
        $webRoot = Yii::$app->getModule('media')->getWebRoot();
        if (!is_dir($webRoot)) {
            throw new Exception("找不上传目录");
        }

        //上传的相对路径
        $absDir = Yii::$app->getModule('media')->getUploadDir() . date('/Y/m/d/');
        if (!is_dir($webRoot . $absDir)) {
            //mkdir默认只能创建一个目录
            @mkdir($webRoot . $absDir, 0777, true);
        }

        //文件的名称
        $file = UploadedFile::getInstance($this, 'file');

        $allowTypes = Yii::$app->getModule('media')->getAllowTypes();
        if (!in_array($file->type, $allowTypes)) {
            throw new Exception("上传图片格式错误");
        }

        $imageName = date('YmdHis') . rand(10000, 99999) . '.' . $file->extension;

        //保存
        if (!$file->saveAs($webRoot . $absDir . $imageName)) {
            throw new Exception("上传文件失败");
        }

        $this->setAttributes([
            'filename' => $file->name,
            'url' => $absDir . $imageName,
            'type' => $file->type,
            'size' => $file->size
        ]);

        if (!$this->save()) {
            @unlink($webRoot . $absDir . $imageName);
            throw new Exception("保存上传文件出错,错误信息" . print_r($this->getErrors(), true));
        }

        return true;
    }

    public function getUploadFile()
    {
        $webUrl = Yii::$app->getModule('media')->getWebUrl();
        return [
            'files' => [[
                'name' => $this->filename,
                'size' => $this->size,
                "url" => $webUrl . $this->url, //访问的web路径
                "thumbnailUrl" => ImageUtils::thumbnail($this->url), //缩略图的路径
                "deleteUrl" => Url::to(['/media/manage/delete', 'id' => $this->id]),
                "deleteType" => "POST"
            ]]
        ];
    }

    public function deleteFile()
    {
        $webRoot = Yii::$app->getModule('media')->getWebRoot();
        if (file_exists($webRoot . $this->url)) {
            unlink($webRoot . $this->url);
        }
        return true;
    }

    public function getOriginaUrl()
    {
        return Yii::$app->getModule('media')->getWebUrl() . $this->url;
    }
}