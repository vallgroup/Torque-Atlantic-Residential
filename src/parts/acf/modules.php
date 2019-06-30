<?php

$modules = 'modules';

if ( have_rows( $modules ) ):

  while ( have_rows( $modules ) ) : the_row();

    switch ( get_row_layout() ) {

      case 'content_section' :

        $align = get_sub_field( 'align' );
        $image = get_sub_field('image');
        $heading = get_sub_field( 'heading' );
        $content = get_sub_field( 'content' );
        $cta = get_sub_field('cta');

        include locate_template('/parts/acf/modules/content-section.php');

        break;

      case 'images' :

        $image_1 = get_sub_field('image_1');
        $image_2_start = get_sub_field('image_2_start');
        $image_2 = get_sub_field('image_2');

        include locate_template('/parts/acf/modules/images.php');

        break;

      case 'cta_section' :

        $heading = get_sub_field( 'heading' );
        $content = get_sub_field( 'content' );
        $cta = get_sub_field('cta');

        include locate_template('/parts/acf/modules/cta-section.php');

        break;

      case 'post_slideshow' :

        $slideshow_id = get_sub_field('slideshow_id');

        echo do_shortcode('[torque_slideshow id="'.$slideshow_id.'" type="post" template="atlantic-residential"]');

        break;

      case 'region_quick_search' :

        if ( class_exists( 'Atlantic_Residential_Listing_CPT' ) ) {
          $taxonomy = Atlantic_Residential_Listing_CPT::$LISTING_REGION_TAX_SLUG;

          include locate_template('/parts/acf/modules/quick-search.php');
        }

        break;

      case 'staff_members' :

        include locate_template('/parts/acf/modules/staff-members.php');

        break;

      case 'mailchimp_form' :

        include locate_template('/parts/acf/modules/mailchimp-form.php');

        break;

    }

  endwhile;
endif;

?>
