<div class="cta-section-container">

  <div class="cta-section align-background-graphic-<?php echo $align_background_graphic; ?>">

    <h3><?php echo $heading; ?></h3>

    <?php if ($content) { ?>
      <div class="content"><?php echo $content; ?></div>
    <?php } ?>

    <?php if ($cta) { ?>
      <div class="cta-wrapper">
        <a href="<?php echo $cta['url']; ?>" target="<?php echo $cta['target']; ?>">
          <button class="light"><?php echo $cta['title']; ?></button>
        </a>
      </div>
    <?php } ?>

  </div>

</div>