<?php

namespace deluxcms\slideshow\controllers;

use backend\controllers\BaseController;

class DefaultController extends BaseController
{
    public $modelClass = 'deluxcms\slideshow\models\Slideshow';
    public $modelSearchClass = 'deluxcms\slideshow\models\search\SlideshowSearch';
}