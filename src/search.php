<?php
/**
 * Displays the search results
 */
?>
<?php TQ::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<main id="search">

  <?php get_template_part( 'parts/templates/titles/title', 'search' ); ?>

  <div class="search-loop-wrapper">
    <div class="search-loop-inner">
    	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'parts/templates/search', 'loop' ); ?>

    	<?php endwhile; ?>
    </div>

    <?php get_template_part( 'parts/elements/pagination/pagination', 'buttons' ); ?>
  </div>

</main>

<?php TQ::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
