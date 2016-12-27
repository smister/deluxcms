<?php

namespace deluxcms\member\controllers;

use backend\controllers\BaseController;
use Yii;
use deluxcms\member\models\Member;

class DefaultController extends BaseController
{
    public $modelClass = 'deluxcms\member\models\Member';
    public $modelSearchClass = 'deluxcms\member\models\search\MemberSearch';

    public function actionCreate()
    {
        $model = new $this->modelClass();
        $model->scenario = Member::SCENARIO_NEW_MEMBER;

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

        if (!empty(Yii::$app->request->post('Member')['password'])) {
            $model->scenario = Member::SCENARIO_CHANGE_PWD;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('crudMessage', '更新成功');
            return $this->redirect($this->getRedirectUrl('update', $model));
        }

        return $this->renderIsAjax('update', [
            'model' => $model,
        ]);
    }
}