<?php

$intro = get_field('page_intro');
$map_id = get_field('map_id');

?>

<div class="page-intro align-center color-combo-color4">

  <h2>Contact Us</h2>

  <?php if ($intro) { ?>
    <div class="page-intro-intro"><?php echo $intro; ?></div>
  <?php } ?>
    
  <?php get_template_part('parts/shared/contact-details'); ?>

</div>

<div class="contact-content-container">
  <?php echo the_content(); ?>
</div>

<?php

$address = get_field('address', 'options');

if ($map_id) { ?>
<div class="contact-section-map">
  <?php echo do_shortcode('[torque_map map_id="' . $map_id . '"]'); ?>
</div>
<?php } ?>