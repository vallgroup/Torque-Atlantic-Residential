<?php
/**
 * This template is used by the 'Load More' functionality (/torque-theme/includes/load-more/).
 * This helper currently doesn't play ball with 'echo get_the_permalink();' embedded in HTML, therefore all instances of the permalink have been wrapped in PHP and echo'd in their entirety...
 */
?>
<div class="loop-post loop-listing">
  <?php echo '<a href="' . get_the_permalink() . '">'; ?>
    <div class="featured-image-wrapper">
      <div
        class="featured-image"
        style="background-image: url('<?php echo get_the_post_thumbnail_url(null, 'large'); ?>')"
      ></div>
    </div>
  <?php echo '</a>'; ?>

  <div class="content-wrapper">
    <?php echo '<a href="' . get_the_permalink() . '">'; ?>
      <h4><?php echo get_the_title(); ?></h4>
    <?php echo '</a>'; ?>

    <div class="excerpt" >
      <?php echo get_the_excerpt(); ?>
    </div>

    <?php echo '<a href="' . get_the_permalink() . '">'; ?>
      <button>Learn More</button>
    <?php echo '</a>'; ?>
  </div>
</div>
