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
        <div class="image-wrapper">
          <img class="staff-member-image" src="<?php echo $thumbnail; ?>" />
          <a href="<?php echo $permalink; ?>" class="staff-member-content desktop">
            <h4><?php echo $title; ?></h4>
            <?php include locate_template( 'parts/shared/author-roles.php' ); ?>
            <div class="meet-broker" >Learn More</div>
          </a>
        </div>
        <div class="staff-member-content mobile">
          <h4><?php echo $title; ?></h4>
          <?php include locate_template( 'parts/shared/author-roles.php' ); ?>
          <a href="<?php echo $permalink; ?>" class="meet-broker" >Learn More</a>
        </div>
      </div>

    <?php } ?>

  </div>

<?php } ?>
