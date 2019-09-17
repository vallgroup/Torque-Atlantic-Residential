<?php
/**
 * Used to render all properties from a given category, in a pre-defined masonry grid layout
 */

// Define the grid sections, based on pre-defined designs provided by client
$grid_sections = array(
  array(
    'num_rows'        => '1',
    'num_items'       => 1,
    'items'           => array(
      array(
        'column_start'  => '0',
        'column_end'    => '4',
        'row_start'     => '0',
        'row_end'       => '1',
      ),
    ),
  ),
  array(
    'num_rows'        => '2',
    'num_items'       => 4,
    'items'           => array(
      array(
        'column_start'  => '0',
        'column_end'    => '8',
        'row_start'     => '0',
        'row_end'       => '1',
      ),
      array(
        'column_start'  => '8',
        'column_end'    => '12',
        'row_start'     => '0',
        'row_end'       => '2',
      ),
      array(
        'column_start'  => '0',
        'column_end'    => '4',
        'row_start'     => '1',
        'row_end'       => '2',
      ),
      array(
        'column_start'  => '4',
        'column_end'    => '8',
        'row_start'     => '1',
        'row_end'       => '2',
      ),
    ),
  ),
  array(
    'num_rows'        => '2',
    'num_items'       => 2,
    'items'           => array(
      array(
        'column_start'  => '0',
        'column_end'    => '4',
        'row_start'     => '0',
        'row_end'       => '2',
      ),
      array(
        'column_start'  => '4',
        'column_end'    => '12',
        'row_start'     => '0',
        'row_end'       => '2',
      ),
    ),
  ),
  array(
    'num_rows'        => '2',
    'num_items'       => 4,
    'items'           => array(
      array(
        'column_start'  => '0',
        'column_end'    => '8',
        'row_start'     => '0',
        'row_end'       => '1',
      ),
      array(
        'column_start'  => '8',
        'column_end'    => '12',
        'row_start'     => '0',
        'row_end'       => '1',
      ),
      array(
        'column_start'  => '0',
        'column_end'    => '4',
        'row_start'     => '1',
        'row_end'       => '2',
      ),
      array(
        'column_start'  => '4',
        'column_end'    => '12',
        'row_start'     => '1',
        'row_end'       => '2',
      ),
    ),
  ),
  array(
    'num_rows'        => '2',
    'num_items'       => 2,
    'items'           => array(
      array(
        'column_start'  => '0',
        'column_end'    => '8',
        'row_start'     => '0',
        'row_end'       => '2',
      ),
      array(
        'column_start'  => '8',
        'column_end'    => '12',
        'row_start'     => '0',
        'row_end'       => '2',
      ),
    ),
  ),
  array(
    'num_rows'        => '2',
    'num_items'       => 4,
    'items'           => array(
      array(
        'column_start'  => '0',
        'column_end'    => '4',
        'row_start'     => '0',
        'row_end'       => '2',
      ),
      array(
        'column_start'  => '4',
        'column_end'    => '12',
        'row_start'     => '0',
        'row_end'       => '1',
      ),
      array(
        'column_start'  => '4',
        'column_end'    => '8',
        'row_start'     => '1',
        'row_end'       => '2',
      ),
      array(
        'column_start'  => '8',
        'column_end'    => '12',
        'row_start'     => '1',
        'row_end'       => '2',
      ),
    ),
  ),
);

// Count grid sections. Used to loop back to the first grid section if we reach the maximum number of grid sections.
$grid_sections_count = count($grid_sections);

// Retreive the properties/posts, based on the page slug (communities or developments, at this stage)
global $post;
$post_slug = $post->post_name;
$args = array(
  'post_type' 		=> 'torque_listing',
  'post_status'		=> 'publish',
  'tax_query'     => array(
      array (
          'taxonomy' => 'atlantic_listing_property_type',
          'field' => 'slug',
          'terms' => $post_slug,
      )
  ),
  'posts_per_page' => '-1',
);
$properties = new WP_Query( $args );

// Count total number of properties in DB
$total_num_properties = $properties->found_posts;


// Loop through each post, and display in corresponding grid item (based on rows and items defined above)
if ( $properties->have_posts() ) {
  
  // Set initial vars
  $grid_section_index = 0;
  $property_section_index = 0;
  $total_properties_rendered = 0;

  while ( $properties->have_posts() ) {
    $properties->the_post();

    // Check if we're starting a new row. 
    if ( $property_section_index == 0 ) {
      // START A NEW GRID ROW ?>
    <div class="row gallery-module" >
      <div class="gallery-grid-root grid-rows-<?php echo $grid_sections[$grid_section_index]['num_rows']; ?>" >
    <?php }

    // Assign grid item vars
    $col_start = $grid_sections[$grid_section_index]['items'][$property_section_index]['column_start'];
    $col_end = $grid_sections[$grid_section_index]['items'][$property_section_index]['column_end'];
    $row_start = $grid_sections[$grid_section_index]['items'][$property_section_index]['row_start'];
    $row_end = $grid_sections[$grid_section_index]['items'][$property_section_index]['row_end'];
    $width = intval($col_end) - intval($col_start);
    $height = intval($row_end) - intval($row_start);
    // Get ACF data
    $city = get_field( 'city' );
    $state = get_field( 'state' );

    ?>

      <div class="
        grid-image
        grid-column-<?php echo $col_start; ?>-<?php echo $width; ?>
        grid-row-<?php echo $row_start; ?>-<?php echo $height; ?>
        grid-width-<?php echo $width; ?>
        grid-height-<?php echo $height; ?>
      ">
        <div class="grid-image-container" style="background-image: url('<?php echo get_the_post_thumbnail_url(null, 'large'); ?>')">
          <a href="<?php echo get_the_permalink(); ?>">
            <div class="caption-overlay">
              <div class="title"><?php echo get_the_title(); ?></div>
                <?php if ($city) {?>
                  <div class="location">
                    <span class="city"><?php echo $city; ?></span><?php if ($state) {?><span class="state"><?php echo ', ' . $state; ?></span><?php } ?>
                  </div>
                <?php } ?>
                
              <div class="cta">Learn More</div>
            </div>
          </a>
        </div>
      </div>

    <?php

    // Increment vars where required...

    // Increment total rendered properties counter
    $total_properties_rendered++;

    // if we've hit the max allowable items per current section, so increment the grid section counter and reset the property counter
    if ( $property_section_index >= (intval($grid_sections[$grid_section_index]['num_items']) - 1) ) {
      $grid_section_index++;
      $property_section_index = 0;

      // END THE GRID ROW ?>
      </div>
    </div>
    <?php 
    // check if we're rendered all available properties... 
    } elseif ( $total_properties_rendered >= $total_num_properties ) { 
      // if so, close the row container div!
      // END THE GRID ROW ?>
      </div>
    </div>
    <?php } else {
      $property_section_index++;
    }

    // if we've hit the maximum number of grid sections
    if ( $grid_section_index >= $grid_sections_count ) {
      // reset the grid section index, as we've filled out all the sections and need to start over again!
      $grid_section_index = 1; // Skip the first row, as it is designed to fit the title section therefore not required!
      $property_section_index = 0;
    }

  }
}
/* Restore original Post Data */
wp_reset_postdata();
