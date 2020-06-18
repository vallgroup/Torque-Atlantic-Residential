<div id="online-application-form" class="online-application-form">

  <?php if (isset($message)) {
    $success_class = ! $message['success'] ? 'error' : '';
    ?>
    <div class="form-message <?php echo $success_class; ?>">
      <?php echo $message['message']; ?>
    </div>
  <?php } ?>

  <form id="online-application-form-main" method="post" action="#online-application-form" enctype="multipart/form-data">

    <?php echo wp_nonce_field( 'submit_online_application_form' ); ?>

    <?php
    // this hidden input is important for us to know
    // if the form has been submitted yet
    // so we can check that all fields are filled
    ?>
    <input type="hidden" name="tq-online-application-form" />

    <?php
    // this hidden input is important for us to know
    // which application stage this form belongs to
    // eg: stage 1 or stage 2....
    ?>
    <input type="hidden" name="tq-form-stage" value="2" />

<?php // SECTION ONE | START ?>

    <div id="section-one" class="online-application-sections section-one">
      <div class="section-inner-container">
        
        <h3>Personal Information</h3>

        <div class="input-wrapper half-width first-col">
          <label for="tq-s1-name-first">First Name</label>
          <input type="text" name="tq-s1-name-first" id="tq-s1-name-first" placeholder="First Name" value="<?php echo isset($_POST['tq-s1-name-first']) ? $_POST['tq-s1-name-first'] : '' ?>" required/>
        </div>

        <div class="input-wrapper half-width second-col">
          <label for="tq-s1-name-last">Last Name</label>
          <input type="text" name="tq-s1-name-last" id="tq-s1-name-last" placeholder="Last Name" value="<?php echo isset($_POST['tq-s1-name-last']) ? $_POST['tq-s1-name-last'] : '' ?>" required/>
        </div>

        <div class="input-wrapper">
          <label for="tq-s1-address">Address</label>
          <input type="text" name="tq-s1-address" id="tq-s1-address" placeholder="Address" value="<?php echo isset($_POST['tq-s1-address']) ? $_POST['tq-s1-address'] : '' ?>" required/>
        </div>

        <div class="input-wrapper">
          <label for="tq-s1-address-2">Address 2</label>
          <input type="text" name="tq-s1-address-2" id="tq-s1-address-2" placeholder="Address 2" value="<?php echo isset($_POST['tq-s1-address-2']) ? $_POST['tq-s1-address-2'] : '' ?>"/>
        </div>

        <div class="input-wrapper half-width first-col">
          <label for="tq-s1-city">City</label>
          <input type="text" name="tq-s1-city" id="tq-s1-city" placeholder="City" value="<?php echo isset($_POST['tq-s1-city']) ? $_POST['tq-s1-city'] : '' ?>" required/>
        </div>

        <div class="input-wrapper half-width second-col">
          <div class="input-wrapper half-width first-col">
            <label for="tq-s1-state">State</label>
            <input type="text" name="tq-s1-state" id="tq-s1-state" placeholder="State" value="<?php echo isset($_POST['tq-s1-state']) ? $_POST['tq-s1-state'] : '' ?>" required/>
          </div>

          <div class="input-wrapper half-width second-col">
            <label for="tq-s1-zipcode">Zip Code</label>
            <input type="text" name="tq-s1-zipcode" id="tq-s1-zipcode" placeholder="Zip Code" value="<?php echo isset($_POST['tq-s1-zipcode']) ? $_POST['tq-s1-zipcode'] : '' ?>" required/>
          </div>
        </div>

        <div class="input-wrapper half-width first-col">
          <label for="tq-s1-phone">Phone Number</label>
          <input type="tel" name="tq-s1-phone" id="tq-s1-phone" placeholder="Phone Number" value="<?php echo isset($_POST['tq-s1-phone']) ? $_POST['tq-s1-phone'] : '' ?>" required/>
        </div>

        <div class="input-wrapper half-width second-col">
          <label for="tq-s1-emai">Email Address</label>
          <input type="email" name="tq-s1-email" id="tq-s1-email" placeholder="Email Address" value="<?php echo isset($_POST['tq-s1-email']) ? $_POST['tq-s1-email'] : '' ?>" required/>
        </div>

        <div class="input-wrapper radio-input-wrapper">
          <label for="tq-s1-legal-right" class="hidden-label">After employment, can you submit verification of your legal right to work in the United States?</label>
          <p>After employment, can you submit verification of your legal right to work in the United States?</p>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s1-legal-right" value="yes" <?php echo isset($_POST['tq-s1-legal-right']) ? ( $_POST['tq-s1-legal-right'] == 'yes' ? 'checked' : '' )  : '' ; ?>/> Yes
          </div>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s1-legal-right" value="no" <?php echo isset($_POST['tq-s1-legal-right']) ? ( $_POST['tq-s1-legal-right'] == 'no' ? 'checked' : '' )  : '' ; ?>/> No
          </div>
        </div>

        <div class="input-wrapper">
          <label for="tq-s1-alternate-names" class="hidden-label">Have you ever used any other name? If yes, please explain.</label>
          <p>Have you ever used any other name? If yes, please explain.</p>
          <textarea name="tq-s1-alternate-names" id="tq-s1-alternate-names" placeholder="Previous Names and Explanation"><?php echo isset($_POST['tq-s1-alternate-names']) ? $_POST['tq-s1-alternate-names'] : '' ?></textarea>
        </div>

        <div class="input-wrapper radio-input-wrapper">
          <label for="tq-s1-over-18" class="hidden-label">Are You Over 18?</label>
          <p>Are you 18 years old or over?</p>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s1-over-18" value="yes" <?php echo isset($_POST['tq-s1-over-18']) ? ( $_POST['tq-s1-over-18'] == 'yes' ? 'checked' : '' )  : '' ; ?>/> Yes
          </div>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s1-over-18" value="no" <?php echo isset($_POST['tq-s1-over-18']) ? ( $_POST['tq-s1-over-18'] == 'no' ? 'checked' : '' )  : '' ; ?>/> No
          </div>
        </div>

        <div class="input-wrapper">
          <label for="tq-s1-prior-convictions" class="hidden-label">Have you ever been convicted of a felony, misdemeanor, child abuse or sex-related crimes? If yes, please explain.</label>
          <p>Have you ever been convicted of a felony, misdemeanor, child abuse or sex-related crimes? If yes, please explain.</p>
          <textarea name="tq-s1-prior-convictions" id="tq-s1-prior-convictions" placeholder="Conviction(s) and Explanation"><?php echo isset($_POST['tq-s1-prior-convictions']) ? $_POST['tq-s1-prior-convictions'] : '' ?></textarea>
        </div>

        <div class="input-wrapper">
          <label for="tq-s1-pending-legal-charges" class="hidden-label">Do you have any pending legal charges against you? If yes, please explain.</label>
          <p>Do you have any pending legal charges against you? If yes, please explain.</p>
          <textarea name="tq-s1-pending-legal-charges" id="tq-s1-pending-legal-charges" placeholder="Legal Charges and Explanation"><?php echo isset($_POST['tq-s1-pending-legal-charges']) ? $_POST['tq-s1-pending-legal-charges'] : '' ?></textarea>
          <p class="input-note">Note: Prior convictions will not absolutely prohibit employment but will be considered in relation to specific job requirements applying for.</p>
        </div>

      </div>
      <div class="section-advance-container"><a href="#section-two">Advance to next section <span class="fa fa-arrow-down"></span></a></div>
    </div>

