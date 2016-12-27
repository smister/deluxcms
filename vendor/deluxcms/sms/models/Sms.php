<?php

namespace deluxcms\sms\models;

use Yii;
use yii\db\ActiveRecord;

class Sms extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%sms_send_log}}';
    }

    public function rules()
    {
        return [
            [['device_num', 'number'], 'required', 'message' => '不能为空'],
            ['device_num', 'string', 'max' => 100, 'tooLong' => '长度不能大于100位'],
            ['number', 'string', 'max' => 10, 'tooLong' => '验证码长度不能大于10位'],
            [['created_at', 'expire_time'], 'integer'],
            ['is_validate', 'in', 'range' => [0, 1], 'message' => '非法操作']
        ];
    }

    public static function createCode($deviceNum, $expireTime, $numLength = 6)
    {
        $sms = new self();
        $sms->setAttributes([
            'device_num' =>$deviceNum,
            'expire_time' => $expireTime,
            'number' => (string) self::createRandCode($numLength),
            'created_at' => time(),
        ]);

        if (!$sms->save()) {
            return ['status' => false, 'message' => '生成验证码错误,错误信息：' . print_r($sms->getErrors(), true)];
        }

        return ['status' => true, 'code' => $sms->number];
    }

    /**
     * 验证手机验证码
    */
    public static function checkCode($deviceNum, $code)
    {
        $smsCode = self::find()->where(['device_num' => $deviceNum])->orderBy('id DESC')->one();
        if ($smsCode && ($smsCode->created_at + $smsCode->expire_time >= time()) && $smsCode->is_validate == 0 && $smsCode->number == $code) {
            $smsCode->is_validate = 1;
            if (!$smsCode->save()) {
                Yii::error("更新验证码验证状态失败，失败信息" . print_r($smsCode->getErrors(), true));
                return false;
            }
            return true;
        }
        return false;
    }

    public static function createRandCode($numLength)
    {
        return mt_rand('1' . str_repeat('0', $numLength - 1), str_repeat('9', $numLength));
    }
}