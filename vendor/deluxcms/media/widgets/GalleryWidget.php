<?php

namespace deluxcms\media\widgets;

use Yii;
use yii\base\Widget;

class GalleryWidget extends Widget
{
    public $searchModel;
    public $dataProvider;
    protected $modelSearchClass = 'deluxcms\media\models\search\MediaSearch';
    public $mode;

    public function init()
    {
        parent::init();
        if ($this->searchModel === null) {
            $this->searchModel = new $this->modelSearchClass;
        }

        if ($this->dataProvider === null) {
            $queryPrams = Yii::$app->request->getQueryParams();
            $this->dataProvider = $this->searchModel->search($queryPrams);
        }
    }

    public function run()
    {
        return $this->renderFile('@vendor/deluxcms/media/widgets/views/gallery.php', [
            'searchModel' => $this->searchModel,
            'dataProvider' => $this->dataProvider,
            'mode' => $this->mode,
        ]);
    }
}