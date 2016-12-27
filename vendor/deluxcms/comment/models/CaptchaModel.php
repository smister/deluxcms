<?php

namespace deluxcms\comment\models;

use yii\base\Model;

class CaptchaModel extends Model
{
    public $verifyCode;

    public function rules()
    {
        return [
            ['verifyCode', 'required', 'message' => '验证码不能为空'],
            ['verifyCode', 'captcha', 'captchaAction' => '/site/captcha', 'message' => '验证码错误'],
        ];
    }
}