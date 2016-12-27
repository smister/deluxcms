<?php

namespace backend\models\search;

use common\models\UserVisitLog;
use yii\data\ActiveDataProvider;
use common\models\User;

class UserVisitLogSearch extends UserVisitLog
{
    public function rules()
    {
        return [
            [['ip', 'user_agent', 'browser', 'os', 'user_id', 'visit_time'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = self::find();
        $query->joinWith('user');

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

            $startTime = $endTime = '';
            if ($this->visit_time) {
                $startTime = strtotime($this->visit_time . ' 00:00:00');
                $endTime = strtotime($this->visit_time . ' 23:59:59');
            }

            $query->andFilterWhere(['between', 'visit_time', $startTime, $endTime]);
            $query->andFilterWhere(['like', User::tableName() . '.username', $this->user_id])
                  ->andFilterWhere(['like', $this->tableName() . '.ip', $this->ip])
                  ->andFilterWhere(['like', $this->tableName() . '.user_agent', $this->user_agent])
                  ->andFilterWhere(['like', $this->tableName() . '.browser', $this->browser])
                  ->andFilterWhere(['like', $this->tableName() . '.os', $this->os]);
        }

        return $dataProvider;
    }
}