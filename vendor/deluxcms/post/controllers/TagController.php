<?php

namespace deluxcms\post\controllers;

use backend\controllers\BaseController;

class TagController extends BaseController
{
    public $modelClass = 'deluxcms\post\models\Tag';
    public $modelSearchClass = 'deluxcms\post\models\search\TagSearch';
    public $disableActions = ['toggle-attribute', 'bulk-activate', 'bulk-deactivate'];
}