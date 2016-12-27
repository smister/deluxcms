<?php

namespace deluxcms\member\controllers;

use backend\controllers\BaseController;

class MembervisitlogController extends BaseController
{
    public $modelClass = 'deluxcms\member\models\MemberVisitLog';
    public $modelSearchClass = 'deluxcms\member\models\search\MemberVisitLogSearch';
}