<?php // SECTION TWO | START ?>

    <div id="section-two" class="online-application-sections section-two">
      <div class="section-inner-container">
        <h3>Desired Employment</h3>

        <div class="input-wrapper">
          <label for="tq-s2-role">Desired Role</label>
          <input type="text" name="tq-s2-role" id="tq-s2-role" placeholder="Desired Role" value="<?php echo isset($_POST['tq-s2-role']) ? $_POST['tq-s2-role'] : '' ?>"/>
        </div>

        <div class="input-wrapper half-width first-col">
          <label for="tq-s2-salary">Desired Salary</label>
          <input type="text" name="tq-s2-salary" id="tq-s2-salary" placeholder="Desired Salary" value="<?php echo isset($_POST['tq-s2-salary']) ? $_POST['tq-s2-salary'] : '' ?>" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency"/>
        </div>

        <div class="input-wrapper half-width second-col">
          <label for="tq-s2-available">Date Available</label>
          <input type="text" name="tq-s2-available" id="tq-s2-available" placeholder="mm/dd/yyyy" value="<?php echo isset($_POST['tq-s2-available']) ? $_POST['tq-s2-available'] : '' ?>"/>
        </div>

        <div class="input-wrapper radio-input-wrapper">
          <label for="tq-s2-employed" class="hidden-label">Are you presently employed?</label>
          <p>Are you presently employed?</p>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s2-employed" value="yes" <?php echo isset($_POST['tq-s2-employed']) ? ( $_POST['tq-s2-employed'] == 'yes' ? 'checked' : '' )  : '' ; ?>/> Yes
          </div>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s2-employed" value="no" <?php echo isset($_POST['tq-s2-employed']) ? ( $_POST['tq-s2-employed'] == 'no' ? 'checked' : '' )  : '' ; ?>/> No
          </div>
        </div>

        <div class="input-wrapper radio-input-wrapper">
          <label for="tq-s2-contact-employer" class="hidden-label">If yes, may we contact your present employer?</label>
          <p>If yes, may we contact your present employer?</p>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s2-contact-employer" value="yes" <?php echo isset($_POST['tq-s2-contact-employer']) ? ( $_POST['tq-s2-contact-employer'] == 'yes' ? 'checked' : '' )  : '' ; ?>/> Yes
          </div>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s2-contact-employer" value="no" <?php echo isset($_POST['tq-s2-contact-employer']) ? ( $_POST['tq-s2-contact-employer'] == 'no' ? 'checked' : '' )  : '' ; ?>/> No
          </div>
        </div>

        <div class="input-wrapper half-width first-col">
          <label for="tq-s2-supervisors-name">Supervisor's Name</label>
          <input type="text" name="tq-s2-supervisors-name" id="tq-s2-supervisors-name" placeholder="Supervisor's Name" value="<?php echo isset($_POST['tq-s2-supervisors-name']) ? $_POST['tq-s2-supervisors-name'] : '' ?>"/>
        </div>

        <div class="input-wrapper half-width second-col">
          <label for="tq-s2-supervisors-phone">Supervisor's Phone</label>
          <input type="text" name="tq-s2-supervisors-phone" id="tq-s2-supervisors-phone" placeholder="Supervisor's Phone" value="<?php echo isset($_POST['tq-s2-supervisors-phone']) ? $_POST['tq-s2-supervisors-phone'] : '' ?>"/>
        </div>

        <div class="input-wrapper">
          <label for="tq-s2-prior-atl-resi-employee" class="hidden-label">Prior Atlantic Residential Employee?</label>
          <p>Have you ever been employed by ATLANTIC RESIDENTIAL before? <br>If yes, when/where?</p>
          <textarea name="tq-s2-prior-atl-resi-employee" id="tq-s2-prior-atl-resi-employee" placeholder="Employment and Explanation"><?php echo isset($_POST['tq-s2-prior-atl-resi-employee']) ? $_POST['tq-s2-prior-atl-resi-employee'] : '' ?></textarea>
        </div>

        <div class="input-wrapper">
          <label for="tq-s2-referral" class="hidden-label">How were you referred to Atlantic Residential?</label>
          <p>How were you referred to Atlantic Residential?</p>
          <input type="text" name="tq-s2-referral" id="tq-s2-referral" placeholder="Referral Source" value="<?php echo isset($_POST['tq-s2-referral']) ? $_POST['tq-s2-referral'] : '' ?>" />
        </div>

      </div>
      <div class="section-advance-container"><a href="#section-three">Advance to next section <span class="fa fa-arrow-down"></span></a></div>
    </div>

