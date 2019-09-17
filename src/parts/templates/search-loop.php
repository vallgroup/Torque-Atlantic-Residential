<div class="search-loop">
  <div class="search-result-content-wrapper hide-on-desktop">
    <a class="" href=<?php echo the_permalink(); ?>>
      <h3><?php echo the_title(); ?></h3>
    </a>
  </div>
  <div class="search-result-image-wrapper hide-on-desktop">
    <a href=<?php echo the_permalink(); ?>>
      <?php echo the_post_thumbnail( 'medium' ); ?>
    </a>
  </div>
  <div class="search-result-image-wrapper hide-on-tablet hide-on-mobile">
    <a href=<?php echo the_permalink(); ?>>
      <?php echo the_post_thumbnail( 'medium' ); ?>
    </a>
  </div>
  <div class="search-result-content-wrapper">
    <a class="hide-on-tablet hide-on-mobile" href=<?php echo the_permalink(); ?>>
      <h3><?php echo the_title(); ?></h3>
    </a>
    <div class="excerpt" ><?php echo the_excerpt(); ?></div>
  </div>
</div>
