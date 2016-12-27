<?php

namespace deluxcms\post\models;

use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Tag extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%post_tag}}';
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
            ['name', 'required', 'message' => '名称不能为空'],
            ['name', 'string', 'max' => '20', 'tooLong' => '名称长度不能大于20位']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'created_at' => '创建时间',
            'updated_at' => '更新时间'
        ];
    }

    public static function getAllTags()
    {
        return self::find()->select('id, name')->asArray()->all();
    }

    /**
     * 根据下标获取标签的class
    */
    public static function getTagClass($key)
    {
        $key = (int) $key;
        $tagClass = [
            'label-default',
            'label-primary',
            'label-success',
            'label-info',
            'label-warning',
            'label-danger',
        ];

        return $tagClass[$key % 6];
    }

    /**
     * 获取标签的dataProvider
    */
    public static function getTagDataProvider($limit = 15)
    {
        $query = self::find()->orderBy('id DESC')->limit($limit);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
        return $dataProvider;
    }
}