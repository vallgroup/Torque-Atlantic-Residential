<?php
/**
 * Used to display all Properties of a given type, based on page slug/url
 */

global $post;
$post_slug = $post->post_name;

if ( class_exists( 'Torque_Load_More_Loop' ) ) {
  
  $property_post_loop = new Torque_Load_More_Loop(
    'torque_listing',
    10,
    array(
      'post_type' 		=> 'torque_listing',
      'post_status'		=> 'publish',
      'tax_query' => array(
          array (
              'taxonomy' => 'atlantic_listing_property_type',
              'field' => 'slug',
              'terms' => $post_slug,
          )
      ),
    ),
    'parts/shared/loop-listing.php'
  );

  Torque_Load_More::get_inst()->register_loop( $property_post_loop );

  if ( $property_post_loop->has_first_page() ) { ?>
  <div class="loop-listings-wrapper">
    <?php $property_post_loop->the_first_page(); ?>
  </div>
  <?php } else {
    echo 'Property category not found. Please ensure your page title and slug is identical to the Property Type category name and slug.';
  }

}
?>
