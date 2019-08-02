<?php if( $images ): ?>
<div class="image-gallery-section-container">
    <div class="image-wrapper">
    <?php foreach( $images as $image ): ?>
        <div class="image-item">
            <img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" />
            <?php if ( $image['caption'] != '' ) { ?>
            <h4><?php echo $image['caption']; ?></h4>
            <?php } ?>
        </div>
    <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>