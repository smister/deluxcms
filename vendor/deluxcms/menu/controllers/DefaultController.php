<?php

namespace deluxcms\menu\controllers;

use Yii;
use backend\controllers\BaseController;
use deluxcms\menu\models\search\MenuLinkSearch;

class DefaultController extends BaseController
{
    public $modelClass = 'deluxcms\menu\models\Menu';
    public $modelSearchClass = 'deluxcms\menu\models\search\MenuSearch';
    public $enableActions = ['index', 'update', 'create', 'delete'];

    public function getRedirectUrl($action, $model = null)
    {
        if ($action == 'create') {
            return ['update', 'id' => $model->id];
        }
        return parent::getRedirectUrl($action, $model); // TODO: Change the autogenerated stub
    }

    public function actionIndex()
    {
        $searchModel = $this->modelSearchClass ? new $this->modelSearchClass() : null;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $menuLinkSearch = new MenuLinkSearch();
        return $this->renderIsAjax('index', [
            'dataProvider' => $dataProvider,
            'menuLinkSearch' => $menuLinkSearch,
        ]);
    }
}