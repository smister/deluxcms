<?php

namespace deluxcms\member\models;

use Yii;
use yii\db\ActiveRecord;
use common\components\Browser;

class MemberVisitLog extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%member_visit_log}}';
    }

    public function rules()
    {
        return [
            [['ip', 'user_agent', 'browser', 'os'], 'string'],
            [['member_id', 'visit_time'], 'integer'],
        ];
    }

    public static function addUserVisitLog($memberId)
    {
        $member = Member::findOne($memberId);
        if (!$member) return false;
        $browser = new Browser();
        $log = new self();
        $log->setAttributes([
            'ip' => Yii::$app->request->getUserIP(),
            'user_agent' => $browser->getUserAgent(),
            'browser' => $browser->getBrowser(),
            'os' => $browser->getPlatform(),
            'member_id' => $memberId,
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
            'member_id' => '会员',
            'visit_time' => '登陆时间',
        ];
    }

    //uservisitlog --> user   1 => user
    // user --> uservisitlog
    public function getMember()
    {
        return $this->hasOne(Member::className(), ['id' => 'member_id']);
    }
}