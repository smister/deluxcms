<?php

namespace deluxcms\sms\components;

use Yii;

class SmsEmail implements SmsInterface
{
    public static function send($deviceNum, $code, $data = [])
    {
        $subject = isset($data['subject']) ? $data['subject'] : '验证码';
        $template = isset($data['template']) ? $data['template'] : '@vendor/deluxcms/sms/views/sms.php';
        $data['code'] = $code;
        return Yii::$app->mailer->compose($template, $data)
                          ->setSubject($subject)
                          ->setFrom(Yii::$app->mailer->getTransport()->getUsername())
                          ->setTo($deviceNum)
                          ->send();
    }
}