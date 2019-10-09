<?php ?>
<div class="content-section-video">
    <?php if ($video) { ?>
        <div class="content-video-wrapper">
            <video class="content-video" src="<?php echo $video; ?>" <?php echo $poster_image ? 'poster="'.$poster_image.'"' : '' ?> controls playsinline controlsList="nodownload">
            </video>
        </div>
    <?php } ?>
</div>