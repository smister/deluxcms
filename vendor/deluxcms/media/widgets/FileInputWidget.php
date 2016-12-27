<?php

namespace deluxcms\media\widgets;

use deluxcms\media\components\ImageUtils;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\widgets\InputWidget;
use deluxcms\media\assets\FileInputAsset;
use yii\helpers\Url;

class FileInputWidget extends InputWidget
{
    public $noImage;

    public $image;
    public $imageOptions = [];
    public $thumbnailWidth = 100;
    public $thumbnailHeight = 100;

    public $launchBtnText = '浏览';
    public $launchBtnOptions = ['class' => 'btn btn-default'];
    public $launchBtnClass = 'media-launch';

    public $resetBtnText = '清空';
    public $resetBtnOptions = ['class' => 'btn btn-default'];
    public $resetBtnClass = 'media-reset';

    public $template = '<div class="file-input">
                        <div class="post-thumbnail thumbnail" style="margin-bottom: 0px;" data-no-image="{noImage}">
                            {image}
                        </div>
                        <div class="input-group">
                            {input}
                            <span class="input-group-btn">
                                {launchBtn}
                                {resetBtn}
                            </span>
                        </div>
                        {modal}
                    </div>';


    public function init()
    {
        parent::init();

        if ($this->id === null) {
            throw new InvalidConfigException("请配置fileinput的id");
        }

        $this->options['id'] = $this->id;
    }

    public function run()
    {
        $replace = [
            '{noImage}' => $this->createNoImage(),
            '{image}' => $this->createImage(),
            '{input}' => $this->createInput(),
            '{launchBtn}' => $this->createLaunchBtn(),
            '{resetBtn}' => $this->createResetBtn(),
            '{modal}' => $this->renderFile('@vendor/deluxcms/media/widgets/views/modal.php', [
                'url' => Url::to(['/media/manage/index', 'mode' => 'modal']),
                'id' => $this->id
            ]),
        ];

        FileInputAsset::register($this->view);

        return strtr($this->template, $replace);
    }

    protected function createNoImage()
    {
        return ImageUtils::getNoImage($this->image);
    }

    protected function createImage()
    {
        if ($this->hasModel()) {
           $image = $this->model->{$this->attribute};
        } else {
            $image = $this->value;
        }
        return Html::img(ImageUtils::thumbnail($image, $this->thumbnailWidth, $this->thumbnailHeight), $this->imageOptions);
    }

    protected function createInput()
    {
        if (!isset($this->options['class'])) {
            $this->options['class'] = 'form-control upload-input';
        }

        if ($this->hasModel()) {
            return Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            return Html::textInput($this->name, $this->value, $this->options);
        }
    }

    protected function createLaunchBtn()
    {
        $this->launchBtnOptions['class'] = $this->launchBtnClass . ' ' . $this->launchBtnOptions['class'];
        if (!isset($this->launchBtnOptions['data-input-id'])) {
            $this->launchBtnOptions['data-input-id'] = $this->id;
        }

        return Html::button($this->launchBtnText, $this->launchBtnOptions);
    }

    protected function createResetBtn()
    {
        $this->resetBtnOptions['class'] = $this->resetBtnClass . ' ' . $this->resetBtnOptions['class'];
        return Html::button($this->resetBtnText, $this->resetBtnOptions);
    }

}