<?php

namespace deluxcms\menu\models\search;

use Yii;
use deluxcms\menu\models\Menulink;
use yii\data\ActiveDataProvider;

class MenuLinkSearch extends Menulink
{
    public function rules()
    {
        return [
            [['parent_id', 'menu_id'], 'integer'],
        ];
    }

    public function search($params)
    {
        $query = self::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => -1
            ],
            'sort' => [
                'defaultOrder' => [
                    'order' => SORT_ASC
                ]
            ]
        ]);

        $queryParams = Yii::$app->request->getQueryParams();
        $this->load($queryParams);
        $this->setAttributes($params);

        if ($this->validate()) {
            $query->andFilterWhere(['menu_id' => $this->menu_id, 'parent_id' => $this->parent_id]);
        }

        return $dataProvider;
    }
}