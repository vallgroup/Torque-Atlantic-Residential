<?php

$modules = 'modules';

if ( have_rows( $modules ) ):

  while ( have_rows( $modules ) ) : the_row();

    switch ( get_row_layout() ) {

      case 'content_section_one' :

        $align = get_sub_field( 'align' );
        $image = get_sub_field('image');
        $heading = get_sub_field( 'heading' );
        $content = get_sub_field( 'content' );
        $cta = get_sub_field('cta');
        $top_bottom_padding = get_sub_field('top_bottom_padding') == 'yes' ? 'top-bottom-padding' : '';

        include locate_template('/parts/acf/modules/content-section_one.php');

        break;

      case 'content_section_two' :
  
        $align = get_sub_field( 'align' );
        $color_combo = get_sub_field('color_combo');
        $heading = get_sub_field( 'heading' );
        $content = get_sub_field( 'content' );
        $bottom_padding = get_sub_field( 'bottom_padding' );

        include locate_template('/parts/acf/modules/content-section_two.php');

        break;

      case 'content_section_three' :
  
        $align = get_sub_field( 'align' );
        $background_color = get_sub_field('background_color');
        $image = get_sub_field('image');
        $quote = get_sub_field( 'quote' );
        $content = get_sub_field( 'content' );
        $cta = get_sub_field('cta');
        $button_light = $background_color == 'green' ? 'light' : '';

        include locate_template('/parts/acf/modules/content-section_three.php');

        break;

      case 'cta_section' :

        $heading = get_sub_field( 'heading' );
        $content = get_sub_field( 'content' );
        $cta = get_sub_field('cta');
        $align_background_graphic = get_sub_field('align_background_graphic');

        include locate_template('/parts/acf/modules/cta-section.php');

        break;

      case 'image_gallery' :

        $images = get_sub_field('images');

        include locate_template('/parts/acf/modules/image_gallery.php');

        break;

      case 'video' :

        $video = get_sub_field('video_src');

        include locate_template('/parts/acf/modules/video.php');

        break;

      case 'post_slideshow' :

        $slideshow_id = get_sub_field('slideshow_id');

        echo do_shortcode('[torque_slideshow id="'.$slideshow_id.'" type="post" template="atlantic-residential"]');

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
