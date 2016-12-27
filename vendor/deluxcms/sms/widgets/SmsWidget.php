<?php

namespace deluxcms\sms\widgets;

use deluxcms\sms\assets\SmsAsset;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\widgets\InputWidget;
use Yii;

class SmsWidget extends InputWidget
{
    public $template = '<div>{input}{button}</div>';
    public $buttonText = '点击发送';
    public $buttonOptions;
    public $sendCodeUrl = ['site/send-code'];

    public function init()
    {
        parent::init();

        if (!isset($this->buttonOptions['class'])) {
            $this->buttonOptions['class'] = 'btn btn-primary send-btn';
        }

        if (!isset($this->options['class'])) {
            $this->options['class'] = 'form-control code-input-left';
        }

        $this->buttonOptions['class'] .= ' send-code';
    }

    public function run()
    {
        $this->registerClientOptions();

        $data = [];
        if ($this->hasModel()) {
            $data['{input}'] = Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            $data['{input}'] = Html::textInput($this->name, $this->value, $this->options);
        }

        $data['{button}'] = Html::button($this->buttonText, $this->buttonOptions);

        $js = $this->getGlobalJs();

        return  $js . strtr($this->template, $data);
    }

    protected function registerClientOptions()
    {
        SmsAsset::register(Yii::$app->view);
    }

    protected function getGlobalJs()
    {
        return '<script>
            var vcodeUrl = "' . Url::to($this->sendCodeUrl) . '";
        </script>';
    }
}