<?php // SECTION THREE | START ?>

    <div id="section-three" class="online-application-sections section-three">
      <div class="section-inner-container">
        <h3>Education and Training</h3>

        <div class="input-wrapper radio-input-wrapper">
          <label for="tq-s3-highschool" class="hidden-label">Did you graduate from High School?</label>
          <p>Did you graduate from High School?</p>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s3-highschool" value="yes" <?php echo isset($_POST['tq-s3-highschool']) ? ( $_POST['tq-s3-highschool'] == 'yes' ? 'checked' : '' )  : '' ; ?>/> Yes
          </div>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s3-highschool" value="no" <?php echo isset($_POST['tq-s3-highschool']) ? ( $_POST['tq-s3-highschool'] == 'no' ? 'checked' : '' )  : '' ; ?>/> No
          </div>
        </div>

        <div class="input-wrapper radio-input-wrapper">
          <label for="tq-s3-university" class="hidden-label">Did you graduate from College/University?</label>
          <p>Did you graduate from College/University?</p>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s3-university" value="yes" <?php echo isset($_POST['tq-s3-university']) ? ( $_POST['tq-s3-university'] == 'yes' ? 'checked' : '' )  : '' ; ?>/> Yes
          </div>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s3-university" value="no" <?php echo isset($_POST['tq-s3-university']) ? ( $_POST['tq-s3-university'] == 'no' ? 'checked' : '' )  : '' ; ?>/> No
          </div>
        </div>

        <div class="input-wrapper half-width first-col">
          <label for="tq-s3-uni-degree">Degree</label>
          <input type="text" name="tq-s3-uni-degree" id="tq-s3-uni-degree" placeholder="Degree" value="<?php echo isset($_POST['tq-s3-uni-degree']) ? $_POST['tq-s3-uni-degree'] : '' ?>"/>
        </div>

        <div class="input-wrapper half-width second-col">
          <label for="tq-s3-uni-major">Major</label>
          <input type="text" name="tq-s3-uni-major" id="tq-s3-uni-major" placeholder="Major" value="<?php echo isset($_POST['tq-s3-uni-major']) ? $_POST['tq-s3-uni-major'] : '' ?>"/>
        </div>

        <div class="input-wrapper radio-input-wrapper">
          <label for="tq-s3-graduate" class="hidden-label">Did you attend a graduate program?</label>
          <p>Did you attend a graduate program?</p>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s3-graduate" value="yes" <?php echo isset($_POST['tq-s3-graduate']) ? ( $_POST['tq-s3-graduate'] == 'yes' ? 'checked' : '' )  : '' ; ?>/> Yes
          </div>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s3-graduate" value="no" <?php echo isset($_POST['tq-s3-graduate']) ? ( $_POST['tq-s3-graduate'] == 'no' ? 'checked' : '' )  : '' ; ?>/> No
          </div>
        </div>

        <div class="input-wrapper half-width first-col">
          <label for="tq-s3-grad-degree">Degree</label>
          <input type="text" name="tq-s3-grad-degree" id="tq-s3-grad-degree" placeholder="Degree" value="<?php echo isset($_POST['tq-s3-grad-degree']) ? $_POST['tq-s3-grad-degree'] : '' ?>"/>
        </div>

        <div class="input-wrapper half-width second-col">
          <label for="tq-s3-grad-major">Major</label>
          <input type="text" name="tq-s3-grad-major" id="tq-s3-grad-major" placeholder="Major" value="<?php echo isset($_POST['tq-s3-grad-major']) ? $_POST['tq-s3-grad-major'] : '' ?>"/>
        </div>

        <div class="input-wrapper radio-input-wrapper">
          <label for="tq-s3-university" class="hidden-label">Highest Degree Earned</label>
          <p>Highest Degree Earned</p>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s3-highest-degree" value="associate" <?php echo isset($_POST['tq-s3-highest-degree']) ? ( $_POST['tq-s3-highest-degree'] == 'associate' ? 'checked' : '' )  : '' ; ?>/> Associate
          </div>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s3-highest-degree" value="bachelor" <?php echo isset($_POST['tq-s3-highest-degree']) ? ( $_POST['tq-s3-highest-degree'] == 'bachelor' ? 'checked' : '' )  : '' ; ?>/> Bachelor
          </div>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s3-highest-degree" value="master" <?php echo isset($_POST['tq-s3-highest-degree']) ? ( $_POST['tq-s3-highest-degree'] == 'master' ? 'checked' : '' )  : '' ; ?>/> Master
          </div>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s3-highest-degree" value="doctorate" <?php echo isset($_POST['tq-s3-highest-degree']) ? ( $_POST['tq-s3-highest-degree'] == 'doctorate' ? 'checked' : '' )  : '' ; ?>/> Doctorate
          </div>
        </div>

        <div class="input-wrapper">
          <label for="tq-s3-extras" class="hidden-label">Please list below any additional training, honors, awards, certification or license which you hold that you would like us to consider when reviewing your application.</label>
          <p>Please list below any additional training, honors, awards, certification or license which you hold that you would like us to consider when reviewing your application.</p>
          <textarea name="tq-s3-extras" id="tq-s3-extras" placeholder="Trainings, honors, awards, etc."><?php echo isset($_POST['tq-s3-extras']) ? $_POST['tq-s3-extras'] : '' ?></textarea>
        </div>

        <div class="input-wrapper">
          <label for="tq-s3-languages" class="hidden-label">Do you speak or write any foreign languages? If yes, please explain.</label>
          <p>Do you speak or write any foreign languages? If yes, please explain.</p>
          <textarea name="tq-s3-languages" id="tq-s3-languages" placeholder="Foreign Languages and Explanation"><?php echo isset($_POST['tq-s3-languages']) ? $_POST['tq-s3-languages'] : '' ?></textarea>
        </div>

      </div>
      <div class="section-advance-container"><a href="#section-four">Advance to next section <span class="fa fa-arrow-down"></span></a></div>
    </div>

