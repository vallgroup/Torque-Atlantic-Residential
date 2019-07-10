<div id="careers-form" class="careers-form">
  <h3>Start Your Journey Today!</h3>

  <?php if (isset($message)) {
    $success_class = ! $message['success'] ? 'error' : '';
    ?>
    <div class="form-message <?php echo $success_class; ?>">
      <?php echo $message['message']; ?>
    </div>
  <?php } ?>

  <form method="post" action="#careers-form" enctype="multipart/form-data">

    <?php echo wp_nonce_field( 'submit_careers_form' ); ?>

    <?php
    // this hidden input is important for us to know
    // if the form has been submitted yet
    // so we can check that all fields are filled
    ?>
    <input type="hidden" name="tq-careers-form" />

    <div class="input-wrapper">
      <label for="tq-name">Name</label>
      <input type="text" name="tq-name" id="tq-name" placeholder="Name"/>
    </div>

    <div class="input-wrapper">
      <label for="tq-emai">Email</label>
      <input type="email" name="tq-email" id="tq-email" placeholder="Email Address"/>
    </div>

    <div class="input-wrapper">
      <label for="tq-phone">Phone</label>
      <input type="tel" name="tq-phone" id="tq-phone" placeholder="Phone Number"/>
    </div>

    <div class="input-wrapper half-width first-col">
      <label for="tq-state">Current State</label>
      <input type="text" name="tq-state" id="tq-state" placeholder="State"/>
    </div>

    <div class="input-wrapper half-width second-col">
      <label for="tq-zipcode">Current Zip Code</label>
      <input type="text" name="tq-zipcode" id="tq-zipcode" placeholder="Zip Code"/>
    </div>

    <div class="input-wrapper clear-left second-section-start">
      <label for="tq-job">Job you are applying for</label>
      <input type="text" name="tq-job" id="tq-job" placeholder="Job Title"/>
    </div>

    <div class="input-wrapper">
      <label for="tq-intro">Cover Letter / Introduction</label>
      <textarea name="tq-intro" id="tq-intro" placeholder="Tell us about yourself"></textarea>
    </div>

    <div class="input-wrapper">
      <div class="file-picker">
        <label for="tq-resume" >Resume Upload</label>
        <input type="file" accept=".pdf" name="tq-resume" id="tq-resume" />
        <label for="tq-resume" class="filename">Upload</label>
      </div>
    </div>

    <div class="input-wrapper" >
      <?php echo do_shortcode('[torque_recaptcha]'); ?>
    </div>

    <button type="submit" class="white">Apply Now</button>
  </form>

</div>
