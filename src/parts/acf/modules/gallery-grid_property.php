<?php
/**
 * Used to render all properties from a given category, in a pre-defined masonry grid layout
 */

// Define the grid sections, based on pre-defined designs provided by client
$grid_sections = array(
  array(
    'num_rows'        => '1',
    'num_items'       => 2,
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
    ),
  ),
  array(
    'num_rows'        => '2',
    'num_items'       => 3,
    'items'           => array(
      array(
        'column_start'  => '0',
        'column_end'    => '4',
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
        'row_start'     => '0',
        'row_end'       => '2',
      ),
    ),
  ),
  array(
    'num_rows'        => '1',
    'num_items'       => 2,
    'items'           => array(
      array(
        'column_start'  => '0',
        'column_end'    => '4',
        'row_start'     => '0',
        'row_end'       => '1',
      ),
      array(
        'column_start'  => '4',
        'column_end'    => '12',
        'row_start'     => '0',
        'row_end'       => '1',
      ),
    ),
  ),
  array(
    'num_rows'        => '2',
    'num_items'       => 3,
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
        'row_end'       => '1',
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

// Count total number of gallery images
$total_num_images = count($gallery_images);



// Set initial vars
$grid_section_index = 0;
$gallery_image_index = 0;
$total_images_rendered = 0;

// Loop through each post, and display in corresponding grid item (based on rows and items defined above)
foreach( $gallery_images as $image ) {

  // Check if we're starting a new row. 
  if ( $gallery_image_index == 0 ) {
    // START A NEW GRID ROW ?>
  <div class="row gallery-module" >
    <div class="gallery-grid-root grid-rows-<?php echo $grid_sections[$grid_section_index]['num_rows']; ?>" >
  <?php }

  // Assign grid item vars
  $col_start = $grid_sections[$grid_section_index]['items'][$gallery_image_index]['column_start'];
  $col_end = $grid_sections[$grid_section_index]['items'][$gallery_image_index]['column_end'];
  $row_start = $grid_sections[$grid_section_index]['items'][$gallery_image_index]['row_start'];
  $row_end = $grid_sections[$grid_section_index]['items'][$gallery_image_index]['row_end'];
  $width = intval($col_end) - intval($col_start);
  $height = intval($row_end) - intval($row_start);
  
  // Get ACF data
  $src = $image['sizes']['large'];

  ?>

    <div class="
      grid-image
      grid-column-<?php echo $col_start; ?>-<?php echo $width; ?>
      grid-row-<?php echo $row_start; ?>-<?php echo $height; ?>
      grid-width-<?php echo $width; ?>
      grid-height-<?php echo $height; ?>
    ">
      <div class="grid-image-container" style="background-image: url('<?php echo $src; ?>')"></div>
    </div>

  <?php

  // Increment vars where required...

  // Increment total rendered properties counter
  $total_images_rendered++;

  // if we've hit the max allowable items per current section, so increment the grid section counter and reset the property counter
  if ( $gallery_image_index >= (intval($grid_sections[$grid_section_index]['num_items']) - 1) ) {
    $grid_section_index++;
    $gallery_image_index = 0;

    // END THE GRID ROW ?>
    </div>
  </div>
  <?php 
  // check if we're rendered all available properties... 
  } elseif ( $total_images_rendered >= $total_num_images ) { 
    // if so, close the row container div!
    // END THE GRID ROW ?>
    </div>
  </div>
  <?php } else {
    $gallery_image_index++;
  }

  // if we've hit the maximum number of grid sections
  if ( $grid_section_index >= $grid_sections_count ) {
    // reset the grid section index, as we've filled out all the sections and need to start over again!
    $grid_section_index = 1; // Skip the first row, as it is designed to fit the title section therefore not required!
    $gallery_image_index = 0;
  }

}

/* Restore original Post Data */
wp_reset_postdata();