<?php // SECTION FOUR | START ?>

    <div id="section-four" class="online-application-sections section-four">
      <div class="section-inner-container">
        <h3>Employment History</h3>
        <h4>Current or Most Recent Employment</h4>

        <div class="input-wrapper half-width first-col">
          <label for="tq-s4-name">Company Name</label>
          <input type="text" name="tq-s4-name" id="tq-s4-name" placeholder="Company Name" value="<?php echo isset($_POST['tq-s4-name']) ? $_POST['tq-s4-name'] : '' ?>" />
        </div>

        <div class="input-wrapper half-width second-col">
          <label for="tq-s4-phone">Company Phone</label>
          <input type="tel" name="tq-s4-phone" id="tq-s4-phone" placeholder="Company Phone" value="<?php echo isset($_POST['tq-s4-phone']) ? $_POST['tq-s4-phone'] : '' ?>" />
        </div>

        <div class="input-wrapper">
          <label for="tq-s4-address">Address</label>
          <input type="text" name="tq-s4-address" id="tq-s4-address" placeholder="Address" value="<?php echo isset($_POST['tq-s4-address']) ? $_POST['tq-s4-address'] : '' ?>" />
        </div>

        <div class="input-wrapper">
          <label for="tq-s4-address-2">Address 2</label>
          <input type="text" name="tq-s4-address-2" id="tq-s4-address-2" placeholder="Address 2" value="<?php echo isset($_POST['tq-s4-address-2']) ? $_POST['tq-s4-address-2'] : '' ?>"/>
        </div>

        <div class="input-wrapper half-width first-col">
          <label for="tq-s4-city">City</label>
          <input type="text" name="tq-s4-city" id="tq-s4-city" placeholder="City" value="<?php echo isset($_POST['tq-s4-city']) ? $_POST['tq-s4-city'] : '' ?>" />
        </div>

        <div class="input-wrapper half-width second-col">
          <div class="input-wrapper half-width first-col">
            <label for="tq-s4-state">State</label>
            <input type="text" name="tq-s4-state" id="tq-s4-state" placeholder="State" value="<?php echo isset($_POST['tq-s4-state']) ? $_POST['tq-s4-state'] : '' ?>" />
          </div>

          <div class="input-wrapper half-width second-col">
            <label for="tq-s4-zipcode">Zip Code</label>
            <input type="text" name="tq-s4-zipcode" id="tq-s4-zipcode" placeholder="Zip Code" value="<?php echo isset($_POST['tq-s4-zipcode']) ? $_POST['tq-s4-zipcode'] : '' ?>" />
          </div>
        </div>

        <div class="input-wrapper">
          <label for="tq-s4-job-titles">Job Title(s)</label>
          <input type="text" name="tq-s4-job-titles" id="tq-s4-job-titles" placeholder="Job Title(s)" value="<?php echo isset($_POST['tq-s4-job-titles']) ? $_POST['tq-s4-job-titles'] : '' ?>" />
        </div>

        <div class="input-wrapper half-width first-col">
          <label for="tq-s4-rate-start">Base Rate of Pay - Start</label>
          <input type="text" name="tq-s4-rate-start" id="tq-s4-rate-start" placeholder="$" value="<?php echo isset($_POST['tq-s4-rate-start']) ? $_POST['tq-s4-rate-start'] : '' ?>" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" />
        </div>

        <div class="input-wrapper half-width second-col">
          <label for="tq-s4-rate-end">Base Rate of Pay - End</label>
          <input type="text" name="tq-s4-rate-end" id="tq-s4-rate-end" placeholder="$" value="<?php echo isset($_POST['tq-s4-rate-end']) ? $_POST['tq-s4-rate-end'] : '' ?>" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" />
        </div>

        <div class="input-wrapper">
          <label for="tq-s4-supervisor">Supervisor</label>
          <input type="text" name="tq-s4-supervisor" id="tq-s4-supervisor" placeholder="Name and Title" value="<?php echo isset($_POST['tq-s4-supervisor']) ? $_POST['tq-s4-supervisor'] : '' ?>" />
        </div>

        <div class="input-wrapper">
          <label for="tq-s4-duties">Description of Job Duties</label>
          <textarea name="tq-s4-duties" id="tq-s4-duties" placeholder="Job Duties"><?php echo isset($_POST['tq-s4-duties']) ? $_POST['tq-s4-duties'] : '' ?></textarea>
        </div>

        <div class="input-wrapper">
          <label for="tq-s4-reason-left">Reason for Leaving</label>
          <textarea name="tq-s4-reason-left" id="tq-s4-reason-left" placeholder="Reason for Leaving"><?php echo isset($_POST['tq-s4-reason-left']) ? $_POST['tq-s4-reason-left'] : '' ?></textarea>
        </div>

      </div>
      <div class="section-advance-container"><a href="#section-five">Advance to next section <span class="fa fa-arrow-down"></span></a></div>
    </div>

