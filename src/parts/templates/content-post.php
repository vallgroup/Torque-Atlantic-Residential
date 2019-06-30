<?php

$authors = get_field('post_authors');
if ($authors && count($authors)) {
  $author_objs = get_users(array(
  	'include'      => $authors,
  ) );
}

$terms = get_the_terms( get_the_ID(), 'category' );
$term_ids = array_map( function($term) { return $term->term_id; }, $terms);

$keep_reading_query = new WP_Query( array(
  'posts_per_page'    => 3,
  'post__not_in'      => [get_the_ID()],
  'category__in'      => $term_ids
) );

?>

<div class="post-main" >
  <div class="post-content">
    <div class="post-title" >
      <h2><?php the_title(); ?></h2>

      <?php if (isset($author_objs) && $author_objs && count($author_objs)) { ?>
        <div class="post-terms authors" >

          <?php foreach ($author_objs as $author) { ?>
            <div class="post-term" >
              <a href="<?php echo get_author_posts_url( $author->ID ); ?>">
                <?php echo $author->display_name; ?>
              </a>
            </div>
          <?php } ?>

        </div>
      <?php } ?>

      <?php if (count($terms)) { ?>
        <div class="post-terms" >

          <?php foreach ($terms as $term) { ?>
            <div class="post-term" >
              <a href="/blog?<?php echo $term->taxonomy; ?>=<?php echo $term->term_id; ?>">
                <?php echo $term->name; ?>
              </a>
            </div>
          <?php } ?>

        </div>
      <?php } ?>
    </div>

    <div class="the-content" >
      <?php the_content(); ?>
    </div>

    <?php get_template_part('/parts/elements/pagination/pagination-buttons-single'); ?>
  </div>

  <?php  if ( $keep_reading_query->have_posts() ) { ?>
    <div class="post-keep-reading" >
      <h3>Keep Reading</h3>

    <?php while ( $keep_reading_query->have_posts() ) { $keep_reading_query->the_post();
      get_template_part('parts/shared/loop-blog');
    } ?>
    </div>

  <?php
  wp_reset_postdata();
  } ?>
</div>
