<?php

namespace deluxcms\member\controllers;

use deluxcms\authclient\components\AuthClient;
use deluxcms\member\models\ForgetPassword;
use deluxcms\member\models\LoginForm;
use deluxcms\member\models\Member;
use deluxcms\member\models\UpdateEmail;
use deluxcms\member\models\updateMember;
use deluxcms\member\models\UpdatePassword;
use Yii;
use deluxcms\member\models\RegisterForm;
use yii\web\Controller;
use yii\web\Response;

abstract class FMemberController extends Controller
{
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'width' => 80,
                'height' => 40,
                'minLength' => 4,
                'maxLength' => 4
            ],
             'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess($client)
    {
        (new AuthClient())->handlerAuth($client);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                //'only' => ['create', 'update'], //只验证哪一些
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'logout', 'update-password', 'send-code', 'verify-email', 'update-email', 'update', 'auth'],
                        'roles' => ['@'], //@是已登录的角色，?是游客状态
                    ],
                    [
                        'allow' => true,
                        'actions' => ['register', 'login', 'forget-password', 'send-code', 'captcha', 'auth'],
                        'roles' => ['?'],
                    ],
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('@vendor/deluxcms/member/views/fmember/index.php', ['member' => Yii::$app->user->getIdentity()]);
    }

    public function actionRegister()
    {
        $model = new RegisterForm();
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            if (Yii::$app->user->login($model)) {
                return $this->redirect(['/member/index']);
            } else {
                return $this->redirect(['/member/login']);
            }
        }

        return $this->render('@vendor/deluxcms/member/views/fmember/register.php', ['model' => $model]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['/member/login']);
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())){
            if (Yii::$app->request->post('loginAjax')) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $model->loginByAjax();
            } elseif ($model->login()) {
                return $this->redirect(['/member/index']);
            }
        }

        return $this->render('@vendor/deluxcms/member/views/fmember/login.php', ['model' => $model]);
    }

    public function actionForgetPassword()
    {
        $model = new ForgetPassword();
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->updatePassword()) {
            return $this->redirect(['login']);
        }
        return $this->render('@vendor/deluxcms/member/views/fmember/forgetPassword.php', ['model' => $model]);
    }

    public function actionUpdatePassword()
    {
        $model = new UpdatePassword();
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->updatePassword()) {
            Yii::$app->user->logout(); //注销
            return $this->redirect(['login']);
        }
        return $this->render('@vendor/deluxcms/member/views/fmember/updatePassword.php', ['model' => $model]);
    }

    public function actionSendCode()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $deviceNum = Yii::$app->request->post('device', '');
        if (!Member::getMemberByValiableEmail($deviceNum)) return false;
        return \Yii::$app->sms->send($deviceNum, ['title' => 'smister', 'date' => '5分钟']);
    }

    public function actionVerifyEmail()
    {
        $member = Yii::$app->user->getIdentity();
        if (!$member->email_validate || UpdateEmail::hadEmailToken()) return $this->redirect(['update-email']);
        $model = new UpdateEmail();
        $model->email = $member->email;

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->verifyEmail()) {
            return $this->redirect(['update-email']);
        }

        return $this->render('@vendor/deluxcms/member/views/fmember/verifyEmail.php', ['model' => $model]);
    }


    public function actionUpdateEmail()
    {
        if (Yii::$app->user->getIdentity()->email_validate && !UpdateEmail::hadEmailToken()) return $this->redirect(['verify-email']);
        $model = new UpdateEmail();
        $model->scenario = UpdateEmail::SCENARIO_UPDATE;
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->updateEmail()) {
            return $this->redirect(['index']);
        }
        return $this->render('@vendor/deluxcms/member/views/fmember/updateEmail.php', ['model' => $model]);
    }

    public function actionUpdate()
    {
        $model  = new updateMember();
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->update()) {
            return $this->redirect(['index']);
        }
        return $this->render('@vendor/deluxcms/member/views/fmember/update.php', ['model' => $model]);
    }
}