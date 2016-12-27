<?php

namespace deluxcms\rbac\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Node extends ActiveRecord
{
    protected $_isNewRecord;

    public static function tableName()
    {
        return '{{%auth_item_menu}}';
    }

    public function rules()
    {
        return [
            [['nickname', 'name'], 'required', 'message' => '不能为空'],
            ['nickname', 'string', 'max' => 20, 'tooLong' => '长度不能大于20位'],
            ['parent_id', 'checkPid'],
            ['name', 'checkName']
        ];
    }

    public function checkPid($attribute, $params)
    {
        if (!is_numeric($this->$attribute)) {
            $this->addError($attribute, '非法操作');
        } elseif ($this->parent_id == $this->id) {
            $this->addError($attribute, '不能成为自身的子类');
        } elseif ($this->parent_id > 0 && self::find()->where(['parent_id' => $this->id])->count() > 0) {
            //0 --> 子类，我们父类下的子类，如果有这种情况，我们不给修改
            $this->addError($attribute, '该父类下有子类，请先移除');
        }
    }

    public function checkName($attribute, $params)
    {
        //name都以小写处理
        $name = strtolower($this->$attribute);
        if (!preg_match('/^[\w\_]{1,64}$/', $name)) {
            $this->addError($attribute, '唯一标示必须是英文，数字或_');
        } elseif (self::find()->where(['name' => $name])->andFilterWhere(['!=', 'id', $this->id])->exists()) {
            $this->addError($attribute, '该标示符已经被使用');
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->name = strtolower($this->name);
            $this->_isNewRecord = $this->isNewRecord;
            return true;
        }
        return false;
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && !$this->validate())  return false;
        $tran = Yii::$app->db->beginTransaction();
        try {
            if (!parent::save(false, $attributeNames)) {
                throw new Exception("添加失败");
            }

            $tran->commit();
            return true;
        }catch (Exception $e) {
            $tran->rollBack();
            $this->addError('nickname', $e->getMessage());
            return false;
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        $auth = Yii::$app->authManager;
        if (!$this->_isNewRecord) {
            //如果是修改
            //1、我们父类改成子类，需要添加一个权限节点
            //2、我们的子类改成父类，移除一个权限节点
            //3、我们的子类修改了名称，我们也需要同步修改名称
            if (isset($changedAttributes['parent_id']) && $changedAttributes['parent_id'] == 0 && $this->parent_id > 0) {
                $permission = $auth->createPermission($this->name);
                $auth->add($permission);
            } elseif (isset($changedAttributes['parent_id']) && $changedAttributes['parent_id'] > 0 && $this->parent_id == 0) {
                $name = isset($changedAttributes['name']) ? $changedAttributes['name'] : $this->name;
                $permission = $auth->getPermission($name);
                if ($permission) $auth->remove($permission);
            } elseif ($this->parent_id > 0) {
                $name = isset($changedAttributes['name']) ? $changedAttributes['name'] : $this->name;
                $permission = $auth->getPermission($name);
                $permission->name = $this->name;
                $auth->update($name, $permission);
            }
        } elseif ($this->parent_id > 0) {
            //如果是新添加的，并且的parent_id大于0，需要添加一个权限节点
            $permission = $auth->createPermission($this->name);
            $auth->add($permission);
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nickname' => '昵称',
            'parent_id' => '父类',
            'name' => '标示',
        ];
    }

    /**
     * 读取父类
    */
    public static function getParentNodes()
    {
        $nodes = ArrayHelper::map(self::find()->where(['parent_id' => 0])->asArray()->all(), 'id', 'nickname');
        return ArrayHelper::merge([0 => '父类'], $nodes);
    }

    public function delete()
    {
        $tran = Yii::$app->db->beginTransaction();
        try {
            if (!parent::delete()) {
                throw new Exception("删除失败");
            }

            $auth = Yii::$app->authManager;
            if ($this->parent_id > 0) { //需要移除
                $permission = $auth->getPermission($this->name);
                $auth->remove($permission);
            } else {
                $childNodes = self::find()->where(['parent_id' => $this->id])->all();
                foreach ($childNodes as $childNode) {
                    $childNode->delete();
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

    public static function getNodes()
    {
        //0 -> 1
        $nodes = self::find()->orderBy('parent_id ASC')->asArray()->all();
        $result = [];
        foreach ($nodes as $node) {
            if ($node['parent_id'] == 0) {
                $result[$node['id']] = [
                    'nickname' => $node['nickname'],
                    'nodes' => [],
                ];
            } elseif (isset($result[$node['parent_id']])) {
                $result[$node['parent_id']]['nodes'][$node['name']] = $node['nickname'];
            }
        }

        return $result;
    }
}