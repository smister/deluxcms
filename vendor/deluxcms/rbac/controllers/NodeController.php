<?php

namespace deluxcms\rbac\controllers;

use backend\controllers\BaseController;

class NodeController extends BaseController
{
    public $modelClass = 'deluxcms\rbac\models\Node';
    public $modelSearchClass = 'deluxcms\rbac\models\search\NodeSearch';
    public $disableActions = ['toggle-attribute', 'bulk-activate', 'bulk-deactivate'];
}