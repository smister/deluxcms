<?php

namespace deluxcms\post\models\search;

use deluxcms\post\models\Category;
use yii\data\ActiveDataProvider;

class CategorySearch extends Category
{
    public function rules()
    {
        return [
            ['name', 'string'],
            [['parent_id', 'status'], 'integer'],
        ];
    }

    public function search($params)
    {
        $query = self::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
            ],
            'sort' => [
                'defaultOrder' => [
                    'order' => SORT_ASC,
                    'id' => SORT_DESC
                ]
            ]
        ]);

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['like', 'name', $this->name])
                  ->andFilterWhere(['parent_id' => $this->parent_id, 'status' => $this->status]);
        }

        return $dataProvider;
    }
}