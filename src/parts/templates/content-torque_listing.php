<?php

$content = get_the_content();
$highlights = get_field( 'listing_highlights' );

?>

<div class="torque-listing-content">

  <div class="torque-listing-content-details" >
    <?php if ($content) { ?>
      <h4>Property Overview</h4>
      <div class="the-content" >
        <?php echo $content; ?>
      </div>
    <?php } ?>

    <?php if ($highlights) { ?>
      <h4>Highlights</h4>
      <div class="highlights" >
        <?php echo $highlights; ?>
      </div>
    <?php } ?>

    <?php if( have_rows('key_details') ): ?>
      <h4>Key Details</h4>
      <div class="key-details-wrapper">

      <?php while ( have_rows('key_details') ) : the_row();
        $sub_field_name = get_sub_field('name');
        $sub_field_value = get_sub_field('value');
        
        $geo_search_values = array( "LATITUDE", "LONGITUDE" );
        $price_search_values = array( "PRICE", "ASKING PRICE" );
        $size_search_values = array( "LOT SIZE", "BUILDING SIZE" );

        /* Skip over Latitude & Longitude ACF keys, as they are no currently required by the client */
        if ( in_array(strtoupper($sub_field_name), $geo_search_values) ) {
          continue;
        }

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
        }?>
        <div class="key-detail" >
          <div class="key-detail-name">
            <?php echo $sub_field_name; ?>
          </div>
          <div class="key-detail-value">
            <?php echo $sub_field_value; ?>
          </div>
        </div>
      <?php endwhile ?>

      </div>
    <?php endif; ?>

  </div>

  <div class="torque-listing-content-brokers">
    <?php

    $users = get_field('listing_brokers');

    if( $users ): ?>
    	<div class="brokers-wrapper">
        <h4 class="brokers-section-title">Brokers</h4>
    	<?php foreach( $users as $user ): // variable must NOT be called $post (IMPORTANT)

        $title = $user->data->display_name;
        $permalink = get_author_posts_url( $user->ID );
        $thumbnail = get_field( 'featured_image', 'user_'.$user->ID );
        if (!$thumbnail) $thumbnail = get_avatar_url( $user->ID, array( 'size' => 400 ) );
        $tel = get_field( 'telephone', 'user_'.$user->ID );
        $email = $user->user_email;

        ?>

    	    <div class="broker">
            <a class="broker-image-container" href="<?php echo $permalink; ?>">
              <img class="broker-image" src="<?php echo $thumbnail; ?>" />
            </a>

            <div class="broker-content" >
              <a href="<?php echo $permalink; ?>">
      	    	  <h4><?php echo $title; ?></h4>
              </a>


              <div class="meet-broker" >
                <a href="<?php echo $permalink; ?>">
                  Meet <?php echo $user->first_name; ?>
                </a>
              </div>


              <?php if ($email) { ?>
                <a href="mailto:<?php echo $email; ?>" >
                  <div class="broker-icon envelope"></div>
                </a>
              <?php } ?>

              <?php if ($tel) { ?>
                <a href="tel:<?php echo $tel; ?>" >
                  <div class="broker-icon phone"></div>
                </a>
              <?php } ?>
            </div>
    	    </div>
    	<?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

</div>
