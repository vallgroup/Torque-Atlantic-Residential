<?php

require_once( get_template_directory() . '/includes/load-more/load-more-loop.php');

$available_listings_loop = new Torque_Load_More_Loop(
  'available-listings',
  6,
  array(
    'post_type' => Interra_Listing_CPT::$listing_labels['post_type_name'],
    'meta_query' => array(
      'relation' => 'AND',
      array(
        'key' => 'listing_brokers',
        'value' => $user->ID,
        'compare' => 'LIKE'
      ),
      array(
        'key' => 'listing_status',
        'value' => 'available',
        'compare' => 'LIKE'
      )
    )
  ),
  'parts/shared/loop-listing.php'
);

$closed_listings_loop = new Torque_Load_More_Loop(
  'closed-listings',
  6,
  array(
    'post_type' => Interra_Listing_CPT::$listing_labels['post_type_name'],
    'meta_query' => array(
      'relation' => 'AND',
      array(
        'key' => 'listing_brokers',
        'value' => $user->ID,
        'compare' => 'LIKE'
      ),
      array(
        'key' => 'listing_status',
        'value' => 'closed',
        'compare' => 'LIKE'
      )
    )
  ),
  'parts/shared/loop-listing.php'
);

$blog_posts_loop = new Torque_Load_More_Loop(
  'blog-posts',
  6,
  array(
    'post_type' => 'post',
    'meta_query' => array(
      'relation' => 'AND',
      array(
        'key' => 'post_authors',
        'value' => $user->ID,
        'compare' => 'LIKE'
      ),
    )
  ),
  'parts/shared/loop-blog.php'
);


Torque_Load_More::get_inst()->register_loop( $available_listings_loop );
Torque_Load_More::get_inst()->register_loop( $closed_listings_loop );
Torque_Load_More::get_inst()->register_loop( $blog_posts_loop );


/*
Set up other staff vars
 */

$first_name = $user->first_name;

?>

<?php if ($available_listings_loop->has_first_page()) { ?>

<div class="listings-wrapper active-listings" >
	<h2><?php echo $first_name."'s"; ?> Active Listings</h2>

	<?php $available_listings_loop->the_first_page(); ?>
</div>

<?php } ?>


<?php if ($closed_listings_loop->has_first_page()) { ?>

<div class="listings-wrapper closed-listings" >
	<h2><?php echo $first_name."'s"; ?> Recently Closed Deals</h2>

	<?php $closed_listings_loop->the_first_page(); ?>
</div>

<?php } ?>


<?php if ($user && $blog_posts_loop->has_first_page()) { ?>

<div class="listings-wrapper blog-posts" >
	<h2>Blog Posts featuring <?php echo $first_name; ?></h2>

	<?php $blog_posts_loop->the_first_page(); ?>
</div>

<?php } ?>
