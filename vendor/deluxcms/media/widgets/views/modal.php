<?php

use deluxcms\media\assets\ModalAsset;

ModalAsset::register($this);
?>

<div role="media-modal" class="modal" tabindex="-1" style="z-index:9999999"
data-frame-src="<?= $url ?>"
data-frame-id="<?= $id ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body"></div>
        </div>
    </div>
</div>