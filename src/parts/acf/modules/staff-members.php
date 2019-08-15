<?php

$sorted_users = Atlantic_Residential_Roles::$SORTED_USERS_BY_JOB_TITLE;

if ( ! empty( $sorted_users ) ) { ?>

  <div class="staff-members-module" >

    <?php foreach ( $sorted_users as $user ) {

      $title = $user->data->display_name;
      $permalink = get_author_posts_url( $user->ID );
      $thumbnail = get_field( 'featured_image', 'user_'.$user->ID );
      if (!$thumbnail) {
        $thumbnail = get_avatar_url( $user->ID, array( 'size' => 400 ) );
      }

      ?>

      <div class="staff-member" >
        <a href="<?php echo $permalink; ?>"> 
          <div class="image-wrapper">
            <img class="staff-member-image" src="<?php echo $thumbnail; ?>" />
            <div class="staff-member-content">
              <h4><?php echo $title; ?></h4>
              <?php include locate_template( 'parts/shared/author-roles.php' ); ?>
              <div class="meet-broker" >Learn More</div>
            </div>
          </div>
        </a>
      </div>

    <?php } ?>

  </div>

<?php } ?>
