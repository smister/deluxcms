<?php

namespace deluxcms\slideshow\models\search;

use deluxcms\slideshow\models\Slideshow;
use yii\data\ActiveDataProvider;

class SlideshowSearch extends Slideshow
{
    public function rules()
    {
        return [
            ['title', 'string']
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
                    'order' => SORT_DESC,
                    'id' => SORT_DESC,
                ]
            ]
        ]);

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['like', 'title', $this->title]);
        }

        return $dataProvider;
    }
}