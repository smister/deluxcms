<?php
namespace frontend\controllers;

use deluxcms\member\models\Member;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    public $enableCsrfValidation = false;

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'width' => 80,
                'height' => 40,
                'minLength' => 4,
                'maxLength' => 4
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSendCode()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $deviceNum = Yii::$app->request->post('device', '');
        if (Member::isValidateEmail($deviceNum)) return ['status' => false, 'message' => '邮箱已被使用'];
        return \Yii::$app->sms->send($deviceNum, ['title' => 'smister', 'date' => '5分钟']);
    }

    public function actionError()
    {
        return $this->render('error');
    }
}
