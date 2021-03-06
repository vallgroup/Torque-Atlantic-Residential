<?php

$image_src = get_the_post_thumbnail_url( null, 'property_header');
$logo_src = get_field( 'logo' );
$title = get_the_title();

?>

<div class="listing-title-wrapper hide-on-desktop" >
  <?php if ($logo_src) { ?>
    <img class="property-logo" src="<?php echo $logo_src; ?>"/>
  <? } else { ?>
    <h2><?php the_title(); ?></h2>
  <?php } ?>
</div>

<div class="page-hero type-image content-position-top align-center height-half">
  <div class="hero-image-size">
    <div class="hero-image" style="background-image: url(<?php echo $image_src; ?>);" ></div>
  </div>
</div>

<div class="listing-title-wrapper hide-on-tablet hide-on-mobile" >
  <?php if ($logo_src) { ?>
    <img class="property-logo" src="<?php echo $logo_src; ?>"/>
  <? } else { ?>
    <h2><?php the_title(); ?></h2>
  <?php } ?>
</div>
