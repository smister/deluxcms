<?php

namespace backend\models\search;

use backend\models\User;
use yii\data\ActiveDataProvider;

class UserSearch extends User
{
    public function rules()
    {
        return [
            [['username', 'email'], 'string'],
            ['status', 'integer'],
        ];
    }

    public function search($params)
    {
        $query = self::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ]
        ]);

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['like', 'username', $this->username])
                  ->andFilterWhere(['like', 'email', $this->email])
                  ->andFilterWhere(['status' => $this->status]);
        }

        return $dataProvider;
    }
}