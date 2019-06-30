<?php

$listing_status_key = 'field_5c8ae924ce1a3';
$term_ids = get_sub_field('regions');

if ($term_ids) {
  $terms = get_terms( array(
      'taxonomy'   => $taxonomy,
      'hide_empty' => false,
      'include'    => $term_ids
  ) );
} else {
  $terms = [];
}

/**
 * Get a random 'torque_listing' post, then its ID.
 * Then use the ID to get ACF listing_status key value (req. post ID)
 * ID not important, as we're only looking for the key value, not the actual ACF value
 */
$args = array( 
  'orderby' => 'rand',
  'posts_per_page' => '1', 
  'post_type' => 'torque_listing'
);
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();
  $listing_post_id = get_the_ID();
  $listing_status_key = get_field_object('listing_status', $listing_post_id);
  $listing_status_key = $listing_status_key['key'];
endwhile;

if (count($terms)) {

?>

<div class="quick-search taxonomy-<?php echo $taxonomy; ?>" >

  <h2>Quick Search</h2>

<?php foreach ($terms as $term) {

  $image = get_field('region_featured_image', $term);
  /* 'field_5c8ae924ce1a3' is the field key for 'listing_status' */
  ?>
  <a class="quick-search-term-wrapper" href="/listings?<?php echo $taxonomy.'='.$term->term_id; ?>&<?php echo $listing_status_key; ?>=available" >
    <div class="quick-search-term" style="background-image: url('<?php echo $image; ?>')">
      <div class="term-name"><?php echo $term->name; ?></div>

      <div class="overlay"></div>
    </div>
  </a>

<?php } ?>

</div>

<?php } ?>
