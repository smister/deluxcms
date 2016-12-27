<?php
namespace deluxcms\member\models;

use Yii;
use yii\base\Model;
use yii\widgets\ActiveForm;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = false;
    public $verifyCode;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required', 'message' => '账号或密码不能为空'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['verifyCode', 'captcha', 'captchaAction' => 'member/captcha', 'message' => '验证码错误'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '账号或密码错误');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            if (Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0)) {
                MemberVisitLog::addUserVisitLog($this->_user->id);
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    /**
     * 通过ajax登录
    */
    public function loginByAjax()
    {
        $errors = ActiveForm::validate($this);
        if (empty($errors) && Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0)) {
            MemberVisitLog::addUserVisitLog($this->_user->id);
        }
        return $errors;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = Member::findByUsername($this->username);
        }

        return $this->_user;
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
            'rememberMe' => ' 保持登录状态',
            'verifyCode' => '验证码',
        ];
    }
}
