<?php

$intro = get_field('page_intro');

?>

<div class="page-intro align-center color-combo-color4">

  <h2>Contact Us</h2>

  <?php if ($intro) { ?>
    <div class="page-intro-intro"><?php echo $intro; ?></div>
  <?php } ?>
    
  <?php get_template_part('parts/shared/contact-details'); ?>

</div>

<?php echo the_content(); ?>

<?php

$address = get_field('address', 'options');

if ($address) { ?>
<div class="contact-section-map">
  map goes here....
</div>
<?php } ?>