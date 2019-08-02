<div class="content-section-three align-<?php echo $align; ?> background-<?php echo $background_color; ?>">

  <div class="content-container">
    <div class="content-section-image-size">
      <div class="content-section-image" style="background-image: url(<?php echo $image; ?>);" ></div>
    </div>

    <div class="content-wrapper" >
      <div class="bg-quotation-mark-top"></div>
      <div class="bg-quotation-mark-bottom"></div>
      <h3><?php echo $quote; ?></h3>
    </div>
  </div>
  
  <?php if ($content || $cta) { ?>
  <div class="cta-wrapper" >
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

</div>
