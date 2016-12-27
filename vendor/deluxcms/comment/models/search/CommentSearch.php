<?php

namespace deluxcms\comment\models\search;

use deluxcms\comment\models\Comment;
use deluxcms\member\models\Member;
use deluxcms\post\models\Post;
use yii\data\ActiveDataProvider;

class CommentSearch extends Comment
{
    public function rules()
    {
        return [
            [['content', 'post_id', 'member_id'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = self::find()->joinWith('post')->joinWith('member');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ]
        ]);

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['like', self::tableName() . '.content', $this->content])
                  ->andFilterWhere(['like', Post::tableName() . '.title', $this->post_id])
                  ->andFilterWhere(['like', Member::tableName() . '.nickname', $this->member_id]);
        }

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return [
            'content' => '评论内容',
            'post_id' => '回复帖子',
            'member_id' => '会员昵称',
            'created_at' => '评论时间',
            'status' => '状态',
        ];
    }
}