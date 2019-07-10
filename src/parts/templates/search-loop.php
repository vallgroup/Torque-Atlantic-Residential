<div class="search-loop">
  <div class="search-result-image-wrapper">
    <a href=<?php echo the_permalink(); ?>>
      <?php echo the_post_thumbnail( 'thumbnail' ); ?>
    </a>
  </div>
  <div class="search-result-content-wrapper">
    <a href=<?php echo the_permalink(); ?>>
      <h3><?php echo the_title(); ?></h3>
    </a>
    <div class="excerpt" ><?php echo the_excerpt(); ?></div>
  </div>
</div>
