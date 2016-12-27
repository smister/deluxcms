<?php
namespace deluxcms\auth\models;

class Member extends \deluxcms\member\models\Member
{
    public function rules()
    {
        return [
            [['username', 'nickname'], 'required', 'message' => '不能为空'],
            ['username', 'match', 'pattern' => '/^[\w]{1,255}$/', 'message' => '用户名只能为1~255的字母或数字'],
            ['username', 'unique', 'message' => '用户名已经被使用'],
            ['sex', 'in', 'range' => [0, 1], 'message' => '选项不合法'],
            ['nickname', 'string', 'max' => 50, 'message' => '昵称的长度不能大于50位'],
            [['address', 'avatar'], 'string', 'max' => 255, 'message' => '昵称的长度不能大于255位'],
            ['registration_ip', 'string', 'max' => 15, 'message' => '昵称的长度不能大于15位'],
            ['password', 'safe'],
        ];
    }
}