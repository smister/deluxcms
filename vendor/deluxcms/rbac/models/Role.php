<?php

namespace deluxcms\rbac\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Role extends ActiveRecord
{
    const TYPE_ROLE = 1;
    public $nodes;
    protected $_oldName;

    public static function tableName()
    {
        return '{{%auth_item}}';
    }

    public function rules()
    {
        return [
            [['description', 'name'], 'required', 'message' => '不能为空'],
            ['name', 'checkName'],
            ['nodes', 'safe'],
        ];
    }

    public function checkName($attribute, $params)
    {
        $name = strtolower($this->name);
        if (!preg_match('/^[\w\-\_]{1,64}$/', $name)) {
            $this->addError($attribute, '标示符必须为64位内的字母，数字，-或_');
        } elseif ($this->name != $this->_oldName && Yii::$app->authManager->getRole($this->name)) {
            $this->addError($attribute, '该标示符已经被使用');
        }
    }

    public function attributeLabels()
    {
        return [
            'description' => '名称',
            'name' => '标示符',
        ];
    }

    public static function find()
    {
        return parent::find()->andWhere(['type' => self::TYPE_ROLE]);
    }

    public static function findOne($condition)
    {
        if (!is_array($condition)) {
            $condition = ['name' => $condition];
        }
        return parent::findOne(array_merge($condition, ['type' => self::TYPE_ROLE]));
    }

    public function afterFind()
    {
        $this->setNodes();
        $this->setOldName();
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->name = strtolower($this->name);
        }
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && !$this->validate()) return false;
        $tran = Yii::$app->db->beginTransaction();
        try {
            if ($this->isNewRecord) {
                $this->add();
            } else {
                $this->edit();
            }
            $tran->commit();
            return true;
        } catch (Exception $e) {
            $tran->rollBack();
            $this->addError('description', $e->getMessage());
            return false;
        }
    }

    protected function add()
    {
        $auth = Yii::$app->authManager;
        $role = $auth->createRole($this->name);
        $role->description = $this->description;
        $auth->add($role);
        //处理节点
        $this->addNodes($role);
    }

    protected function edit()
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($this->_oldName);
        $role->name = $this->name;
        $role->description = $this->description;
        $auth->update($this->_oldName, $role);
        //先移除老的权限节点，然后再添加
        $auth->removeChildren($role);
        $this->addNodes($role);
    }

    /**
     * 给角色赋予权限节点
    */
    protected function addNodes($role)
    {
        if (is_array($this->nodes)) {
            $auth = Yii::$app->authManager;
            foreach ($this->nodes as $nodeName) {
                $permission = $auth->getPermission($nodeName);
                if ($permission) {
                    $auth->addChild($role, $permission);
                }
            }
        }
    }

    protected function setNodes()
    {
        $this->nodes = ArrayHelper::getColumn(Yii::$app->authManager->getPermissionsByRole($this->name), 'name');
    }

    protected function setOldName()
    {
        $this->_oldName = $this->name;
    }

    /**
     * 删除角色
    */
    public function delete()
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($this->name);
        if ($role) {
            $auth->remove($role);
        }
        return true;
    }

    /**
     * 获取所有角色
    */
    public static function getRoles()
    {
        return ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
    }

    /**
     * 更新用户角色
    */
    public static function updateUserRole($userId, $roles)
    {
        $auth = Yii::$app->authManager;

        $tran = Yii::$app->db->beginTransaction();
        try {
            //清理用户之前所有的角色
            $auth->revokeAll($userId);
            foreach ($roles as $roleName) {
                $role = $auth->getRole($roleName);
                if ($role) {
                    $auth->assign($role, $userId);
                }
            }
            $tran->commit();
            return true;
        } catch (Exception $e) {
            $tran->rollBack();
            Yii::error($e->getMessage());
            return false;
        }
    }

    /**
     * 根据用户id获取角色
    */
    public static function getRolesByUserId($userId)
    {
        return ArrayHelper::getColumn(Yii::$app->authManager->getRolesByUser($userId), 'name');
    }
}