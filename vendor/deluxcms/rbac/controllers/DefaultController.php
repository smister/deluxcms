<?php

namespace deluxcms\rbac\controllers;

use Yii;
use backend\controllers\BaseController;
use deluxcms\rbac\models\Role;
use yii\base\InvalidValueException;

class DefaultController extends BaseController
{
    public $modelClass = 'deluxcms\rbac\models\Role';
    public $modelSearchClass = 'deluxcms\rbac\models\search\RoleSearch';
    public $disableActions = ['toggle-attribute', 'bulk-activate', 'bulk-deactivate'];

    protected function getRedirectUrl($action, $model = null)
    {
        switch ($action) {
            case 'create' :
                return ['view', 'id' => $model->name];
            case 'update' :
                return ['update', 'id' => $model->name];
            default:
                return ['index'];
        }
    }

    /**
     * 给用户授权
    */
    public function actionGrantAuthrity($userId)
    {
        $user = call_user_func([$this->module->userModelClass, 'findOne'], $userId);

        if (!$user) {
            throw new InvalidValueException("找不到用户");
        }

        if (Yii::$app->request->isPost && Role::updateUserRole($userId, Yii::$app->request->post('roles', []))) {
            Yii::$app->session->setFlash('crudMessage', '授权成功');
        }

        return $this->render('grantAuthrity', [
            'user' => $user,
            'roles' => Role::getRoles(),
            'userRoles' => Role::getRolesByUserId($userId),
        ]);
    }
}