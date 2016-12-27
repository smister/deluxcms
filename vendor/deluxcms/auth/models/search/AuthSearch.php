<?php

namespace deluxcms\auth\models\search;

use deluxcms\auth\models\Auth;
use deluxcms\member\models\Member;
use yii\data\ActiveDataProvider;

class AuthSearch extends Auth
{
    public function rules()
    {
        return [
            ['member_id', 'string'],
        ];
    }

    public function search($params)
    {
        $query = self::find()->joinWith('member');
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
            $query->andFilterWhere(['like', Member::tableName() . '.nickname', $this->member_id]);
        }

        return $dataProvider;
    }
}