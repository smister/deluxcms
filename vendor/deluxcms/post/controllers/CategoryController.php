<?php

namespace deluxcms\post\controllers;

use backend\controllers\BaseController;

class CategoryController extends BaseController
{
    public $modelClass = 'deluxcms\post\models\Category';
    public $modelSearchClass = 'deluxcms\post\models\search\CategorySearch';

    public function actionTest()
    {
        $a = \deluxcms\post\models\Category::getCategorysMap();
        print_r($a);
    }
}