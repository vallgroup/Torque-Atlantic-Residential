<?php

/**
 * Header Template 1:
 *
 * Logo - Burger menu with mobile opening from top of screen (mobile & tablet)
 * Logo - Menu items inline (desktop)
 *
 *
 * Note: styles for this which require a media query
 * can be found in the child theme boilerplate.
 */

// Style the header based on the 
$header_light_dark = get_field('light_or_dark_header') === 'light' ? 'light' : 'dark';

// $logo_light_dark = get_field('light_or_dark_header') === 'light' ? 'white' : 'dark';

$extra_classes = isset($tq_header_style_1_classes) ? $tq_header_style_1_classes : '';

if ( isset($enforce_dark_header) && $enforce_dark_header || is_search() ) {
  $header_light_dark = 'dark';
  $logo_light_dark = 'dark';
}

?>

<header
  id="header-style-1"
  class="torque-header <?php echo $extra_classes; ?> header-<?php echo $header_light_dark; ?>">

  <div class="row torque-header-content-wrapper torque-navigation-toggle">

    <div class="col2 col2-tablet col2-desktop torque-header-logo-wrapper">
      <?php // get_template_part( 'parts/shared/logo', $logo_light_dark); ?>
      <?php get_template_part( 'parts/shared/logo', 'dark'); ?>
      <?php get_template_part( 'parts/shared/logo', 'white'); ?>
    </div>

    <div class="col2 col2-tablet col2-desktop torque-header-burger-menu-wrapper">
      <?php get_template_part( 'parts/elements/element', 'burger-menu-squeeze'); ?>
    </div>

  </div>

  <div class="col1 torque-navigation-toggle torque-header-menu-items-mobile">
    <svg class="diagonal-top" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none" shape-rendering="geometricPrecision">
      <polygon points="0,100 50,0 100,0 100,100"/>
    </svg>
    <?php get_template_part( 'parts/shared/header-parts/menu-items/menu-items', 'stacked'); ?>
    <svg class="diagonal-bottom" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none" shape-rendering="geometricPrecision">
      <polygon points="0,0 100,0 100,100"/>
    </svg>
  </div>

</header>
