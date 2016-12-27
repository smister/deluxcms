<?php

namespace common\models;

use yii\db\ActiveRecord;

class Setting extends ActiveRecord
{
    const SETTING_ID = 1;

    public static function  tableName()
    {
        return '{{%setting}}';
    }

    public function rules()
    {
        return [
            [['title', 'name'], 'required', 'message' => '不能为空'],
            [['title', 'name'], 'string', 'max' => 100, 'tooLong' => '长度不能大于100'],
            [['logo', 'keyword', 'description', 'email'], 'string', 'max' => 255, 'tooLong' => '长度不能大于255'],
            [['backend_menu_id', 'frontend_menu_id'], 'integer'],
            ['copyright', 'string', 'max' => 1000, 'tooLong' => '版权所有的长度不能大于100位'],
            ['about_us', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => '网站名称',
            'title' => '网站标题',
            'logo' => 'LOGO',
            'keyword' => '网站关键词(多个以,分割)',
            'description' => '网站描述',
            'email' => '邮箱',
            'backend_menu_id' => '后台菜单栏',
            'frontend_menu_id' => '前台菜单栏',
            'about_us' => '关于我们',
            'copyright' => '版权所有',
        ];
    }

    public static function getBackendMenuId()
    {
        return self::findOne(Setting::SETTING_ID)->backend_menu_id;
    }

    public static function getSetting()
    {
        return self::find()->where(['id' => self::SETTING_ID])->asArray()->one();
    }
}