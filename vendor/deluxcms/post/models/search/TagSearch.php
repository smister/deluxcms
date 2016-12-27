<?php

namespace deluxcms\post\models\search;

use deluxcms\post\models\Tag;
use yii\data\ActiveDataProvider;

class TagSearch extends Tag
{
    public function rules()
    {
        return [
            ['name', 'string'],
        ];
    }

    public function search($params)
    {
        $query = self::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ]
        ]);

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['like', 'name', $this->name]);
        }

        return $dataProvider;
    }
}