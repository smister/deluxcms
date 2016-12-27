<?php

namespace deluxcms\post\controllers;

use backend\controllers\BaseController;

class DefaultController extends BaseController
{
    public $modelClass = 'deluxcms\post\models\Post';
    public $modelSearchClass = 'deluxcms\post\models\search\PostSearch';
}