<?php

namespace deluxcms\menu\models\search;

use deluxcms\menu\models\Menu;
use yii\data\ActiveDataProvider;

class MenuSearch extends Menu
{
    public function search($params)
    {
        $query = self::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => -1
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ]
        ]);

        return $dataProvider;
    }
}