<?php

namespace deluxcms\slideshow\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use common\behaviors\IntegerNullBehavior;

class Slideshow extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%slideshow}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => IntegerNullBehavior::className(),
                'attributes' => [
                  ActiveRecord::EVENT_BEFORE_INSERT => 'order',
                  ActiveRecord::EVENT_BEFORE_UPDATE => 'order',
              ],
            ]
        ];
    }

    public function rules()
    {
        return [
            [['title', 'image'], 'required', 'message' => '不能为空'],
            [['image', 'link', 'description'], 'string', 'max' => 255, 'tooLong' => '长度不能大于 255位'],
            ['title', 'string', 'max' => 100, 'message' => '标题的长度不能大于100位'],
            ['order', 'integer', 'message' => '排序必须为整数'],
            ['status', 'in', 'range' => [0, 1]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'image' => '图片',
            'description' => '简介',
            'link' => '链接',
            'order' => '排序',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    public static function getSlideshows($limit = 3)
    {
        return self::find()->where(['status' => 1])->orderBy('order DESC,id DESC')->limit($limit)->all();
    }
}