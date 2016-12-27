<?php

namespace deluxcms\auth\controllers;

use backend\controllers\BaseController;

class DefaultController extends BaseController
{
    public $modelClass = 'deluxcms\auth\models\Auth';
    public $modelSearchClass = 'deluxcms\auth\models\search\AuthSearch';

    public $enableActions = ['index'];
}