<?php

namespace deluxcms\rbac;

/**
 * menu module definition class
 */
class Rbac extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'deluxcms\rbac\controllers';

    public $userModelClass;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        if ($this->userModelClass === null) {
            $this->userModelClass = '\backend\models\User';
        }
    }
}