<?php // SECTION FIVE | START ?>

    <div id="section-five" class="online-application-sections section-five">
      <div class="section-inner-container">
        <h4>Second Most Recent Employment</h4>

        <div class="input-wrapper half-width first-col">
          <label for="tq-s5-name">Company Name</label>
          <input type="text" name="tq-s5-name" id="tq-s5-name" placeholder="Company Name" value="<?php echo isset($_POST['tq-s5-name']) ? $_POST['tq-s5-name'] : '' ?>" />
        </div>

        <div class="input-wrapper half-width second-col">
          <label for="tq-s5-phone">Company Phone</label>
          <input type="tel" name="tq-s5-phone" id="tq-s5-phone" placeholder="Company Phone" value="<?php echo isset($_POST['tq-s5-phone']) ? $_POST['tq-s5-phone'] : '' ?>" />
        </div>

        <div class="input-wrapper">
          <label for="tq-s5-address">Address</label>
          <input type="text" name="tq-s5-address" id="tq-s5-address" placeholder="Address" value="<?php echo isset($_POST['tq-s5-address']) ? $_POST['tq-s5-address'] : '' ?>" />
        </div>

        <div class="input-wrapper">
          <label for="tq-s5-address-2">Address 2</label>
          <input type="text" name="tq-s5-address-2" id="tq-s5-address-2" placeholder="Address 2" value="<?php echo isset($_POST['tq-s5-address-2']) ? $_POST['tq-s5-address-2'] : '' ?>"/>
        </div>

        <div class="input-wrapper half-width first-col">
          <label for="tq-s5-city">City</label>
          <input type="text" name="tq-s5-city" id="tq-s5-city" placeholder="City" value="<?php echo isset($_POST['tq-s5-city']) ? $_POST['tq-s5-city'] : '' ?>" />
        </div>

        <div class="input-wrapper half-width second-col">
          <div class="input-wrapper half-width first-col">
            <label for="tq-s5-state">State</label>
            <input type="text" name="tq-s5-state" id="tq-s5-state" placeholder="State" value="<?php echo isset($_POST['tq-s5-state']) ? $_POST['tq-s5-state'] : '' ?>" />
          </div>

          <div class="input-wrapper half-width second-col">
            <label for="tq-s5-zipcode">Zip Code</label>
            <input type="text" name="tq-s5-zipcode" id="tq-s5-zipcode" placeholder="Zip Code" value="<?php echo isset($_POST['tq-s5-zipcode']) ? $_POST['tq-s5-zipcode'] : '' ?>" />
          </div>
        </div>

        <div class="input-wrapper">
          <label for="tq-s5-job-titles">Job Title(s)</label>
          <input type="text" name="tq-s5-job-titles" id="tq-s5-job-titles" placeholder="Job Title(s)" value="<?php echo isset($_POST['tq-s5-job-titles']) ? $_POST['tq-s5-job-titles'] : '' ?>" />
        </div>

        <div class="input-wrapper half-width first-col">
          <label for="tq-s5-rate-start">Base Rate of Pay - Start</label>
          <input type="text" name="tq-s5-rate-start" id="tq-s5-rate-start" placeholder="$" value="<?php echo isset($_POST['tq-s5-rate-start']) ? $_POST['tq-s5-rate-start'] : '' ?>" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" />
        </div>

        <div class="input-wrapper half-width second-col">
          <label for="tq-s5-rate-end">Base Rate of Pay - End</label>
          <input type="text" name="tq-s5-rate-end" id="tq-s5-rate-end" placeholder="$" value="<?php echo isset($_POST['tq-s5-rate-end']) ? $_POST['tq-s5-rate-end'] : '' ?>" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" />
        </div>

        <div class="input-wrapper">
          <label for="tq-s5-supervisor">Supervisor</label>
          <input type="text" name="tq-s5-supervisor" id="tq-s5-supervisor" placeholder="Name and Title" value="<?php echo isset($_POST['tq-s5-supervisor']) ? $_POST['tq-s5-supervisor'] : '' ?>" />
        </div>

        <div class="input-wrapper">
          <label for="tq-s5-duties">Description of Job Duties</label>
          <textarea name="tq-s5-duties" id="tq-s5-duties" placeholder="Job Duties"><?php echo isset($_POST['tq-s5-duties']) ? $_POST['tq-s5-duties'] : '' ?></textarea>
        </div>

        <div class="input-wrapper">
          <label for="tq-s5-reason-left">Reason for Leaving</label>
          <textarea name="tq-s5-reason-left" id="tq-s5-reason-left" placeholder="Reason for Leaving"><?php echo isset($_POST['tq-s5-reason-left']) ? $_POST['tq-s5-reason-left'] : '' ?></textarea>
        </div>

      </div>
      <div class="section-advance-container"><a href="#section-six">Advance to next section <span class="fa fa-arrow-down"></span></a></div>
    </div>

