<?php

namespace backend\widgets;

use yii\helpers\Html;

class Nav extends \yii\bootstrap\Nav
{
    public $dropDownOptions = [
        'class' => 'nav nav-second-level collapse',
        'aria-expanded' => "false"
    ];

    public function renderItems($itemList = [], $child = false)
    {
        $itemList = empty($itemList) ? $this->items : $itemList;
        $options = $child ? $this->dropDownOptions : $this->options;
        $items = [];
        foreach ($itemList as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }
            $items[] = $this->renderItem($item);
        }

        return Html::tag('ul', implode("\n", $items), $options);
    }

    protected function renderDropdown($items, $parentItem)
    {
        return $this->renderItems($items, true);
    }
}