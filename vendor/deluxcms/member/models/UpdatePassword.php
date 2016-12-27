<?php

namespace deluxcms\member\models;

use Yii;
use yii\base\Model;

class UpdatePassword extends Model
{
    public $oldpassword;
    public $password;
    public $repassword;

    public function rules()
    {
        return [
            [['password', 'oldpassword'], 'required', 'message' => '不能为空'],
            ['password', 'trim'],
            ['password', 'string', 'min' => 6, 'max' => 255, 'tooShort' => '密码的长度不能小于6位', 'tooLong' => '密码的长度不能大于255'],
            ['repassword', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false, 'message' => '两次密码不一致'],
            ['oldpassword', 'checkPassword'],
        ];
    }

    public function checkPassword($attribute, $params)
    {
        //Yii::$app->user->getIdentity() //获取到用户信息
        if (!$this->hasErrors() && !Yii::$app->security->validatePassword($this->oldpassword, Yii::$app->user->getIdentity()->password_hash)) {
            $this->addError($attribute, '密码错误');
        }
    }

    public function updatePassword()
    {
        if (!$this->validate()) return false;
        $member = Yii::$app->user->getIdentity();
        $member->setPassword($this->password);
        if (!$member->save()) {
            $this->addError('oldpassword', '修改密码失败，失败信息：' . print_r($member->getErrors(), true));
            return false;
        }

        return true;
    }

    public function attributeLabels()
    {
        return [
            'password' => '密码',
            'repassword' => '确认密码',
            'oldpassword' => '旧密码',
        ];
    }
}