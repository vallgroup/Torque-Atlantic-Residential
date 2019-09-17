<div class="content-section align-<?php echo $align; ?> <?php echo $top_bottom_padding; ?>">

<?php /* Hide on tablet and desktop */ ?>
  <div class="content-wrapper hide-on-tablet hide-on-desktop">
    <h3><?php echo $heading; ?></h3>

    <?php if ($content) { ?>
      <div class="content"><?php echo $content; ?></div>
    <?php } ?>
    <?php if ($cta) { ?>
      <div class="cta-wrapper">
        <a href="<?php echo $cta['url']; ?>" target="<?php echo $cta['target']; ?>">
          <button class=""><?php echo $cta['title']; ?></button>
        </a>
      </div>
    <?php } ?>
  </div>
<?php /* --------- */ ?>

  <div class="content-section-image-size <?php echo $reduced_height; ?>">
    <div class="content-section-image background-image-<?php echo $image_background_size ?>" style="background-image: url(<?php echo $image_url; ?>);"></div>
    <?php if ($image_caption != '') { ?>
      <div class="image-caption hide-on-tablet hide-on-desktop"><?php echo $image_caption; ?></div>
    <?php } ?>
  </div>

<?php /* Hide on mobile */ ?>
  <div class="content-wrapper hide-on-mobile">
    <h3><?php echo $heading; ?></h3>

    <?php if ($content) { ?>
      <div class="content"><?php echo $content; ?></div>
    <?php } ?>
    <?php if ($cta) { ?>
      <div class="cta-wrapper">
        <a href="<?php echo $cta['url']; ?>" target="<?php echo $cta['target']; ?>">
          <button class=""><?php echo $cta['title']; ?></button>
        </a>
      </div>
    <?php } ?>
    <?php if ($image_caption != '') { ?>
      <div class="image-caption"><?php echo $image_caption; ?></div>
    <?php } ?>
  </div>
<?php /* --------- */ ?>

</div>