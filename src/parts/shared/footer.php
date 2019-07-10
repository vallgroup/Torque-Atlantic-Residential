<?php

$menu_items = Torque_Nav_Menus::get_nav_menu_items_by_location( 'footer' );

$copyright = get_field('copyright', 'options');

?>

<footer>

  <div class="footer-block footer-logo">
    <?php get_template_part( 'parts/shared/logo', 'white'); ?>
  </div>

  <div class="footer-block footer-contact-details">
    <?php get_template_part( 'parts/shared/contact-details' ); ?>
  </div>

  <div class="footer-block footer-menu">
    <?php include locate_template('/parts/shared/header-parts/menu-items/menu-items-stacked.php'); ?>
  </div>

<div class="footer-block footer-social-icons">
  <div class="footer-block-title">Connect</div>
    <?php get_template_part( 'parts/shared/social-icons' ); ?>
</div>

  <?php if ($copyright) { ?>
    <div class="footer-copyright">
      <?php echo $copyright; ?>
    </div>
  <?php } ?>

</footer>
