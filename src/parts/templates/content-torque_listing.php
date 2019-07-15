<?php

$content = get_the_content();
$key_details = get_field( 'key_details' );
$cta = get_field( 'cta' );
$images = get_field('gallery');

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

        if ( in_array(strtoupper($sub_field_name), $price_search_values) ) {
          // First, remove any unwanted characters entered by the user
          $illegal_chars = array( ",", ".", "$", " " );
          $sub_field_value = str_replace( $illegal_chars, "", $sub_field_value );
          // Second, format the number as required
          $sub_field_value = "$" . number_format( trim( $sub_field_value ) );
        } 
        
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

    <?php if ($cta) { ?>
      <div class="cta-wrapper" >
        <a href="<?php echo $cta['url']; ?>" target="<?php echo $cta['target']; ?>">
          <button class=""><?php echo $cta['title']; ?></button>
        </a>
      </div>
    <?php } ?>

  </div>

  <?php /* Gallery Section */ ?>

  <?php if ($images): ?>
  <div class="image-gallery-section-container">
      <div class="image-wrapper">
      <?php foreach( $images as $image ): ?>
          <div class="image-item">
              <img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" />
          </div>
      <?php endforeach; ?>
      </div>
  </div>
  <?php endif; ?>



</div>
