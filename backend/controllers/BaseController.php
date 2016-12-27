<?php

namespace backend\controllers;

use deluxcms\rbac\components\Rbac;
use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class BaseController extends Controller
{
    public $modelClass;
    public $modelSearchClass;

    public $implementedActions = ['index', 'view', 'update', 'create', 'toggle-attribute', 'bulk-activate', 'bulk-deactivate', 'bulk-delete'];
    public $enableActions = [];
    public $disableActions = [];

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {

            if (Yii::$app->user->isGuest) {
                 $this->redirectInAction(['/login/index']);
            }

            if ($this->enableActions !== [] && in_array($action->id, $this->implementedActions) && !in_array($action->id, $this->enableActions)) {
                throw new NotFoundHttpException("找不到控制器方法");
            }

            if (in_array($action->id, $this->disableActions)) {
                throw new NotFoundHttpException("找不到控制器方法");
            }

//            if (!Rbac::auth(Yii::$app->user->id, $action)) {
//                throw new NotFoundHttpException("没有使用权限");
//            }

            return true;
        }
        return false;
    }

    protected function redirectInAction($route, $statusCode = 302)
    {
        $this->redirect($route, $statusCode);
        Yii::$app->end();
    }


    public function actionIndex()
    {
        $model = $this->modelClass;
        $searchModel = $this->modelSearchClass ? new $this->modelSearchClass() : null;
        if ($searchModel) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        } else {
            $dataProvider = new ActiveDataProvider(['query' => $model::find()]);
        }
        //ajax
        return $this->renderIsAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCreate()
    {
        $model = new $this->modelClass();

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
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

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('crudMessage', '更新成功');
            return $this->redirect($this->getRedirectUrl('update', $model));
        }

        return $this->renderIsAjax('update', [
            'model' => $model,
        ]);
    }

    public function actionView($id)
    {
        return $this->renderIsAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete()) {
            Yii::$app->session->setFlash('crudMessage', '删除成功');
        }
        return $this->redirect($this->getRedirectUrl('delete'));
    }

    /**
     * 批量开启
    */
    public function actionBulkActivate()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->post('selection')) {
            $model = $this->modelClass;
            $where = ['id' => Yii::$app->request->post('selection', [])];
            $model::updateAll(['status' => 1], $where);
        }
    }

    /**
     * 批量禁用
    */
    public function actionBulkDeactivate()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->post('selection')) {
            $model = $this->modelClass;
            $where = ['id' => Yii::$app->request->post('selection', [])];
            $model::updateAll(['status' => 0], $where);
        }
    }

    /**
     * 批量删除
    */
    public function actionBulkDelete()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->post('selection')) {
            $selection = Yii::$app->request->post('selection', []);
            foreach ($selection as $id) {
                $this->findModel($id)->delete();
            }
        }
    }

    public function actionToggleAttribute($attribute, $id)
    {
        $model = $this->findModel($id);
        $model->{$attribute} = $model->{$attribute} == 1 ? 0 : 1;
        $model->save(false);
    }


    protected function findModel($id)
    {
        $model = $this->modelClass;
        if (($model = $model::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('找不到合法对象');
        }
    }

    /**
     * 根据控制的名称，获取跳转连接
    */
    protected function getRedirectUrl($action, $model = null)
    {
        switch ($action) {
            case 'create' :
                return ['view', 'id' => $model->id];
            case 'update' :
                return ['update', 'id' => $model->id];
            default:
                return ['index'];
        }
    }

    protected function renderIsAjax($view, $params)
    {
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax($view, $params);
        } else {
            return $this->render($view, $params);
        }
    }


}