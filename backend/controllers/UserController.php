<?php

namespace backend\controllers;

use backend\models\UpdatePassword;
use Yii;
use backend\models\User;

class UserController extends BaseController
{
    public $modelClass = 'backend\models\User';
    public $modelSearchClass = 'backend\models\search\UserSearch';

    public function actionCreate()
    {
        $model = new $this->modelClass();
        $model->scenario = User::SCENARIO_NEW_USER;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('crudMessage', '添加成功');
            return $this->redirect($this->getRedirectUrl('create', $model));
        }

        return $this->renderIsAjax('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (!empty(Yii::$app->request->post('User')['password'])) {
            $model->scenario = User::SCENARIO_CHANGE_PWD;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('crudMessage', '更新成功');
            return $this->redirect($this->getRedirectUrl('update', $model));
        }

        return $this->renderIsAjax('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdatePassword()
    {
        $model = new UpdatePassword();
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->updatePassword()) {
            Yii::$app->user->logout(); //注销
            return $this->redirect(['/login']);
        }
        return $this->render('updatePassword', ['model' => $model]);
    }
}