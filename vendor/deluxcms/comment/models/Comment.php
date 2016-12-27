<?php

namespace deluxcms\comment\models;

use Yii;
use deluxcms\member\models\Member;
use deluxcms\post\models\Post;
use yii\base\ErrorException;
use yii\data\Pagination;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;

class Comment extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%comment}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [['top_id', 'parent_id', 'post_id', 'member_id'], 'integer', 'message' => '请输入一个数字'],
            ['content', 'required', 'message' => '评论内容不能为空'],
            ['content', 'string', 'max' => 500, 'tooLong' => '评论内容长度不能大于500位'],
            ['status', 'in', 'range' => [0, 1], 'message' => '非法操作'],
        ];
    }

    public static function add($data)
    {
        try {
            $saveAttribute = [];
            if (empty($data['content']) || mb_strlen($data['content'], 'utf-8') > 500) {
                throw new ErrorException('评论内容不能为空并且长度小于500位');
            }
            $saveAttribute['content'] = $data['content'];

            if (empty($data['member_id'])) {
                throw new ErrorException('请先登录');
            }
            $saveAttribute['member_id'] = $data['member_id'];

            $reComment = self::findOne(self::decodeData($data['parent_id']));
            if (!$reComment || $reComment->status == 0) {
                $saveAttribute['parent_id'] = 0;
                $saveAttribute['top_id'] = 0;
            } else { //这里说明是回复评论，这边就需要处理
                $saveAttribute['parent_id'] = $reComment->id;
                $saveAttribute['top_id'] = $reComment->top_id == 0 ? $reComment->id : $reComment->top_id;
            }

            $captcha = new CaptchaModel();
            $captcha->verifyCode = $data['verifyCode'];
            if (!$captcha->validate()) {
                throw new ErrorException('验证码错误');
            }

            if (!Post::isComment($data['post_id'])) {
                throw new ErrorException('无法评论改帖子');
            }
            $saveAttribute['post_id'] = $data['post_id'];


            $comment = new self();
            $comment->setAttributes($saveAttribute);
            if (!$comment->save()) {
                throw new ErrorException('添加评论错误,错误信息：' . print_r($comment->getErrors(), true));
            }
            return ['status' => true, 'message' => '评论成功'];
        } catch (ErrorException $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * 获取评论列表的dataprovider
    */
    public static function getCommentsDataProvider($postId, $pageSize = 10, $andWhere = [])
    {
        if (!$pageSize) {
            $pagination = false;
        } else {
            $pagination =  [
                'pageSize' => $pageSize,
            ];
        }

        if (empty($andWhere)) $andWhere = ['top_id' => 0];

        $query = self::find()->where(['post_id' => $postId, 'status' => 1])->andFilterWhere($andWhere);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_ASC,
                ]
            ]
        ]);

        return $dataProvider;
    }

    public function getMember()
    {
        return $this->hasOne(Member::className(), ['id' => 'member_id']);
    }

    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    public function getRecomment()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

    public function getEncodeParentId()
    {
        return self::encodeData($this->id);
    }

    public static function encodeData($value)
    {
        $randomStr = Yii::$app->security->generateRandomString();
        return substr($randomStr, 0, 16) . $value . substr($randomStr, 16);
    }

    public static function decodeData($value)
    {
        return substr($value, 16, -16);
    }

    /**
     * 获取子评论
    */
    public function getRecommentDataProvider($where = [])
    {
        if (empty($where)) $where = ['top_id' => $this->id];
        return self::getCommentsDataProvider($this->post_id, false, $where);
    }

    /**
     * 获取会员评论的帖子
    */
    public static function getMemberCommentPosts($memberId, $pageSize = 10)
    {
        $count = self::find()->select('COUNT(DISTINCT post_id)')->where(['member_id' => $memberId, 'status' => 1])->scalar();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);

        //获取评论，再根据评论关联的帖子获取标题
        $models = self::find()->where(['member_id' => $memberId, 'status' => 1])->groupBy('post_id')->offset($pagination->offset)->limit($pagination->limit)->all();

        $dataProvider = new ActiveDataProvider();
        $dataProvider->pagination = $pagination;
        $dataProvider->models = $models;

        return $dataProvider;
    }

    public static function getMemberCommentPost($postId, $memberId)
    {
        $query = self::find()->where(['post_id' => $postId, 'member_id' => $memberId, 'status' => 1]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ]
            ]
        ]);

        return $dataProvider;
    }


    public static function getMemberComment($commentId)
    {
        $query = self::find()->where(['parent_id' => $commentId, 'status' => 1]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ]
            ]
        ]);

        return $dataProvider;
    }

}