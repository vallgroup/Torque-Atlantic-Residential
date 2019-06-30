<div
  class="cta-section">

  <h2><?php echo $heading; ?></h2>

  <?php if ($content) { ?>
    <div class="content"><?php echo $content; ?></div>
  <?php } ?>

  <?php if ($cta) {
    // having one for mobile and one for tablet/desktop was the cleanest way to reuse styles?>
    <div class="cta-wrapper" >
      <a href="<?php echo $cta['url']; ?>" target="<?php echo $cta['target']; ?>">
        <button><?php echo $cta['title']; ?></button>
      </a>
    </div>
    <div class="cta-wrapper" >
      <a href="<?php echo $cta['url']; ?>" target="<?php echo $cta['target']; ?>">
        <button class="white"><?php echo $cta['title']; ?></button>
      </a>
    </div>
  <?php } ?>

</div>
