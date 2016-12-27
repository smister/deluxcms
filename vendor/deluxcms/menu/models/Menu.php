<?php

namespace deluxcms\menu\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

class Menu extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%menu}}';
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
            ['title', 'required', 'message' => '标题不能为空'],
            ['title', 'string', 'max' => 32, 'tooLong' => '长度不能大于32位'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'created_at' => '创建时间',
            'updated_at' => '更新时间'
        ];
    }

    public static function getMenuMap()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }

    /**
     * 根据菜单的id获取菜单
    */
    public static function getMenu($menuId)
    {
        $menulinks = Menulink::find()->where(['menu_id' => $menuId])->orderBy('parent_id ASC, order ASC')->asArray()->all();
        return self::getSortMenuLink($menulinks);
    }

    protected static function getSortMenuLink(&$menuLinks, $parentId = 0)
    {
        $items = [];
        $index = 0;
        foreach ($menuLinks as $key => $menuLink) {
            if ($menuLink['parent_id'] == $parentId) {

                $items[$index]['label'] = (!empty($menuLink['image']) ?  '<i class="fa fa-' . $menuLink['image'] . '"></i> ' : '') . $menuLink['label'];

                if (!empty($menuLink['link'])) {
                    $items[$index]['url'] = [$menuLink['link']];
                }

                unset($menuLinks[$key]);

                $childItems = self::getSortMenuLink($menuLinks, $menuLink['id']);
                if (!empty($childItems)) {
                    $items[$index]['items'] = $childItems;
                }
                $index++;
            }
        }

        return $items;
    }
}