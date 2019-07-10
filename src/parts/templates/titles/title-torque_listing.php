<?php

$feature_img_src = get_field('listing_image');

?>

<div class="torque_listing-title" >
  <div class="listing-title-content" >
    <h2><?php the_title(); ?></h2>
  </div>
  <div class="featured-image-size" >
    <div class="featured-image" style="background-image: url('<?php echo get_the_post_thumbnail_url( null, 'large'); ?>')" ></div>
  </div>
</div>
