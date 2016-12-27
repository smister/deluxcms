<?php if (!empty($items)) :?>
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php foreach ($items as $key => $item) :?>
            <li data-target="#carousel-example-generic" data-slide-to="0" <?= $key == 0 ? 'class="active"' : '';?>></li>
        <?php endforeach; ?>
    </ol>
    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <?php foreach ($items as $key => $item) :?>
            <div class="item <?= $key == 0 ? 'active' : '';?>">
                <a href="<?= $item['link']?>">
                    <img class="slideshow-image" src="<?= \deluxcms\media\components\ImageUtils::thumbnail($item['image'], 1580, 700, $noImage)?>" alt="<?= $item['title']?>">
                    <div class="carousel-caption">
                        <h3><?= $item['title']?></h3>
                        <p><?= $item['description']?></p>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<?php endif; ?>
<?php
$this->registerCss(<<<CSS
    .slideshow-image {
        width:100%;
        margin:0 auto;
    }
CSS
);
?>