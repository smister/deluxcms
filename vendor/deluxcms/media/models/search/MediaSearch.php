<?php

namespace deluxcms\media\models\search;

use deluxcms\media\models\Media;
use yii\data\ActiveDataProvider;

class MediaSearch extends Media
{
    public function rules()
    {
        return [
            [['filename', 'created_at'], 'string'],
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
            $startTime = $endTime = '';
            if ($this->created_at) {
                $startTime = strtotime($this->created_at . ' 00:00:00');
                $endTime = strtotime($this->created_at . ' 23:59:59');
            }

            $query->andFilterWhere(['between', 'created_at', $startTime, $endTime])
                  ->andFilterWhere(['like', 'filename', $this->filename]);
        }

        return $dataProvider;
    }
}