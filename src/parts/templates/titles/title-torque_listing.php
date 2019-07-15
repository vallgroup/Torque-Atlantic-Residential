<?php

$image_src = get_the_post_thumbnail_url( null, 'large');
$logo_src = get_field( 'logo' );
$title = get_the_title();

?>

<div class="page-hero type-image content-position-top align-center height-half">
  <div class="hero-image-size">
    <div class="hero-image" style="background-image: url(<?php echo $image_src; ?>);" ></div>
  </div>
</div>

<div class="listing-title-wrapper" >
  <?php if ($logo_src) { ?>
    <img class="property-logo" src="<?php echo $logo_src; ?>"/>
  <? } else { ?>
    <h2><?php the_title(); ?></h2>
  <?php } ?>
</div>
