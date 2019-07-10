<?php ?>
<div class="content-section-video">
    <?php if ($video) { ?>
        <div class="content-video-wrapper">
            <video autoplay loop muted playsinline class="content-video" src="<?php echo $video; ?>">
            </video>
        </div>
    <?php } ?>
</div>