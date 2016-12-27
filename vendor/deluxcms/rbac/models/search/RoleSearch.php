<?php

namespace deluxcms\rbac\models\search;

use deluxcms\rbac\models\Role;
use yii\data\ActiveDataProvider;

class RoleSearch extends Role
{
    public function rules()
    {
        return [
            [['description', 'name'], 'string']
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
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['like', 'description', $this->description])
                  ->andFilterWhere(['like', 'name', $this->name]);
        }
        return $dataProvider;
    }
}