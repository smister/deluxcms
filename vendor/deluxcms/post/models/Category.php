<?php

namespace deluxcms\post\models;

use Yii;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use common\behaviors\IntegerNullBehavior;
use yii\helpers\ArrayHelper;

class Category extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%post_category}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
             [
                'class' => IntegerNullBehavior::className(),
                'attributes' => [
                  ActiveRecord::EVENT_BEFORE_INSERT => 'order',
                  ActiveRecord::EVENT_BEFORE_UPDATE => 'order',
              ],
            ]
        ];
    }

    public function rules()
    {
        return [
            ['name', 'required', 'message' => '名称不能为空'],
            [['parent_id', 'order'], 'integer'],
            ['parent_id', 'checkPid'],
            [['name', 'slug'], 'string', 'max' => '50', 'tooLong' => '长度不能超过50位'],
            [['seo_title', 'seo_keywords'], 'string', 'max' => 100, 'tooLong' => '长度不能大于100位'],
            ['seo_description', 'string', 'max' => '255', 'tooLong' => '长度不能大于255位'],
            ['status', 'in', 'range' => [0, 1], 'message' => '非法操作'],
        ];
    }

    public function checkPid($attribute, $params)
    {
        if ($this->$attribute == $this->id) {
            $this->addError($attribute, '不能成为自身的分类');
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => '分类',
            'name' => '分类名称',
            'slug' => 'Url美化',
            'order' => '排序',
            'seo_title' => 'SEO-标题',
            'seo_keywords' => 'SEO-关键词',
            'seo_description' => 'SEO-描述',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 以id => name 的形式，获取所有分类
    */
    public static function getCategorysMap($status = '', $pad = '　', $default = [0 => '父类'])
    {
        if ($default) {
            $result = $default;
        } else {
            $result = [];
        }
        $categorys = self::getCategorys($status);
        foreach ($categorys as $category) {
            $result[$category['id']] = str_repeat($pad, $category['level']) . $category['name'];
        }
        return $result;
    }

    /**
     * 获取所有的分类，已排好顺
    */
    public static function getCategorys($status = '')
    {
        $categorys = self::find()->andFilterWhere(['status' => $status])->asArray()->all();
        return self::getChildCategorys($categorys);
    }

    public static function getChildCategorys(&$categorys, $parentId = 0, $level = 0)
    {
        $result = [];
        foreach ($categorys as $key => $category) {
            if ($category['parent_id'] == $parentId) {
                $result[] = [
                    'id' => $category['id'],
                    'name' => $category['name'],
                    'level' => $level
                ];
                unset($categorys[$key]);
                $result = ArrayHelper::merge($result, self::getChildCategorys($categorys, $category['id'], $level + 1));
            }
        }
        return $result;
    }

    public function delete()
    {
        $tran = Yii::$app->db->beginTransaction();
        try {
            if (!$this->deleteChild()) {
                throw new Exception("删除失败");
            }

            $tran->commit();
            return true;
        } catch (Exception $e) {
            $tran->rollBack();
            Yii::error($e->getMessage());
            return false;
        }
    }

    public function deleteChild()
    {
        $childCategorys = self::find()->where(['parent_id' => $this->id])->all();
        foreach ($childCategorys as $category) {
            if (!$category->deleteChild()) {
                return false;
            }
        }

        return parent::delete();
    }

    public function getCategoryName()
    {
        $categorys = self::getCategorysMap(1);
        return isset($categorys[$this->id]) ? $categorys[$this->id] : '无';
    }

    public static function getCategoryDataProvider()
    {
        $categorys = self::getCategorys(1);
        $models = [];
        foreach ($categorys as $cate) {
            $category = self::findOne($cate['id']);
            if ($category) {
                $models[] = $category;
            }
        }

        $dataProvider = new ActiveDataProvider();
        $dataProvider->models = $models;
        return $dataProvider;
    }
}