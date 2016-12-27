<?php

namespace deluxcms\comment\controllers;

use backend\controllers\BaseController;

class DefaultController extends BaseController
{
    public $modelClass = 'deluxcms\comment\models\Comment';
    public $modelSearchClass = 'deluxcms\comment\models\search\CommentSearch';
    public $disableActions = ['view', 'update', 'create'];
}