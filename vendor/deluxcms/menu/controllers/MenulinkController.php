<?php

namespace deluxcms\menu\controllers;

use Yii;
use backend\controllers\BaseController;

class MenulinkController extends BaseController
{
    public $modelClass = 'deluxcms\menu\models\MenuLink';
    public $modelSearchClass = 'deluxcms\menu\models\search\MenuLinKSearch';
    //添加，编辑，删除
    public $enableActions = ['create', 'update', 'delete'];

    public function getRedirectUrl($action, $model = null)
    {
        if ($action == 'delete' ) {
            return ['/menu'];
        } elseif ($action == 'create') {
            return ['create'];
        } else {
            return parent::getRedirectUrl($action, $model);
        }
    }

    public function actionSaveOrders()
    {
        $post = Yii::$app->request->post();
        if (Yii::$app->request->isAjax && !empty($post['settings'])) {
            $model = new $this->modelClass();
            return $model->saveOrders($post['settings']);
        }
        return false;
    }
}