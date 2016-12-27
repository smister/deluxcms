<?php

namespace backend\grid\columns;

use yii\base\Model;
use yii\grid\DataColumn;
use yii\jui\DatePicker;

class DataDateColumn extends DataColumn
{
    public $dateFormat = 'yyyy-MM-dd';
    public $language = 'zh-cn';

    protected function renderFilterCellContent()
    {
        if (is_string($this->filter)) {
            return $this->filter;
        }

        $model = $this->grid->filterModel;

        if ($this->filter !== false && $model instanceof Model && $this->attribute !== null && $model->isAttributeActive($this->attribute)) {
            if ($model->hasErrors($this->attribute)) {
                Html::addCssClass($this->filterOptions, 'has-error');
                $error = ' ' . Html::error($model, $this->attribute, $this->grid->filterErrorOptions);
            } else {
                $error = '';
            }

            return DatePicker::widget([
                'model' => $model,
                'attribute' => $this->attribute,
                'dateFormat' => $this->dateFormat,
                'language' => $this->language,
                'options' => $this->filterInputOptions
            ]) . $error;

        } else {
            return parent::renderFilterCellContent();
        }
    }
}