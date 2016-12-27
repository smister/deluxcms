<?php

namespace deluxcms\post\models\search;

use deluxcms\post\models\Post;
use yii\data\ActiveDataProvider;

class PostSearch extends Post
{
    public function rules()
    {
        return [
            ['title', 'string'],
            [['category_id', 'status'], 'integer']
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
                    'order' => SORT_DESC,
                    'id' => SORT_DESC,
                ]
            ]
        ]);

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['category_id' => $this->category_id, 'status' => $this->status])
                  ->andFilterWhere(['like', 'title', $this->title]);
        }

        return $dataProvider;
    }
}