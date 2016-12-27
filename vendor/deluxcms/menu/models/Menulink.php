<?php

namespace deluxcms\menu\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Menulink extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%menu_link}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function rules()
    {
        return [
            ['label', 'required', 'message' => '名称不能为空'],
            ['label', 'string', 'max' => 32, 'tooLong' => '名称不能大于32位'],
            ['link', 'string', 'max' => 255, 'tooLong' => '链接地址不能大于255位'],
            ['image', 'string', 'max' => 24, 'tooLong' => '图片地址不能大于24位'],
            ['menu_id', 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_id' => '关联菜单栏',
            'label' => '名称',
            'link' => '链接地址',
            'image' => '图片链接地址'
        ];
    }

    public function saveOrders($settings)
    {
        if (!is_array($settings) || empty($settings)) {
            return false;
        }

        //要不然我们要批量更新我们的数据
        // update s_menu_link mk INNER JOIN (select 1 as `id`, 2 as `order`, 0 as `parent_id`
        // UNION select 2 as `id`, 1 as `order`, 0 as `parent_id`) tmk ON mk.id=tmk.id
        // SET mk.`order` = tmk.`order`, mk.`parent_id` = tmk.`parent_id`

        $n = 1;
        $selects = [];
        $params = [];

        foreach ($settings as $setting) {
            if (isset($setting[0]) && isset($setting[1])) {
                //父类有可能不存在，所以我们不需要判断
                $selects[] = "SELECT :id_{$n} as `id`, :order_{$n} as `order`, :parent_id_{$n} as `parent_id`";
                $params[":id_{$n}"] = $setting[0];
                $params[":order_{$n}"] = $setting[1];
                $params[":parent_id_{$n}"] = isset($setting[2]) ? $setting[2] : 0;
                $n++;
            }
        }

        if (!empty($selects)) {
            $sql = "UPDATE " . self::tableName() . " mk INNER JOIN (" . implode(' UNION ', $selects) . ") tmk ON mk.id=tmk.id
                    SET mk.`order` = tmk.`order`, mk.`parent_id` = tmk.`parent_id`";

            return Yii::$app->db->createCommand($sql)->bindValues($params)->execute();
        }

        return false;
    }
}