<?php // SECTION SIX | START ?>

    <div id="section-six" class="online-application-sections section-six">
      <div class="section-inner-container">
        <h4>Third Most Recent Employment</h4>

        <div class="input-wrapper half-width first-col">
          <label for="tq-s6-name">Company Name</label>
          <input type="text" name="tq-s6-name" id="tq-s6-name" placeholder="Company Name" value="<?php echo isset($_POST['tq-s6-name']) ? $_POST['tq-s6-name'] : '' ?>" />
        </div>

        <div class="input-wrapper half-width second-col">
          <label for="tq-s6-phone">Company Phone</label>
          <input type="tel" name="tq-s6-phone" id="tq-s6-phone" placeholder="Company Phone" value="<?php echo isset($_POST['tq-s6-phone']) ? $_POST['tq-s6-phone'] : '' ?>" />
        </div>

        <div class="input-wrapper">
          <label for="tq-s6-address">Address</label>
          <input type="text" name="tq-s6-address" id="tq-s6-address" placeholder="Address" value="<?php echo isset($_POST['tq-s6-address']) ? $_POST['tq-s6-address'] : '' ?>" />
        </div>

        <div class="input-wrapper">
          <label for="tq-s6-address-2">Address 2</label>
          <input type="text" name="tq-s6-address-2" id="tq-s6-address-2" placeholder="Address 2" value="<?php echo isset($_POST['tq-s6-address-2']) ? $_POST['tq-s6-address-2'] : '' ?>"/>
        </div>

        <div class="input-wrapper half-width first-col">
          <label for="tq-s6-city">City</label>
          <input type="text" name="tq-s6-city" id="tq-s6-city" placeholder="City" value="<?php echo isset($_POST['tq-s6-city']) ? $_POST['tq-s6-city'] : '' ?>" />
        </div>

        <div class="input-wrapper half-width second-col">
          <div class="input-wrapper half-width first-col">
            <label for="tq-s6-state">State</label>
            <input type="text" name="tq-s6-state" id="tq-s6-state" placeholder="State" value="<?php echo isset($_POST['tq-s6-state']) ? $_POST['tq-s6-state'] : '' ?>" />
          </div>

          <div class="input-wrapper half-width second-col">
            <label for="tq-s6-zipcode">Zip Code</label>
            <input type="text" name="tq-s6-zipcode" id="tq-s6-zipcode" placeholder="Zip Code" value="<?php echo isset($_POST['tq-s6-zipcode']) ? $_POST['tq-s6-zipcode'] : '' ?>" />
          </div>
        </div>

        <div class="input-wrapper">
          <label for="tq-s6-job-titles">Job Title(s)</label>
          <input type="text" name="tq-s6-job-titles" id="tq-s6-job-titles" placeholder="Job Title(s)" value="<?php echo isset($_POST['tq-s6-job-titles']) ? $_POST['tq-s6-job-titles'] : '' ?>" />
        </div>

        <div class="input-wrapper half-width first-col">
          <label for="tq-s6-rate-start">Base Rate of Pay - Start</label>
          <input type="text" name="tq-s6-rate-start" id="tq-s6-rate-start" placeholder="$" value="<?php echo isset($_POST['tq-s6-rate-start']) ? $_POST['tq-s6-rate-start'] : '' ?>" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" />
        </div>

        <div class="input-wrapper half-width second-col">
          <label for="tq-s6-rate-end">Base Rate of Pay - End</label>
          <input type="text" name="tq-s6-rate-end" id="tq-s6-rate-end" placeholder="$" value="<?php echo isset($_POST['tq-s6-rate-end']) ? $_POST['tq-s6-rate-end'] : '' ?>" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" />
        </div>

        <div class="input-wrapper">
          <label for="tq-s6-supervisor">Supervisor</label>
          <input type="text" name="tq-s6-supervisor" id="tq-s6-supervisor" placeholder="Name and Title" value="<?php echo isset($_POST['tq-s6-supervisor']) ? $_POST['tq-s6-supervisor'] : '' ?>" />
        </div>

        <div class="input-wrapper">
          <label for="tq-s6-duties">Description of Job Duties</label>
          <textarea name="tq-s6-duties" id="tq-s6-duties" placeholder="Job Duties"><?php echo isset($_POST['tq-s6-duties']) ? $_POST['tq-s6-duties'] : '' ?></textarea>
        </div>

        <div class="input-wrapper">
          <label for="tq-s6-reason-left">Reason for Leaving</label>
          <textarea name="tq-s6-reason-left" id="tq-s6-reason-left" placeholder="Reason for Leaving"><?php echo isset($_POST['tq-s6-reason-left']) ? $_POST['tq-s6-reason-left'] : '' ?></textarea>
        </div>

      </div>
      <div class="section-advance-container"><a href="#section-seven">Advance to next section <span class="fa fa-arrow-down"></span></a></div>
    </div>

