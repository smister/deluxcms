<?php

namespace deluxcms\media\controllers;

use Yii;
use backend\controllers\BaseController;

class DefaultController extends BaseController
{
    public $enableActions = ['index'];

    public function actionIndex()
    {
        return $this->render('index');
    }
}