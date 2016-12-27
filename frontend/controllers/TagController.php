<?php

namespace frontend\controllers;

use deluxcms\post\models\Tag;
use frontend\components\Setting;
use yii\web\Controller;

class TagController extends Controller
{
    public function actionIndex($tagName = '')
    {
        $tag = Tag::find()->where(['name' => $tagName])->one();
        if (!$tag) return $this->redirect(['/site/index']);
        Setting::getInstance()->setTitle("帖子标签-" . $tagName);
        return $this->render('index', [
            'tag' => $tag,
        ]);
    }
}