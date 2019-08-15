<?php

$tagline = get_field('tagline');
$heading = get_field('heading');
$intro = get_field('intro');

?>

<div class="listings-title-wrapper" >
  <?php if ($tagline) { ?>
    <h5><?php echo $tagline; ?></h5>
  <?php } ?>
  <?php if ($heading) { ?>
    <h1><?php echo $heading; ?></h1>
  <?php } ?>
  <?php if ($intro) { ?>
    <div class="listings-intro"><?php echo $intro; ?></div>
  <?php } ?>
  
  <div class="search-form-search-wrapper">
    <?php get_search_form(); ?>
  </div>
</div>
