<?php

namespace deluxcms\media\widgets;

use yii\base\InvalidConfigException;
use yii\bootstrap\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\widgets\InputWidget;
use yii\helpers\Url;

class TinyMceWidget extends InputWidget
{

    public $clintOptions = [
        'menubar' => false, //顶部的菜单栏
        'height' => 300, //高度
        'image_dimensions' => true, //是否可调整图片的尺寸
        'plugins' => [
            'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code contextmenu table wordcount pagebreak'
        ], //引入的插件
        'toolbar' => 'undo redo | styleselect bold italic | alignleft aligncenter alignright alignjustify bullist numlist outdent indent | pagebreak link image table | code',
    ];

    public function init()
    {
        parent::init();
        if ($this->id === null) {
            throw new InvalidConfigException("请配置TinyMce的id");
        }

        if (!isset($this->clintOptions['selector'])) {
            $this->clintOptions['selector'] = '#' . $this->id;
        }

        if (!isset($this->clintOptions['file_picker_callback'])) {
            $this->clintOptions['file_picker_callback'] = new JsExpression('function (callback, value, meta) {
                 mediaTinyMce(callback, value, meta);
            }');
        }

        $this->options['id'] = $this->id;
    }

    public function run()
    {
        if ($this->hasModel()) {
            $output = Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            $output = Html::textarea($this->name, $this->value, $this->options);
        }

        $this->registerClientOptions();

        return $output . $this->renderFile('@vendor/deluxcms/media/widgets/views/modal.php', [
                'url' => Url::to(['/media/manage/index', 'mode' => 'modal']),
                'id' => $this->id
            ]);
    }

    protected function registerClientOptions()
    {
        \deluxcms\media\assets\TinyMceAsset::register($this->view);
        \deluxcms\media\assets\MediaTinyMceAsset::register($this->view);

        $options = Json::encode($this->clintOptions);
        $this->view->registerJs('tinymce.init(' . $options . ')');
    }
}