<?php

$email = $user->user_email;
$tel = get_field( 'telephone', 'user_'.$user->ID );
$vcard = get_field( 'vcard_file', 'user_'.$user->ID );

?>

<div class="torque-staff-contact" >
  <?php if ($email) { ?>
    <a class="broker-icon-link" href="mailto:<?php echo $email; ?>" >
      <div class="broker-icon envelope"></div>
      <?php echo $email; ?>
    </a>
  <?php } ?>

  <?php if ($tel) { ?>
    <a class="broker-icon-link" href="tel:<?php echo $tel; ?>" >
      <div class="broker-icon phone"></div>
      <?php echo $tel; ?>
    </a>
  <?php } ?>

  <?php if ($vcard) { ?>
    <a class="broker-icon-link" href="<?php echo $vcard; ?>" target="_blank" referrer="noreferrer noopener">
      <div class="broker-icon vcard"></div>
      Download vcard
    </a>
  <?php } ?>
</div>
