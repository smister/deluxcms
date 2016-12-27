<?php

namespace deluxcms\media\controllers;

use Yii;
use backend\controllers\BaseController;
use yii\base\Exception;
use yii\web\Response;

class ManageController extends BaseController
{
    public $modelClass = 'deluxcms\media\models\Media';
    public $modelSearchClass = 'deluxcms\media\models\search\MediaSearch';
    public $enableCsrfValidation = false;
    public $enableActions = ['index', 'update', 'delete'];

    public function actionIndex()
    {
        $this->layout = '@vendor/deluxcms/media/views/layouts/base.php';
        $mode = Yii::$app->request->get('mode', '');
        return $this->render('index', [
            'mode' => $mode
        ]);
    }

     public function actionUploader()
    {
        $mode = Yii::$app->request->get('mode', '');
        if ($mode == 'modal') {
            $this->layout = '@vendor/deluxcms/media/views/layouts/base.php';
        }
        $model = new $this->modelClass();
        return $this->render('uploader', [
            'model' => $model,
            'mode' => $mode,
        ]);
    }

    public function actionUpload()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new $this->modelClass();
        try {
            //上传文件
            $model->upload();
            return $model->getUploadFile();
        } catch (Exception $e) {
            return ['files' => [
                ['error' => $e->getMessage()]
            ]];
        }
    }

    public function actionDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = $this->findModel($id);
        if ($model->delete()) {
            $model->deleteFile();
            $response = ['success' => true];
        } else {
            $response = ['error' => true];
        }
        return $response;
    }


    public function actionInfo($id)
    {
        $model = $this->findModel($id);
        return $this->renderPartial('info', [
            'model' => $model
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //成功展示没有提示
        }

        return $this->renderPartial('info', [
            'model' => $model,
        ]);
    }

}