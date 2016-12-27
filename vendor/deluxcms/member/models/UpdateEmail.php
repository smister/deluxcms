<?php

namespace deluxcms\member\models;

use deluxcms\member\models\Member;
use Yii;
use yii\base\Model;

class UpdateEmail extends Model
{
    const VERIFY_EMAIL_TOKEN = 'update_email';
    const SCENARIO_UPDATE = 'update_email';
    public $email;
    public $verifyCode;

    public function rules()
    {
        return [
            [['email', 'verifyCode'], 'required', 'message' => '不能为空'],
            ['email', 'email', 'message' => '邮箱的格式错误'],
            ['email', 'checkEmail', 'on' => [self::SCENARIO_UPDATE]],
            ['verifyCode', 'checkCode'],
        ];
    }

    public function checkCode($attribute, $params)
    {
        if (!$this->hasErrors() && !Yii::$app->sms->validate($this->getValidateEmail(), $this->$attribute)) {
            $this->addError($attribute, '验证码错误');
        }
    }

    public function checkEmail($attribute, $params)
    {
        if (Member::isValidateEmail($this->$attribute)) { //验证邮箱唯一
            return $this->addError('邮箱已经被使用');
        }
    }

    protected function getValidateEmail()
    {
        $member = Yii::$app->user->getIdentity();
        if ($member->email_validate && !self::hadEmailToken()) { //token没有生成
            return $member->email;
        } else {
            return $this->email;
        }
    }

    public function verifyEmail()
    {
        if (!$this->validate()) return false;
        //生成一个令牌，表示邮箱验证成功
        if (!$this->createEmailToken()) {
            $this->addError('email', '创建验证令牌失败');
            return false;
        }
        return true;
    }

    public function updateEmail()
    {
        if (!$this->validate()) return false;
        $member = Yii::$app->user->getIdentity();
        $member->setAttributes([
            'email' => $this->email,
            'email_validate' => 1,
        ]);

        if (!$member->save()) {
            $this->addError('email', '更新邮箱失败，失败信息：' . print_r($member->getErrors(), true));
            return false;
        }
        //清理令牌
        $this->removeEmailToken();
        return true;
    }


    protected function createEmailToken()
    {
        Yii::$app->session->set(self::VERIFY_EMAIL_TOKEN, true);
        return self::hadEmailToken();
    }

    public static function hadEmailToken()
    {
        return Yii::$app->session->has(self::VERIFY_EMAIL_TOKEN);
    }

    protected function removeEmailToken()
    {
          return Yii::$app->session->remove(self::VERIFY_EMAIL_TOKEN);
    }

    public function attributeLabels()
    {
        return [
            'email' => '邮箱',
            'verifyCode' => '验证码'
        ];
    }
}