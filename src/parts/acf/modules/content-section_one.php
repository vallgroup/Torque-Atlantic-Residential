<div
  class="content-section align-<?php echo $align; ?> <?php echo $top_bottom_padding; ?>">

  <div class="content-section-image-size <?php echo $reduced_height; ?>">
    <div class="content-section-image background-image-<?php echo $image_background_size ?>" style="background-image: url(<?php echo $image; ?>);" ></div>
  </div>

  <div class="content-wrapper" >
    <h3><?php echo $heading; ?></h3>

    <?php if ($content) { ?>
      <div class="content"><?php echo $content; ?></div>
    <?php } ?>

    <?php if ($cta) { ?>
      <div class="cta-wrapper" >
        <a href="<?php echo $cta['url']; ?>" target="<?php echo $cta['target']; ?>">
          <button class=""><?php echo $cta['title']; ?></button>
        </a>
      </div>
    <?php } ?>
  </div>

</div>
