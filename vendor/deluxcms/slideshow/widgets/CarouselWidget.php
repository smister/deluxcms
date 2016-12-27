<?php

namespace deluxcms\slideshow\widgets;

use yii\base\Widget;

class CarouselWidget extends Widget
{
    public $noImage = '@vendor/deluxcms/slideshow/source/images/no_slideshow.jpg';
    public $items = [];
    public function run()
    {
        return $this->renderFile('@vendor/deluxcms/slideshow/widgets/views/carousel.php', [
            'items' => $this->items,
            'noImage' => $this->noImage,
        ]);
    }
}