<?php

$sorted_users = array();

/* Check the ACF for rows */
if( have_rows('staff_job_titles', 'options') ):
  
  /* Loop through any existing rows */
  while ( have_rows('staff_job_titles', 'options') ) : the_row();

  //$job_title_id = get_row_index();
  $job_title = get_sub_field('staff_job_title', 'options');

  /* Setup arguments for WP DB Query */
  $args = array(
    'role__in' => array( Interra_Roles::$BROKER_ROLE_SLUG, Interra_Roles::$MANAGER_ROLE_SLUG ),
    'meta_key'      => 'job_title',
    'meta_value'    => $job_title,
    'meta_compare'  => '=',
    'orderby'       => 'display_name',
    'order'         => 'ASC'
  );

  $user_query = new WP_User_Query( $args );

  if ( ! empty( $user_query->get_results() ) ) {
    /* Append results to end of sorted users array */
    $sorted_users = array_merge( $sorted_users, $user_query->get_results() );
  }

  endwhile;

else :

  /* No AFC job titles added to system, therefore just query the users in alphabetical order */
  $args = array(
    'role__in' => array( Interra_Roles::$BROKER_ROLE_SLUG, Interra_Roles::$MANAGER_ROLE_SLUG ),
    'orderby'       => 'display_name',
    'order'         => 'ASC'
  );

  $sorted_users = new WP_User_Query( $args );
  $sorted_users = $sorted_users->get_results();

endif;

if ( ! empty( $sorted_users ) ) { ?>

  <div class="staff-members-module" >

    <?php foreach ( $sorted_users as $user ) {

      $title = $user->data->display_name;
      $permalink = get_author_posts_url( $user->ID );
      $tel = get_field( 'telephone', 'user_'.$user->ID );
      $thumbnail = get_field( 'featured_image', 'user_'.$user->ID );
      if (!$thumbnail) {
        $thumbnail = get_avatar_url( $user->ID, array( 'size' => 400 ) );
      }
      $second_img = get_field( 'second_image', 'user_'.$user->ID );
      if (!$second_img) {
        $second_img = $thumbnail;
      }

      ?>

      <div class="staff-member" >
        <a class="image-wrapper" href="<?php echo $permalink; ?>">
          <img class="staff-member-image" src="<?php echo $thumbnail; ?>" />
          <img class="staff-member-second-image" src="<?php echo $second_img; ?>" />
        </a>

        <div class="staff-member-content" >
          <h4><?php echo $title; ?></h4>

          <?php include locate_template( 'parts/shared/author-roles.php' ); ?>

          <div class="contact-container" >

            <div class="meet-broker" >
              <a href="<?php echo $permalink; ?>">
                <button>
                  Meet <?php echo $user->first_name; ?>
                </button>
              </a>
            </div>

            <div class="broker-icons" >
              <?php if ($user->user_email) { ?>
                <a href="mailto:<?php echo $user->user_email; ?>" >
                  <div class="broker-icon envelope"></div>
                </a>
              <?php } ?>

              <?php if ($tel) { ?>
                <a href="tel:<?php echo $tel; ?>" >
                  <div class="broker-icon phone"></div>
                </a>
              <?php } ?>
            </div>

          </div>

        </div>
      </div>

    <?php } ?>

  </div>

<?php } ?>