<?php // SECTION SEVEN | START ?>

    <div id="section-seven" class="online-application-sections section-seven">
      <div class="section-inner-container">
        <h3>References</h3>
        <p class="section-intro">Professional/work references that we may contact, please do not list friends or family.</p>

        <div class="input-wrapper">
          <label for="tq-s7-r1-name">First Reference</label>
          <input type="text" name="tq-s7-r1-name" id="tq-s7-r1-name" placeholder="Name" value="<?php echo isset($_POST['tq-s7-r1-name']) ? $_POST['tq-s7-r1-name'] : '' ?>" />
        </div>

        <div class="input-wrapper">
          <label for="tq-s7-r1-email">Email</label>
          <input type="email" name="tq-s7-r1-email" id="tq-s7-r1-email" placeholder="Email" value="<?php echo isset($_POST['tq-s7-r1-email']) ? $_POST['tq-s7-r1-email'] : '' ?>" />
        </div>

        <div class="input-wrapper half-width first-col">
          <label for="tq-s7-r1-phone">Phone Number</label>
          <input type="tel" name="tq-s7-r1-phone" id="tq-s7-r1-phone" placeholder="Phone Number" value="<?php echo isset($_POST['tq-s7-r1-phone']) ? $_POST['tq-s7-r1-phone'] : '' ?>" />
        </div>

        <div class="input-wrapper half-width second-col">
          <label for="tq-s7-r1-relationship">Relationship</label>
          <input type="text" name="tq-s7-r1-relationship" id="tq-s7-r1-relationship" placeholder="Relationship" value="<?php echo isset($_POST['tq-s7-r1-relationship']) ? $_POST['tq-s7-r1-relationship'] : '' ?>" />
        </div>

        <div class="input-wrapper second-section-start">
          <label for="tq-s7-r2-name">Second Reference</label>
          <input type="text" name="tq-s7-r2-name" id="tq-s7-r2-name" placeholder="Name" value="<?php echo isset($_POST['tq-s7-r2-name']) ? $_POST['tq-s7-r2-name'] : '' ?>" />
        </div>

        <div class="input-wrapper">
          <label for="tq-s7-r2-email">Email</label>
          <input type="email" name="tq-s7-r2-email" id="tq-s7-r2-email" placeholder="Email" value="<?php echo isset($_POST['tq-s7-r2-email']) ? $_POST['tq-s7-r2-email'] : '' ?>" />
        </div>

        <div class="input-wrapper half-width first-col">
          <label for="tq-s7-r2-phone">Phone Number</label>
          <input type="tel" name="tq-s7-r2-phone" id="tq-s7-r2-phone" placeholder="Phone Number" value="<?php echo isset($_POST['tq-s7-r2-phone']) ? $_POST['tq-s7-r2-phone'] : '' ?>" />
        </div>

        <div class="input-wrapper half-width second-col">
          <label for="tq-s7-r2-relationship">Relationship</label>
          <input type="text" name="tq-s7-r2-relationship" id="tq-s7-r2-relationship" placeholder="Relationship" value="<?php echo isset($_POST['tq-s7-r2-relationship']) ? $_POST['tq-s7-r2-relationship'] : '' ?>" />
        </div>

        <div class="input-wrapper second-section-start">
          <label for="tq-s7-r3-name">Third Reference</label>
          <input type="text" name="tq-s7-r3-name" id="tq-s7-r3-name" placeholder="Name" value="<?php echo isset($_POST['tq-s7-r3-name']) ? $_POST['tq-s7-r3-name'] : '' ?>" />
        </div>

        <div class="input-wrapper">
          <label for="tq-s7-r3-email">Email</label>
          <input type="email" name="tq-s7-r3-email" id="tq-s7-r3-email" placeholder="Email" value="<?php echo isset($_POST['tq-s7-r3-email']) ? $_POST['tq-s7-r3-email'] : '' ?>" />
        </div>

        <div class="input-wrapper half-width first-col">
          <label for="tq-s7-r3-phone">Phone Number</label>
          <input type="tel" name="tq-s7-r3-phone" id="tq-s7-r3-phone" placeholder="Phone Number" value="<?php echo isset($_POST['tq-s7-r3-phone']) ? $_POST['tq-s7-r3-phone'] : '' ?>" />
        </div>

        <div class="input-wrapper half-width second-col">
          <label for="tq-s7-r3-relationship">Relationship</label>
          <input type="text" name="tq-s7-r3-relationship" id="tq-s7-r3-relationship" placeholder="Relationship" value="<?php echo isset($_POST['tq-s7-r3-relationship']) ? $_POST['tq-s7-r3-relationship'] : '' ?>" />
        </div>
        
        <div class="clear-left"></div>
        
      </div>
      <div class="section-advance-container"><a href="#section-eight">Advance to next section <span class="fa fa-arrow-down"></span></a></div>
    </div>

