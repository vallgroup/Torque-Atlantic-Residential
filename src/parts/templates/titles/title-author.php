<?php

$title = $user->display_name;
$description = $user->description;
$description = wpautop( $description, false );
$thumbnail = get_field( 'featured_image', 'user_'.$user->ID );
if (!$thumbnail) $thumbnail = get_avatar_url( $user->ID, array( 'size' => 1000 ) );

?>

<div class="torque_staff-title" >
  <div class="staff-image-container">
    <img class="featured-image" src="<?php echo $thumbnail; ?>" />
  </div>

  <div class="staff-detail" >
    <h2><?php echo $title; ?></h2>

    <?php include locate_template( 'parts/shared/author-roles.php' ); ?>

    <div class="hide-on-tablet staff-content" >
      <p><?php echo $description; ?></p>
    </div>

    <?php include locate_template('/parts/templates/titles/title-author-contact.php'); ?>
  </div>

  <div class="show-on-tablet staff-content" >
    <p><?php echo $description; ?></p>
  </div>
</div>
