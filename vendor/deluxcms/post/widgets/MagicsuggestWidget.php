<?php

namespace deluxcms\post\widgets;

use Yii;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\widgets\InputWidget;

class MagicsuggestWidget extends InputWidget
{
    public $clientOptions = [
        'hideTrigger' => true, //隐藏左边的下拉菜单按钮
        'toggleOnClick' => true, //点击时出现下拉菜单
    ];

    public $items = [];  //存放我们data的数据

    public function init()
    {
        parent::init();
        $this->clientOptions['data'] = $this->items;
    }

    public function run()
    {
        $this->registerClientOptions();
        if ($this->hasModel()) {
            return Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            return Html::textInput($this->name, $this->value, $this->options);
        }
    }

    protected function registerClientOptions()
    {
        \deluxcms\post\assets\MagicsuggestAsset::register(Yii::$app->view);
        Yii::$app->view->registerJs("$('#{$this->options['id']}').magicSuggest(" . Json::encode($this->clientOptions) . ")");
    }
}