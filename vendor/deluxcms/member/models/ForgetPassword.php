<?php

namespace deluxcms\member\models;

use yii\base\Model;

class ForgetPassword extends Model
{
    public $email;
    public $verifyCode;
    public $password;
    public $repassword;
    public $_member;

    public function rules()
    {
        return [
            [['password', 'email'], 'required', 'message' => '不能为空'],
            ['email', 'email', 'message' => '邮箱的格式错误'],
            ['password', 'trim'],
            ['password', 'string', 'min' => 6, 'max' => 255, 'tooShort' => '密码的长度不能小于6位', 'tooLong' => '密码的长度不能大于255'],
            ['repassword', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false, 'message' => '两次密码不一致'],
            ['verifyCode', 'checkCode'],
        ];
    }

    public function checkCode($attribute, $params)
    {
        if (!$this->hasErrors() && !($member = Member::getMemberByValiableEmail($this->email)) && !Yii::$app->sms->validate($this->email, $this->$attribute)) {
            $this->addError($attribute, '验证码错误');
        } else {
            $this->_member = $member;
        }
    }

    public function updatePassword()
    {
        if (!$this->validate()) return false;
        $this->_member->setPassword($this->password);
        if (!$this->_member->save()) {
            $this->addError('email', '修改密码失败,失败信息：' . print_r($this->_member->getErrors(), true));
            return false;
        }
        return true;
    }


    public function attributeLabels()
    {
        return [
            'password' => '密码',
            'repassword' => '确认密码',
            'email' => '邮箱',
            'verifyCode' => '验证码',
        ];
    }
}