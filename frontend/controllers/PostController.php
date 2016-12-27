<?php

namespace frontend\controllers;

use deluxcms\comment\models\Comment;
use frontend\components\Setting;
use Yii;
use deluxcms\post\models\Category;
use deluxcms\post\models\Post;
use yii\web\Controller;
use yii\web\Response;

class PostController extends Controller
{
    public function actionIndex($id)
    {
        $post = Post::getOne($id);
        if (!$post) return $this->redirect(['/site/index']);
        $post->incrCount();
        Setting::getInstance()->batchSetSeo($post);
        return $this->render('index', [
            'post' => $post
        ]);
    }

    public function actionList($cid = 0)
    {
        $category = false;
        Setting::getInstance()->setTitle("文章列表");
        if ($cid > 0) {
            $category = Category::findOne($cid);
            Setting::getInstance()->batchSetSeo($category);
        }
        return $this->render('list', [
            'category' => $category,
        ]);
    }

    public function actionComment()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = [
            'parent_id' => Yii::$app->request->post('parentId', ''),
            'post_id' => (int)Yii::$app->request->post('postId', 0),
            'content' => Yii::$app->request->post('content', ''),
            'verifyCode' => Yii::$app->request->post('verifyCode', ''),
            'member_id' => Yii::$app->user->getId()
        ];

        return Comment::add($data);
    }
}