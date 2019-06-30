<div
  class="content-section <?php echo $align; ?>">

  <div class="content-section-image-size">
    <div class="content-section-image" style="background-image: url(<?php echo $image; ?>);" ></div>
  </div>

  <div class="content-wrapper" >
    <h3><?php echo $heading; ?></h3>

    <?php if ($content) { ?>
      <div class="content"><?php echo $content; ?></div>
    <?php } ?>

    <?php if ($cta) { ?>
      <div class="cta-wrapper" >
        <a href="<?php echo $cta['url']; ?>" target="<?php echo $cta['target']; ?>">
          <button class="white"><?php echo $cta['title']; ?></button>
        </a>
      </div>
    <?php } ?>
  </div>

</div>
