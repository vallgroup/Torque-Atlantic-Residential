<?php

$alignment = get_field('page_intro_alignment');
$color_combo = get_field('page_intro_color');
$heading = get_field('page_heading');
$intro = get_field('page_intro');

?>

<div class="page-intro align-<?php echo $alignment; ?> color-combo-<?php echo $color_combo; ?>">

  <?php if ($heading) { ?>
    <h2><?php echo $heading; ?></h2>
  <?php } ?>

  <?php if ($intro) { ?>
    <div class="page-intro-intro"><?php echo $intro; ?></div>
  <?php } ?>
</div>
