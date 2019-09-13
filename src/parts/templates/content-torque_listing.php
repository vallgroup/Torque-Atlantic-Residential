<?php

$content = get_the_content();
$key_details = get_field( 'key_details' );
$cta = get_field( 'cta' );
$gallery_images = get_field( 'property_gallery' );

?>

<div class="listing-content-wrapper">

  <div class="listing-content-details" >

    <?php /* Details/Keys/Values Section */ ?>

    <?php if( have_rows('key_details') ): ?>
      <ul class="key-details-wrapper">

      <?php while ( have_rows('key_details') ) : the_row();
        $sub_field_name = get_sub_field('key');
        $sub_field_value = get_sub_field('value');
        
        $price_search_values = array( "PRICE", "ASKING PRICE", "COST" );
        $size_search_values = array( "LOT SIZE", "BUILDING SIZE" );

        // Check and modify price field(s)
        if ( in_array(strtoupper($sub_field_name), $price_search_values) ) {
		      if (ctype_alpha(str_replace(' ', '', $sub_field_value)) === false) {
            // First, remove any unwanted characters entered by the user
            $illegal_chars = array( ",", ".", "$", " ", "-", "+", "&", "(", ")" );
            $sub_field_value = str_replace( $illegal_chars, "", $sub_field_value );
            // Second, format the number as required
            $sub_field_value = "$" . number_format( trim( $sub_field_value ) );
          }
        }

        // Check and modify size/area field(s)
        if ( in_array(strtoupper($sub_field_name), $size_search_values) ) {
          // First, remove any unwanted characters entered by the user
          $illegal_chars = array( ",", "SF", ".", "SQUARE FEET", " " );
          $sub_field_value = str_replace( $illegal_chars, "", strtoupper($sub_field_value) );
          // Second, format the number as required
          $sub_field_value = number_format( trim( $sub_field_value ) ) . " SF";
        } ?>
        <li class="key-detail" >
          <span class="key-detail-name"><?php echo $sub_field_name ? $sub_field_name . ":" : ""; ?></span>
          <span class="key-detail-value"><?php echo $sub_field_value; ?></span>
        </li>
      <?php endwhile ?>

      </ul>
    <?php endif; ?>

    <?php /* Content Section */ ?>

    <?php if ($content) { ?>
      <div class="the-content" >
        <?php echo $content; ?>
      </div>
    <?php } ?>

    <?php /* CTA Section */ ?>

    <?php if ($cta && $cta['url'] != '') { ?>
      <div class="cta-wrapper" >
        <a href="<?php echo $cta['url']; ?>" target="<?php echo $cta['target']; ?>">
          <button class=""><?php echo $cta['title']; ?></button>
        </a>
      </div>
    <?php } ?>

  </div>

</div>

<div class="listing-extra-modules-wrapper">

  <?php /* Gallery Section */ ?>

  <?php if ($gallery_images) { ?>
    <div class="gallery-wrapper" >
      <?php include( locate_template( '/parts/acf/modules/gallery-grid_property.php', false, false ) ); ?>
    </div>
  <?php } ?>
  
  <?php /* Extra Modules Section -- Re-uses the ACF modules template/switch */ ?>
  <?php get_template_part('/parts/acf/modules'); ?>
</div>