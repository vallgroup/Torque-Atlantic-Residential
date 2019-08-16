<?php

$title = $user->display_name;
$description = $user->description;
$description = wpautop( $description, false );
$thumbnail = get_field( 'featured_image', 'user_'.$user->ID );
if (!$thumbnail) $thumbnail = get_avatar_url( $user->ID, array( 'size' => 1000 ) );

// Get previous/next links
$sortedUsers = Atlantic_Residential_Roles::$SORTED_USERS_BY_JOB_TITLE;
$numUsers = sizeof($sortedUsers);
$prev_staff_id = false;
$next_staff_id = false;
if ( ! empty( $sortedUsers ) ) {
    for($i = 0; $i < $numUsers; ++$i) {
        if ( $sortedUsers[$i]->ID == $user->ID ) {
            // get previous staff ID
            if ( ($i - 1) >= 0) {
                $prev_staff_id = $sortedUsers[$i - 1]->ID;
            }
            // get next staff ID
            if ( ($i + 1) < $numUsers) {
                $next_staff_id = $sortedUsers[$i + 1]->ID;
            }
            break;
        }
    }
}

?>

<div class="staff-title-section" >

  <div class="staff-image-container">
    <img class="featured-image" src="<?php echo $thumbnail; ?>" />
  </div>

  <div class="staff-detail" >
    <h2><?php echo $title; ?></h2>

    <?php include locate_template( 'parts/shared/author-roles.php' ); ?>

    <div class="staff-content" >
      <p><?php echo $description; ?></p>
    </div>

    <div class="staff-navigation">
        <?php if ($prev_staff_id) { ?>
            <a href="<?php echo get_author_posts_url($prev_staff_id); ?>" class="nav-link nav-link-prev">Previous</a>
        <?php } else { ?>
            <span class="nav-link nav-link-prev end-of-the-line">Previous</span>
        <?php }
        if ($next_staff_id) { ?>
            <a href="<?php echo get_author_posts_url($next_staff_id); ?>" class="nav-link nav-link-next">Next</a>
        <?php }  else { ?>
            <span class="nav-link nav-link-next end-of-the-line">Next</span>
        <?php } ?>
    </div>
  </div>

</div>