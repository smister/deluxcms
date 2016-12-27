<?php

namespace deluxcms\authclient\components;

use deluxcms\auth\models\Auth;
use deluxcms\member\models\MemberVisitLog;
use Yii;

class AuthClient
{
    public static function handlerAuth($client, $memberUrl = ['/member'], $loginUrl = ['/member/login'])
    {
        if (Yii::$app->user->isGuest) {
            $auth = Auth::getAuthUser($client);
            if (!$auth || !Yii::$app->user->login($auth->member)) {
                 Yii::$app->response->redirect($loginUrl);
                Yii::$app->end();
            }
            MemberVisitLog::addUserVisitLog(Yii::$app->user->getId());
        }

        //下面跳转会员中心
        Yii::$app->response->redirect($memberUrl);
        Yii::$app->end();
    }
}