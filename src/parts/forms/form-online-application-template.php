<div id="online-application-form" class="online-application-form">

  <?php if (isset($message)) {
    $success_class = ! $message['success'] ? 'error' : '';
    ?>
    <div class="form-message <?php echo $success_class; ?>">
      <?php echo $message['message']; ?>
    </div>
  <?php } ?>

  <form method="post" action="#online-application-form" enctype="multipart/form-data">

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
          <input type="text" name="tq-s1-name-first" id="tq-s1-name-first" placeholder="First Name" value="<?php echo isset($_POST['tq-s1-name-first']) ? $_POST['tq-s1-name-first'] : '' ?>"/>
        </div>

        <div class="input-wrapper half-width second-col">
          <label for="tq-s1-name-last">Last Name</label>
          <input type="text" name="tq-s1-name-last" id="tq-s1-name-last" placeholder="Last Name" value="<?php echo isset($_POST['tq-s1-name-last']) ? $_POST['tq-s1-name-last'] : '' ?>"/>
        </div>

        <div class="input-wrapper">
          <label for="tq-s1-address">Address</label>
          <input type="text" name="tq-s1-address" id="tq-s1-address" placeholder="Address" value="<?php echo isset($_POST['tq-s1-address']) ? $_POST['tq-s1-address'] : '' ?>"/>
        </div>

        <div class="input-wrapper">
          <label for="tq-s1-address-2">Address 2</label>
          <input type="text" name="tq-s1-address-2" id="tq-s1-address-2" placeholder="Address 2" value="<?php echo isset($_POST['tq-s1-address-2']) ? $_POST['tq-s1-address-2'] : '' ?>"/>
        </div>

        <div class="input-wrapper half-width first-col">
          <label for="tq-s1-city">City</label>
          <input type="text" name="tq-s1-city" id="tq-s1-city" placeholder="City" value="<?php echo isset($_POST['tq-s1-city']) ? $_POST['tq-s1-city'] : '' ?>"/>
        </div>

        <div class="input-wrapper half-width second-col">
          <div class="input-wrapper half-width first-col">
            <label for="tq-s1-state">State</label>
            <input type="text" name="tq-s1-state" id="tq-s1-state" placeholder="State" value="<?php echo isset($_POST['tq-s1-state']) ? $_POST['tq-s1-state'] : '' ?>"/>
          </div>

          <div class="input-wrapper half-width second-col">
            <label for="tq-s1-zipcode">Zip Code</label>
            <input type="text" name="tq-s1-zipcode" id="tq-s1-zipcode" placeholder="Zip Code" value="<?php echo isset($_POST['tq-s1-zipcode']) ? $_POST['tq-s1-zipcode'] : '' ?>"/>
          </div>
        </div>

        <div class="input-wrapper half-width first-col">
          <label for="tq-s1-phone">Phone Number</label>
          <input type="tel" name="tq-s1-phone" id="tq-s1-phone" placeholder="Phone Number" value="<?php echo isset($_POST['tq-s1-phone']) ? $_POST['tq-s1-phone'] : '' ?>"/>
        </div>

        <div class="input-wrapper half-width second-col">
          <label for="tq-s1-emai">Email Address</label>
          <input type="email" name="tq-s1-email" id="tq-s1-email" placeholder="Email Address" value="<?php echo isset($_POST['tq-s1-email']) ? $_POST['tq-s1-email'] : '' ?>"/>
        </div>

        <div class="input-wrapper">
          <label for="tq-s1-legal-right" class="hidden-label">Legal Rights</label>
          <p>After employment, can you submit verification of your legal right to work in the United States?</p>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s1-legal-right" value="yes"/> Yes
          </div>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s1-legal-right" value="no"/> No
          </div>
        </div>

        <div class="input-wrapper">
          <label for="tq-s1-alternate-names" class="hidden-label">Alternate Names?</label>
          <p>Have you ever used any other name? If yes, please explain.</p>
          <textarea name="tq-s1-alternate-names" id="tq-s1-alternate-names" placeholder="Previous Names and Explanation" value="<?php echo isset($_POST['tq-s1-alternate-names']) ? $_POST['tq-s1-alternate-names'] : '' ?>"></textarea>
        </div>

        <div class="input-wrapper">
          <label for="tq-s1-over-18" class="hidden-label">Are You Over 18?</label>
          <p>Are you 18 years old or over?</p>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s1-over-18" value="yes"/> Yes
          </div>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s1-over-18" value="no"/> No
          </div>
        </div>

        <div class="input-wrapper">
          <label for="tq-s1-prior-convictions" class="hidden-label">Prior Convictions?</label>
          <p>Have you ever been convicted of a felony, misdemeanor, child abuse or sex-related crimes? If yes, please explain.</p>
          <textarea name="tq-s1-prior-convictions" id="tq-s1-prior-convictions" placeholder="Conviction(s) and Explanation" value="<?php echo isset($_POST['tq-s1-prior-convictions']) ? $_POST['tq-s1-prior-convictions'] : '' ?>"></textarea>
        </div>

        <div class="input-wrapper">
          <label for="tq-s1-pending-legal-charges" class="hidden-label">Pending Legal Charges?</label>
          <p>Do you have any pending legal charges against you? If yes, please explain.</p>
          <textarea name="tq-s1-pending-legal-charges" id="tq-s1-pending-legal-charges" placeholder="Legal Charges and Explanation" value="<?php echo isset($_POST['tq-s1-pending-legal-charges']) ? $_POST['tq-s1-pending-legal-charges'] : '' ?>"></textarea>
        </div>

      </div>
      <div class="section-advance-container"><a href="#section-two">Advance to next section <span class="dashicons dashicons-arrow-down-alt"></span></a></div>
    </div>

    <div id="section-two" class="online-application-sections section-two">
      <div class="section-inner-container">
        <h3>Desired Employment</h3>

        <div class="input-wrapper">
          <label for="tq-s2-contact-employer" class="hidden-label">Contact Current Employer?</label>
          <p>If yes, may we contact your present employer?</p>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s2-contact-employer" value="yes"/> Yes
          </div>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s2-contact-employer" value="no"/> No
          </div>
        </div>

      </div>
      <div class="section-advance-container"><a href="#section-three">Advance to next section <span class="dashicons dashicons-arrow-down-alt"></span></a></div>
    </div>

    <div id="section-three" class="online-application-sections section-three">
      <div class="section-inner-container">
        <h3>Education and Training</h3>
      </div>
      <div class="section-advance-container"><a href="#section-four">Advance to next section <span class="dashicons dashicons-arrow-down-alt"></span></a></div>
    </div>

    <div id="section-four" class="online-application-sections section-four">
      <div class="section-inner-container">
        <h3>Employment History</h3>
        <h4>Current or Most Recent Employment</h4>
      </div>
      <div class="section-advance-container"><a href="#section-five">Advance to next section <span class="dashicons dashicons-arrow-down-alt"></span></a></div>
    </div>

    <div id="section-five" class="online-application-sections section-five">
      <div class="section-inner-container">
        <h4>Second Most Recent Employment</h4>
      </div>
      <div class="section-advance-container"><a href="#section-six">Advance to next section <span class="dashicons dashicons-arrow-down-alt"></span></a></div>
    </div>

    <div id="section-six" class="online-application-sections section-six">
      <div class="section-inner-container">
        <h4>Third Most Recent Employment</h4>
      </div>
      <div class="section-advance-container"><a href="#section-seven">Advance to next section <span class="dashicons dashicons-arrow-down-alt"></span></a></div>
    </div>

    <div id="section-seven" class="online-application-sections section-seven">
      <div class="section-inner-container">
        <h3>References</h3>
        <p>Professional/work references that we may contact, please do not list friends or family.</p>
      </div>
      <div class="section-advance-container"><a href="#section-eight">Advance to next section <span class="dashicons dashicons-arrow-down-alt"></span></a></div>
    </div>

    <div id="section-eight" class="online-application-sections section-eight">
      <div class="section-inner-container">
        <h3>Pre-Employment Certification</h3>

        <div class="input-wrapper">
          <label for="tq-s8-terms-one" class="hidden-label">Terms One</label>
          <p>Atlantic Residential is an Equal Opportunity Employer. Applicants for all openings are welcome and will be considered without regard to race, color, religion, national origin, sex, age, sexual orientation, physical or mental disability, or any other basis protected by state, federal or local law. It is the intent of the association to comply with all applicable federal, state and local legislation concerning equal opportunity in employment. Proof of citizenship or authorization for employment in the USA is required before final selection. Atlantic Residential is committed to protecting the health and safety of our employees. I also understand that this application is only valid for the position applied for at present and that Atlantic Residential is not obligated to retain or consider this application for future openings.</p>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s8-terms-one" value="I agree"/> I agree
          </div>
        </div>

        <div class="input-wrapper">
          <label for="tq-s8-terms-two" class="hidden-label">Terms Two</label>
          <p>I agree to submit to legally permissible drug and/or alcohol testing and a background check upon request by Atlantic Residential. I recognize that the results of these tests may be used to determine my employment or continued employment. I understand and expressly agree that if employed, storage areas provided for me (locker, desk, computer, etc.) are open to investigation by Atlantic Residential without prior notice to me.</p>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s8-terms-two" value="I agree"/> I agree
          </div>
        </div>

        <div class="input-wrapper">
          <label for="tq-s8-terms-three" class="hidden-label">Terms Three</label>
          <p>If I am employed by Atlantic Residential, I understand my employment is ‘at-will’ and
          can be terminated, with or without cause and with or without notice, at any time at the option of Atlantic Residential or myself. I understand that, other than the President of Atlantic Residential, no manager, supervisor or representative of Atlantic Residential has authority to enter into any agreement for employment for any specific period of time, or to make any agreement contrary to the foregoing. Only the President of Atlantic Residential has the authority to make any agreement contrary to the foregoing and then only in writing. I further expressly agree that, with respect to the ‘at-will’ employment relationship, this constitutes the full, complete and final expression of the parties’ intent concerning the nature of any employment relationship between myself and Atlantic Residential.</p>
          <div class="radio-item-wrapper">
            <input type="radio" name="tq-s8-terms-three" value="I agree"/> I agree
          </div>
        </div>

        <div class="input-wrapper">
          <label for="tq-s8-digital-signature" class="hidden-label">Digital Signature</label>
          <p>My signature below certifies that I have read and understand the foregoing and to the best of my knowledge and belief, the information on this form is true and correct.</p>
          <p>My signature below also certifies that I agree to be bound by the terms and conditions stated in this application. This application contains all the understandings and agreements between me and Atlantic Residential concerning the nature of my employment, if any, by Atlantic Residential and supersedes all prior and/or contemporaneous practices, oral or written agreements, understandings, statements, representations and promises, express or implied, between me and Atlantic Residential. I understand and agree that, except as noted above, no person who is either an agent or employee of Atlantic Residential may modify, delete, vary or contradict, whether orally or in writing, the terms and conditions set forth herein.</p>
          <input type="text" name="tq-s8-digital-signature" id="tq-s8-digital-signature" placeholder="Digital Signature" value=""/>
        </div>

        <div class="input-wrapper half-width first-col">
          <label for="tq-s8-digital-signature-date" class="hidden-label">Digital Signature Date</label>
          <input type="date" name="tq-s8-digital-signature-date" id="tq-s8-digital-signature-date" value=""/>
        </div>

        <div class="input-wrapper" >
          <?php echo do_shortcode('[torque_recaptcha]'); ?>
        </div>
        <button type="submit" class="white">Submit</button>
      </div>
    </div>
  </form>

</div>
