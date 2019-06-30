<?php

if ( class_exists( 'Interra_Listing_CPT' ) ) {
  $shortcode = '[torque_filtered_loop ';
  $shortcode .= 'post_type="'.Interra_Listing_CPT::$listing_labels['post_type_name'].'" ';
  $shortcode .= 'posts_per_page="12" ';
  $shortcode .= 'filters_types="tabs_acf,dropdown_tax,dropdown_tax" ';
  $shortcode .= 'filters_args="field_5c8ae924ce1a3,'.Interra_Listing_CPT::$LISTING_PROPERTY_TYPE_TAX_SLUG.','.Interra_Listing_CPT::$LISTING_REGION_TAX_SLUG.'"';
  $shortcode .= ']';

  echo do_shortcode($shortcode);
} else {
  echo 'Listing CPT not found, contact site admin';
}



?>
