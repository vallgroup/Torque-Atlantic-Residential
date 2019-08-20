<?php
/**
 * Used to display all Properties of a given type, based on page slug/url
 */
?>

<div class="properties-gallery-grid-wrapper">

  <?php include locate_template('/parts/acf/modules/gallery-grid_properties.php'); ?>

</div>


<div class="properties-info-wrapper">

  <?php 
  $heading = get_field( 'info_heading' );
  $content = get_field( 'info_content' );
  $left_list = have_rows('left_list');
  $right_list = have_rows('right_list');
  if ($heading) {
    include locate_template('/parts/acf/modules/info-section.php'); 
  } 
  ?>

</div>


<div class="properties-cta-grid-wrapper">

  <?php 
  $heading = get_field( 'cta_heading' );
  $content = get_field( 'cta_content' );
  $cta = get_field('cta_link');
  $align_background_graphic = get_field('cta_align_background_graphic');
  if ($cta) {
    include locate_template('/parts/acf/modules/cta-section.php'); 
  } 
  ?>

</div>

<?php

