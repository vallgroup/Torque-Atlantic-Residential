<?php

$action = 'https://torquelaunch.us20.list-manage.com/subscribe/post?u=ad84318294be29bb41e051167&amp;id=f999becc29';

$title = get_sub_field( 'mailchimp_title' );
$desc = get_sub_field( 'mailchimp_desc' );

 ?>

<div class="interra-mailchimp-form">

<!-- Begin Mailchimp Signup Form -->
<!-- <link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css"> -->
<style type="text/css">
  #mc_embed_signup{background:#fff; clear:left; }


</style>
<div id="mc_embed_signup">
  <form action="<?php echo $action; ?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
      <div id="mc_embed_signup_scroll">

        <h2><?php echo $title; ?></h2>

        <p><?php echo $desc; ?></p>

        <div class="mc-field-group first">
          <input type="text" value="" name="FNAME" class="" id="mce-FNAME" placeholder="First Name">
        </div>

        <div class="mc-field-group last">
          <input type="text" value="" name="LNAME" class="" id="mce-LNAME" placeholder="Last Name">
        </div>

        <div style="clear: both;"></div>

        <div class="mc-field-group email">
          <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="Email Address">
        </div>

        <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
        <div style="position: absolute; left: -5000px;" aria-hidden="true">
          <input type="text" name="b_ad84318294be29bb41e051167_f999becc29" tabindex="-1" value="">
        </div>

        <div class="clear submit-btn">
          <input type="submit" value="Sign Up" name="subscribe" id="mc-embedded-subscribe" class="button">
        </div>

        <div style="clear: both;"></div>

        <div id="mce-responses" class="clear">
          <div class="response" id="mce-error-response" style="display:none"></div>
          <div class="response" id="mce-success-response" style="display:none"></div>
        </div>

      </div>
  </form>
</div>
<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script>
<script type='text/javascript'>
(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[0]='EMAIL';ftypes[0]='email';}(jQuery));var $mcj = jQuery.noConflict(true);
</script>
<!--End mc_embed_signup-->

</div>