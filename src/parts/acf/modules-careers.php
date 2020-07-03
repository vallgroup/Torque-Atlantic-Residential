<?php

$modules = 'career_modules';

if ( have_rows( $modules ) ):

  while ( have_rows( $modules ) ) : the_row();

    switch ( get_row_layout() ) {

      case 'content_section_one' :

        $align = get_sub_field( 'align' );
        $image = get_sub_field('image');
        $image_url = null !== $image ? $image['url'] : null;
        $image_caption = null !== $image ? $image['caption'] : null;
        $image_background_size = get_sub_field('image_background_size');
        $heading = get_sub_field( 'heading' );
        $content = get_sub_field( 'content' );
        $cta = get_sub_field('cta');
        $top_bottom_padding = get_sub_field('top_bottom_padding') == 'yes' ? 'top-bottom-padding' : '';
        $reduced_height = get_sub_field('reduced_height') == 'yes' ? 'reduced-height' : '';

        include locate_template('/parts/acf/modules/content-section_one.php');

        break;

      case 'list_careers_simple' :

        $number_of_careers = get_sub_field( 'number_of_careers' );

        include locate_template('/parts/acf/modules/careers-list-simple.php');

        break;

      case 'careers_form' :

        get_template_part( 'parts/forms/form', 'careers' );

        break;

    }

  endwhile;
endif;

?>
