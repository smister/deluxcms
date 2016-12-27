<?php
namespace backend\controllers;

class SiteController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionError()
    {
        return $this->render('error');
    }
}
