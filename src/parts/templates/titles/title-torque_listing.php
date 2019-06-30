<?php

$availability = get_field('listing_status');

$image_type = get_field('listing_image');

?>

<div class="torque_listing-title" >
  <div class="listing-title-content" >
    <div class="back-link">
      <a class="back-to-listings-btn" href="/listings">
        < Back To Listings
      </a>
    </div>

    <div class="the-terms">
      <div class="availability">
        <?php echo $availability; ?>
      </div>

      <?php include locate_template('parts/shared/terms-listing.php'); ?>
    </div>

    <h2><?php the_title(); ?></h2>
  </div>

  <?php if ($image_type === 'slideshow') {
    echo do_shortcode('[torque_slideshow id="'.get_field('listing_slideshow').'"]');
  } else { ?>
    <div class="featured-image-size" >
      <div class="featured-image" style="background-image: url('<?php echo get_the_post_thumbnail_url( null, 'large'); ?>')" ></div>
    </div>
  <?php } ?>
</div>
