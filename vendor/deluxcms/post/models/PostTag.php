<?php

namespace deluxcms\post\models;

use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class PostTag extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%post_tag_post}}';
    }

    public function rules()
    {
        return [
            [['post_id', 'tag_id'], 'integer', 'message' => '必须是个整数']
        ];
    }

    public static function addTags($postId, $tags)
    {
        if (empty($tags) || !is_array($tags)) return false;

        foreach($tags as $tag) {
            if (is_numeric($tag)) { //这里如果是数字的话，证明数据库存在
                if (!Tag::find()->where(['id' => $tag])->exists()) {
                    continue;
                }
            } else { //这边是我们tag不存在
                $model = new Tag();
                $model->name = $tag;
                if (!$model->save()) {
                    throw new Exception("添加标签错误,错误信息：" . print_r($model->getErrors(), true));
                }
                $tag = $model->id;
            }

            $tagPost = new self();
            $tagPost->setAttributes([
                'post_id' => $postId,
                'tag_id' => $tag
            ]);
            if (!$tagPost->save()) {
                throw new Exception("添加标签与帖子的关系错误,错误信息：" . print_r($tagPost->getErrors(), true));
            }
        }

        return true;
    }

    public static function deletePostTags($postId)
    {
        return self::deleteAll(['post_id' => $postId]);
    }

    public static function getPostTags($postId) {
        return ArrayHelper::getColumn(self::find()->select('tag_id')->where(['post_id' => $postId])->asArray()->all(), 'tag_id');
    }
}