<?php

namespace backend\controllers;

use Yii;
use common\models\Setting;

class SettingController extends BaseController
{
    public $enableActions = ['index'];
    public function actionIndex()
    {

        \deluxcms\menu\models\Menu::getMenu(1);

        $model = Setting::findOne(Setting::SETTING_ID);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('crudMessage', '更新成功');
            return $this->redirect(['/setting/index']);
        }

        return $this->renderIsAjax('index', [
            'model' => $model,
        ]);
    }
}