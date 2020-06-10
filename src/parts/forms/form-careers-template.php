<div id="careers-form" class="careers-form">
  <h3>Start Your Journey Today!</h3>

  <?php if (isset($message)) {
    $success_class = ! $message['success'] ? 'error' : '';
    ?>
    <div class="form-message <?php echo $success_class; ?>">
      <?php echo $message['message']; ?>
    </div>
  <?php } ?>

  <form id="careers-form-main" method="post" action="#careers-form" enctype="multipart/form-data">

    <?php echo wp_nonce_field( 'submit_careers_form' ); ?>

    <?php
    // this hidden input is important for us to know
    // if the form has been submitted yet
    // so we can check that all fields are filled
    ?>
    <input type="hidden" name="tq-careers-form" />

    <?php
    // this hidden input is important for us to know
    // which application stage this form belongs to
    // eg: stage 1 or stage 2....
    ?>
    <input type="hidden" name="tq-form-stage" value="1" />

    <div class="input-wrapper">
      <label for="tq-name">Name</label>
      <input type="text" name="tq-name" id="tq-name" placeholder="Name" value="<?php echo isset($_POST['tq-name']) ? $_POST['tq-name'] : '' ?>" required/>
    </div>

    <div class="input-wrapper">
      <label for="tq-emai">Email</label>
      <input type="email" name="tq-email" id="tq-email" placeholder="Email Address" value="<?php echo isset($_POST['tq-email']) ? $_POST['tq-email'] : '' ?>" required/>
    </div>

    <div class="input-wrapper">
      <label for="tq-phone">Phone</label>
      <input type="tel" name="tq-phone" id="tq-phone" placeholder="Phone Number" value="<?php echo isset($_POST['tq-phone']) ? $_POST['tq-phone'] : '' ?>" required/>
    </div>

    <div class="input-wrapper half-width first-col">
      <label for="tq-state">Current State</label>
      <input type="text" name="tq-state" id="tq-state" placeholder="State" value="<?php echo isset($_POST['tq-state']) ? $_POST['tq-state'] : '' ?>" required/>
    </div>

    <div class="input-wrapper half-width second-col">
      <label for="tq-zipcode">Current Zip Code</label>
      <input type="text" name="tq-zipcode" id="tq-zipcode" placeholder="Zip Code" value="<?php echo isset($_POST['tq-zipcode']) ? $_POST['tq-zipcode'] : '' ?>" required/>
    </div>

    <div class="input-wrapper clear-left second-section-start">
      <label for="tq-job">Job you are applying for</label>
      <input type="text" name="tq-job" id="tq-job" placeholder="Job Title" value="<?php echo isset($_POST['tq-job']) ? $_POST['tq-job'] : '' ?>" required/>
    </div>

    <div class="input-wrapper">
      <label for="tq-intro">Cover Letter / Introduction</label>
      <textarea name="tq-intro" id="tq-intro" placeholder="Tell us about yourself" required> <?php echo isset($_POST['tq-intro']) ? $_POST['tq-intro'] : '' ?></textarea>
    </div>

    <div class="input-wrapper">
      <div class="file-picker-container">
        <label for="tq-resume" >Resume Upload</label>
        <input type="file" accept=".pdf" value="" name="tq-resume" id="tq-resume" required/>
        <div class="file-input-text placeholder">File name</div>
        <label for="tq-resume" class="filename standin-upload-btn">Select</label>
      </div>
    </div>

    <div class="input-wrapper" >
      <?php echo do_shortcode('[torque_recaptcha]'); ?>
    </div>

    <div class="input-wrapper submit-btn" >
      <button type="submit" class="white">Apply Now</button>
    </div>
  </form>

</div>
