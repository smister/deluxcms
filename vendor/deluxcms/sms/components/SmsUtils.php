<?php

namespace deluxcms\sms\components;

use deluxcms\sms\models\Sms;
use Yii;
use yii\base\Component;
use yii\base\Exception;

class SmsUtils extends Component
{
    public $smsClass = 'deluxcms\sms\components\SmsEmail';

    /**
     * 发送验证码
    */
    public function send($deviceNum, $data = [], $type = 'normal', $numLength = 6, $reSendTime = 60, $expireTime = 300)
    {
        //用于防止用户多次发送验证码
        $key = 'sms_user_send_type_' . $type;
        $locked = Yii::$app->session->get($key);
        if ($locked && $locked > time()) {
            //存在或者未过期的验证，无法继续发送
            return ['status' => false, 'message' => '发送的次数过多'];
        }

        //生成我们的锁
        Yii::$app->session->set($key, time() + $reSendTime);

        try {
            //创建验证码
            $smsRet = Sms::createCode($deviceNum, $expireTime, $numLength);
            if (!$smsRet['status']) {
                throw new Exception($smsRet['message']);
            }

            //发送验证码
            $sendSts = call_user_func([$this->smsClass, 'send'], $deviceNum, $smsRet['code'], $data);
            if (!$sendSts) {
                throw new Exception('发送邮件失败');
            }

            return ['status' => true, 'message' => '发送成功'];
        } catch (Exception $e) {
            $this->releaseLock($type);
            return ['status' => false, 'message' => $e->getMessage()];
        }

    }

    /**
     * 检验验证码
    */
    public function validate($deviceNum, $code, $type = 'normal')
    {
        if (Sms::checkCode($deviceNum, $code)) {
            $this->releaseLock($type);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 释放锁
    */
    public function releaseLock($type)
    {
        Yii::$app->session->remove('sms_user_send_type_' . $type);
    }
}