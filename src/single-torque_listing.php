<?php TQ::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<main>
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'parts/templates/titles/title', 'torque_listing' ); ?>

		<?php get_template_part( 'parts/templates/content', 'torque_listing' ); ?>

	<?php endwhile; ?>
</main>

<?php TQ::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
