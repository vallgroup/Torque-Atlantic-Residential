<?php
  $job_title = get_field( 'job_title', 'user_'.$user->ID );
?>

<?php if ($job_title) { ?>

  <div class="staff-roles" >
    <div class="staff-role" >
      <?php echo $job_title; ?>
    </div>
  </div>

<?php } elseif (count($user->roles)) { ?>

  <div class="staff-roles" >
    <?php foreach ($user->roles as $role) { ?>
      <div class="staff-role" >
        <?php echo ucfirst($role); ?>
      </div>
    <?php } ?>
  </div>

<?php } ?>
