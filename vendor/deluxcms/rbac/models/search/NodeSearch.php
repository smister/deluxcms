<?php

namespace deluxcms\rbac\models\search;

use deluxcms\rbac\models\Node;
use yii\data\ActiveDataProvider;

class NodeSearch extends Node
{
    public function rules()
    {
        return [
            [['nickname', 'name'], 'string'],
            ['parent_id', 'integer'],
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
                    'id' => SORT_DESC,
                ]
            ]
        ]);


        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['like', 'nickname', $this->nickname])
                  ->andFilterWhere(['like', 'name', $this->name])
                  ->andFilterWhere(['parent_id' => $this->parent_id]);
        }

        return $dataProvider;
    }
}