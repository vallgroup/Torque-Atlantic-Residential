<?php
/**
 * Used to display all Properties of a given type, based on page slug/url
 */
?>

<div class="properties-gallery-grid-wrapper">

  <?php include locate_template('/parts/acf/modules/gallery-grid_properties.php'); ?>

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

