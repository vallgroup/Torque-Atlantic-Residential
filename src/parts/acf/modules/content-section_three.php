<div class="content-section-three align-<?php echo $align; ?> background-<?php echo $background_color; ?>">

  <div class="content-container">

  <?php /* Hide on tablet and desktop */ ?>
    <div class="content-wrapper hide-on-tablet hide-on-desktop">
      <div class="bg-quotation-mark-top"></div>
      <div class="bg-quotation-mark-bottom"></div>
      <h3><?php echo $quote; ?></h3>
    </div>
    <?php if ($content || $cta) { ?>
      <div class="cta-wrapper hide-on-tablet hide-on-desktop">
        <?php if ($content) { ?>
          <div class="content"><?php echo $content; ?></div>
        <?php } ?>

        <?php if ($cta) { ?>
          <a href="<?php echo $cta['url']; ?>" target="<?php echo $cta['target']; ?>">
            <button class="<?php echo $button_light; ?>"><?php echo $cta['title']; ?></button>
          </a>
        <?php } ?>
      </div>
    <?php } ?>
  <?php /* --------- */ ?>

    <div class="content-section-image-size">
      <div class="content-section-image" style="background-image: url(<?php echo $image_url; ?>);"></div>
      <?php if ($image_caption != '') { ?>
        <div class="image-caption hide-on-tablet hide-on-desktop"><?php echo $image_caption; ?></div>
      <?php } ?>
    </div>

  <?php /* Hide on mobile */ ?>
    <div class="content-wrapper hide-on-mobile">
      <div class="bg-quotation-mark-top"></div>
      <div class="bg-quotation-mark-bottom"></div>
      <h3><?php echo $quote; ?></h3>
      <?php if ($image_caption != '') { ?>
        <div class="image-caption"><?php echo $image_caption; ?></div>
      <?php } ?>
    </div>
  <?php /* --------- */ ?>

  </div>

  <?php if ($content || $cta) { ?>
  <?php /* Hide on mobile */ ?>
    <div class="cta-wrapper hide-on-mobile">
      <?php if ($content) { ?>
        <div class="content"><?php echo $content; ?></div>
      <?php } ?>

      <?php if ($cta) { ?>
        <a href="<?php echo $cta['url']; ?>" target="<?php echo $cta['target']; ?>">
          <button class="<?php echo $button_light; ?>"><?php echo $cta['title']; ?></button>
        </a>
      <?php } ?>
    </div>
  <?php /* --------- */ ?>
  <?php } ?>

</div>