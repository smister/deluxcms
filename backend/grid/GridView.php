<?php

namespace backend\grid;

class GridView extends \yii\grid\GridView
{
    public $filterPosition = self::FILTER_POS_HEADER;
    public $tableOptions = [
        'class' => ['table table-striped'],
    ];
    public $layout = '{items}<div class="row">
                                        <div class="col-sm-4 m-tb-20">
                                            {bulkActions}
                                        </div>
                                        <div class="col-sm-5 text-center">
                                            {pager}
                                        </div>
                                        <div class="col-sm-3 text-right m-tb-20">
                                            {summary}
                                        </div>
                                    </div>';

    public $pager = [
                    'options' => [
                        'class' => 'pagination pagination-sm',
                    ],
                    'hideOnSinglePage' => false,
                    'firstPageLabel' => '首页',
                    'lastPageLabel' => '最后一页',
                    'prevPageLabel' => '<',
                    'nextPageLabel' => '>'
    ];

    public $bulkActions;
    public $bulkActionOptions = [];

    /**
     * {bulkActions}
    */
    public function renderSection($name)
    {
        switch ($name) {
            case '{bulkActions}' :
                return $this->renderBulkActions();
            default:
               return parent::renderSection($name);
        }
    }

    public function renderBulkActions()
    {
        if (empty($this->bulkActionOptions['gridId'])) {
            $this->bulkActionOptions['gridId'] = $this->id;
        }

        if (!$this->bulkActions) {
            $this->bulkActions = GridBulkActions::widget($this->bulkActionOptions);
        }
        return $this->bulkActions;
    }

}