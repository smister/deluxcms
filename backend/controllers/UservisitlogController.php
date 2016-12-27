<?php

namespace backend\controllers;

class UservisitlogController extends BaseController
{
    public $modelClass = 'common\models\UserVisitLog';
    public $modelSearchClass = 'backend\models\search\UserVisitLogSearch';
}