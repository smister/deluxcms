<?php

namespace deluxcms\post\models;

use Yii;
use yii\base\Exception;
use yii\data\Pagination;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use common\behaviors\IntegerNullBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;

class Post extends ActiveRecord
{
    protected $tags;

    public static function tableName()
    {
        return '{{%post}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => IntegerNullBehavior::className(),
                'attributes' => [
                  ActiveRecord::EVENT_BEFORE_INSERT => ['order', 'count'],
                  ActiveRecord::EVENT_BEFORE_UPDATE => ['order', 'count'],
                ],
            ],
        ];
    }

    /**
     * 查询的时候给tags复制
    */
    public function afterFind()
    {
        $this->tags = PostTag::getPostTags($this->id);
    }

    public function setTags($value)
    {
        $this->tags = $value;
    }

    public function getTags()
    {
        return Json::encode($this->tags);
    }

    public function rules()
    {
        return [
            [['title', 'content'], 'required', 'message' => '不能为空'],
            [['title', 'seo_title', 'seo_keywords'], 'string', 'max' => 100, 'tooLong' => '长度不能大于100位'],
            [['image', 'intro', 'seo_description'], 'string', 'max' => 255, 'tooLong' => '长度不能大于255位'],
            [['category_id', 'order', 'count'], 'integer', 'message' => '必须是个整数'],
            [['status', 'comment_status'], 'in', 'range' => [0, 1], 'message' => '非法操作'],
            ['slug', 'string', 'max' => 50, 'tooLong' => '长度不能大于50位'],
            //把我们published_at的数据格式由年月日(YYYY-MM-DD)转为时间戳
            ['published_at', 'date', 'timestampAttribute' => 'published_at', 'format' => 'yyyy-MM-dd'],
            ['published_at', 'default', 'value' => time()],
            ['tags', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'category_id' => '分类',
            'image' => '图片',
            'intro' => '简介',
            'content' => '内容',
            'slug' => 'Url美化',
            'order' => '排序',
            'count' => '浏览次数',
            'seo_title' => 'SEO-标题',
            'seo_keywords' => 'SEO-关键词',
            'seo_description' => 'SEO-描述',
            'status' => '状态',
            'comment_status' => '评论状态',
            'published_at' => '发布时间',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'tags' => '标签',
        ];
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($runValidation && !$this->validate()) return false;

        $tran = Yii::$app->db->beginTransaction();
        try {
            if (!parent::save(false, $attributeNames)) {
                throw new Exception("保存帖子出错");
            }

            if (!$this->isNewRecord) {
                //需要删除
                PostTag::deletePostTags($this->id);
            }

            //添加新的标签
            PostTag::addTags($this->id, $this->tags);

            $tran->commit();
            return true;
        } catch (Exception $e) {
            $tran->commit();
            $this->addError('title', $e->getMessage());
            return false;
        }
    }


    public function delete()
    {
        $tran = Yii::$app->db->beginTransaction();
        try {
            if (!parent::delete()) {
                throw new Exception("删除帖子失败");
            }

            PostTag::deletePostTags($this->id);

            $tran->commit();
            return true;
        } catch (Exception $e) {
            $tran->rollBack();
            Yii::error('删除帖子失败' . $e->getMessage());
            return false;
        }
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * 查询帖子的标签
    */
    public function getTagsName()
    {
        return Tag::find()->where(['in', 'id', $this->tags])->asArray()->all();
    }


    public static function getPostListDataProvider($limit = false, $pageSize = 15, $andWhere = [])
    {
        $query = self::find()->where(['status' => 1])->andFilterWhere($andWhere);
        if ($limit) {
            $query->limit($limit);
            $pagination = false;
        } else {
            $pagination =  [
                'pageSize' => $pageSize
            ];
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination,
            'sort' => [
                'defaultOrder' => [
                    'order' => SORT_DESC,
                    'published_at' => SORT_DESC,
                ]
            ]
        ]);

        return $dataProvider;
    }

    /**
     * 获取热门帖子
    */
    public static function getPostHotListDataProvider($limit = 10)
    {
        $query = self::find()->where(['status' => 1])->orderBy('order DESC, published_at DESC')->limit($limit);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        return $dataProvider;
    }

    /**
     * 根据标签id获取帖子列表
    */
    public static function getTagPostListDataProvider($tagId, $pageSize = 10)
    {
        $pt = PostTag::tableName();
        $p = self::tableName();
        //post_id , 需要判断我们post的状态时候可用
        $count = PostTag::find()->leftJoin($p, $pt . '.post_id = ' . $p . '.id')->where([$pt . '.tag_id' => $tagId, $p . '.status' => 1])->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $postIds = PostTag::find()->select('post_id')->leftJoin($p, $pt . '.post_id = ' . $p . '.id')->where([$pt . '.tag_id' => $tagId, $p . '.status' => 1])
                       ->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
        $postIds = ArrayHelper::getColumn($postIds, 'post_id');

        $models = self::find()->where(['in', 'id', $postIds])->orderBy('order DESC, published_at DESC')->all();

        $dataProvider = new ActiveDataProvider();
        $dataProvider->models = $models;
        $dataProvider->pagination = $pagination;

        return $dataProvider;
    }

    public static function getOne($id)
    {
        $post = self::findOne($id);
        if (!$post || $post->status == 0) {
            return false;
        }
        return $post;
    }

    /**
     * 累加浏览次数
    */
    public function incrCount($count = 1)
    {
        $this->count += $count;
        if (!$this->save()) {
            Yii::error('累加浏览次数失败');
            return false;
        }
        return true;
    }

    /**
     * 判断一个帖子是否可以评论
    */
    public static function isComment($postId)
    {
        $post = self::findOne($postId);
        if (!$post || $post->status == 0 || $post->comment_status == 0) {
            return false;
        }
        return true;
    }

}