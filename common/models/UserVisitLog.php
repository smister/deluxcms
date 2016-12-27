<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\components\Browser;

class UserVisitLog extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%user_visit_log}}';
    }

    public function rules()
    {
        return [
            [['ip', 'user_agent', 'browser', 'os'], 'string'],
            [['user_id', 'visit_time'], 'integer'],
        ];
    }

    public static function addUserVisitLog($userId)
    {
        $user = User::findOne($userId);
        if (!$user) return false;
        $browser = new Browser();
        $log = new self();
        $log->setAttributes([
            'ip' => Yii::$app->request->getUserIP(),
            'user_agent' => $browser->getUserAgent(),
            'browser' => $browser->getBrowser(),
            'os' => $browser->getPlatform(),
            'user_id' => $userId,
            'visit_time' => time(),
        ]);

        return $log->save();
    }
    public function attributeLabels()
    {
        return [
            'ip' => '登录 ip',
            'user_agent' => '用户代理',
            'browser' => '浏览器',
            'os' => '操作系统',
            'user_id' => '用户',
            'visit_time' => '登陆时间',
        ];
    }

    //uservisitlog --> user   1 => user
    // user --> uservisitlog
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}