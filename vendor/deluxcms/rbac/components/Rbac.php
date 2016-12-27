<?php

namespace deluxcms\rbac\components;

use Yii;

class Rbac
{
    public static function auth($userId, $action, $allowActions = [])
    {
        //控制器controllerId + 方法名actionName
        //有模块的情况下，模块id + controllerId + 方法名actionName

        //http://localhost:8080/YiiCms/backend/web/
        //控制器controllerId :$action->controller->id site
        //方法名actionName: $action->id index
        //模块yii\web\Application
        //拼装规则:site_index

        //http://localhost:8080/YiiCms/backend/web/index.php?r=user/index
        //方法名actionName: $action->id index
        //控制器controllerId :user
        //模块yii\web\Application
        //拼装规则:user_index

        //http://localhost:8080/YiiCms/backend/web/index.php?r=rbac/default/index
        //方法名actionName: $action->id index
        //控制器controllerId :default
        //模块不是yii\web\Application , 获取的id是rbac
        //拼装规则: rbac_default_index

        $normalAction = $action->controller->id . '_' . $action->id;
        if (!$action->controller->module instanceof \yii\web\Application) {
            //这里说明我们是使用了模块
            $normalAction = $action->controller->module->id . '_' . $normalAction;
        }

        if (in_array($normalAction, $allowActions) || Yii::$app->authManager->checkAccess($userId, $normalAction)) {
            return true;
        }

        return false;
    }
}