<?php // SECTION EIGHT | START ?>

    <div id="section-eight" class="online-application-sections section-eight">
      <div class="section-inner-container">
        <h3>Pre-Employment Certification</h3>

        <div class="input-wrapper radio-input-wrapper">
          <label for="tq-s8-terms-one" class="hidden-label">Terms One</label>
          <p>Atlantic Residential is an Equal Opportunity Employer. Applicants for all openings are welcome and will be considered without regard to race, color, religion, national origin, sex, age, sexual orientation, physical or mental disability, or any other basis protected by state, federal or local law. It is the intent of Atlantic Residential to comply with all applicable federal, state and local legislation concerning equal opportunity in employment. I also understand that this application is only valid for the position applied for at present and that Atlantic Residential is not obligated to retain or consider this application for future openings.</p>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s8-terms-one" value="I agree" required/> I agree
          </div>
        </div>

        <div class="input-wrapper radio-input-wrapper second-section-start">
          <label for="tq-s8-terms-two" class="hidden-label">Terms Two</label>
          <p>I certify that the facts set forth in this Application for Employment are true and complete to the best of my knowledge. I understand that if I am employed, false statements, omissions or misrepresentations may result in my dismissal. I authorize the Employer to make an investigation of any of the facts set forth in this application and release the Employer from any liability. The employer may contact any listed references on this application.</p>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s8-terms-two" value="I agree" required/> I agree
          </div>
        </div>

        <div class="input-wrapper radio-input-wrapper second-section-start">
          <label for="tq-s8-terms-three" class="hidden-label">Terms Three</label>
          <p>I agree to submit to legally permissible drug and/or alcohol testing and a background check upon request by Atlantic Residential. I recognize that the results of these tests may be used to determine my employment or continued employment. I understand and expressly agree that if employed, storage areas provided for me (locker, desk, computer, etc.) are open to investigation by Atlantic Residential without prior notice to me.</p>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s8-terms-three" value="I agree" required/> I agree
          </div>
        </div>

        <div class="input-wrapper radio-input-wrapper second-section-start">
          <label for="tq-s8-terms-four" class="hidden-label">Terms Three</label>
          <p>I understand that neither the completion of this application nor any other part of my consideration for employment establishes any obligation for Atlantic Residential to hire me. If I am hired, I acknowledge and understand that the company is an “at will” employer. Therefore, any employee (regular, temporary, or other type of category employee) may resign at any time, just as the employer may terminate the employment relationship with any employee at any time, with or without cause, with or without notice to the other party.  I understand that no representative of Atlantic Residential has the authority to make any assurance to the contrary.</p>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s8-terms-four" value="I agree" required/> I agree
          </div>
        </div>

        <div class="input-wrapper radio-input-wrapper second-section-start">
          <label for="tq-s8-digital-signature" class="hidden-label">Digital Signature</label>
          <p>My signature below certifies that I have read and understand the foregoing and to the best of my knowledge and belief, the information on this form is true and correct.</p>
          <p>My signature below also certifies that I agree to be bound by the terms and conditions stated in this application. This application contains all the understandings and agreements between me and Atlantic Residential concerning the nature of my employment, if any, by Atlantic Residential and supersedes all prior and/or contemporaneous practices, oral or written agreements, understandings, statements, representations and promises, express or implied, between me and Atlantic Residential. I understand and agree that, except as noted above, no person who is either an agent or employee of Atlantic Residential may modify, delete, vary or contradict, whether orally or in writing, the terms and conditions set forth herein.</p>
          <input type="text" name="tq-s8-digital-signature" id="tq-s8-digital-signature" placeholder="Digital Signature" value="" required/>
        </div>

        <div class="input-wrapper half-width first-col">
          <label for="tq-s8-digital-signature-date" class="hidden-label">Digital Signature Date</label>
          <input type="text" name="tq-s8-digital-signature-date" id="tq-s8-digital-signature-date" placeholder="mm/dd/yyyy" value="<?php echo date('m/d/Y'); ?>" required/>
        </div>

        <div class="input-wrapper" >
          <?php echo do_shortcode('[torque_recaptcha]'); ?>
        </div>

        <div class="input-wrapper submit-btn" >
          <button type="submit" class="white">Submit</button>
        </div>
      </div>
    </div>
  </form>

</div>
