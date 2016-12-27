<?php

namespace deluxcms\auth\models;

use yii;
use yii\db\ActiveRecord;
use yii\base\Exception;

class Auth extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%auth}}';
    }

    public function rules()
    {
        return [
            [['member_id', 'source_id'], 'required', 'message' => '不能为空'],
            [['source', 'source_id'], 'string', 'max' => 50, 'tooLong' => '长度不能大于50位'],
        ];
    }

    public static function getAuthUser($client)
    {
        $auth = self::find()->where(['source' => $client->getId(), 'source_id' => $client->getOpenId()])->one();
        if (!$auth) {
            //不存在，保存我们的数据
            $tran = Yii::$app->db->beginTransaction();
            try {
                //先创建会员
                $member = new Member();
                $member->setAttributes([
                    'username' => $client->getUsername(),
                    'nickname' => $client->getNickname(),
                    'sex' => $client->getGender(),
                    'address' => $client->getAddress(),
                    'avatar' => $client->getAvatar(),
                    'password' => Yii::$app->security->generateRandomString(6),
                    'registration_ip' => Yii::$app->request->getUserIP(),
                ]);

                if (!$member->save()) {
                    throw new Exception("添加会员错误，错误信息: " . print_r($member->getErrors(), true));
                }

                //后保存我们的auth
                $auth = new self();
                $auth->setAttributes([
                    'member_id' => $member->id,
                    'source' => $client->getId(), //weibo, qq
                    'source_id' => (string) $client->getOpenId(),
                ]);

                if (!$auth->save()) {
                    throw new Exception("添加会员Auth错误，错误信息: " . print_r($auth->getErrors(), true));
                }

                $tran->commit();
                return $auth;
            } catch (Exception $e) {
                $tran->rollBack();
                Yii::error($e->getMessage());
                return false;
            }
        }

        return $auth;
    }


    public function getMember()
    {
        return $this->hasOne(Member::className(), ['id' => 'member_id']);
    }


    public function attributeLabels()
    {
        return [
            'member_id' => '昵称',
            'source' => '来源',
            'source_id' => '唯一标示符',
        ];
    }
}