<?php

if (isset($_POST['tq-online-application-form'])) {

  // Retrieve notification email. Must be done here, before the 'try' statement, as it could be used in multiple places.
  $notification_email = get_field( 'notification_email' );
  $admin_email = ( $notification_email != '' ? $notification_email : get_option( 'admin_email' ) );

  // form was submitted
  try {
    
    // Check the text fields
    $req_text_fields = array(
      // SECTION 1
      $_POST['tq-s1-name-first'],
      $_POST['tq-s1-name-last'],
      $_POST['tq-s1-address'],
      $_POST['tq-s1-city'],
      $_POST['tq-s1-state'],
      $_POST['tq-s1-zipcode'],
      $_POST['tq-s1-phone'],
      $_POST['tq-s1-email'],
      // SECTION 8
      $_POST['tq-s8-digital-signature'],
      $_POST['tq-s8-digital-signature-date'],
    );
    foreach ($req_text_fields as $req_text_field) {
      if (Atlantic_Residential_Job_Application_CPT::prep_input($req_text_field) == "") {
        throw new Exception('All Personal Information fields are required. Please check these fields and re-submit the form.');
        break;
      }
    }

    // Check the radio fields
    if (
      !isset($_POST['tq-s8-terms-one'])   ||
      !isset($_POST['tq-s8-terms-two'])   ||
      !isset($_POST['tq-s8-terms-three'])
    ) {
      throw new Exception('All Pre-Employment Certification fields are required. Please check these fields and re-submit the form.');
    }

    // Check the _wpnonce field
    if (
      ! isset($_POST['_wpnonce']) ||
      ! wp_verify_nonce( $_POST['_wpnonce'], 'submit_online_application_form' )
    ) {
      // couldnt verify nonce
      throw new Exception('Form failed validation');
    }

    if ( ! class_exists('Torque_Job_Application_CPT') ) {
      // job applications cpt failed to load
      throw new Exception('Couldnt find plugin class');
    }

    // If made it this far, form is validated - can save the application post!
    $application_id = Atlantic_Residential_Job_Application_CPT::save_application( $_POST['tq-form-stage'], $_POST );

    if ( ! $application_id ) {
      throw new Exception();
    }

    // lets upload the resume pdf
    // require_once( ABSPATH . 'wp-admin/includes/image.php' );
  	// require_once( ABSPATH . 'wp-admin/includes/file.php' );
  	// require_once( ABSPATH . 'wp-admin/includes/media.php' );
    // $media_id = media_handle_upload( 'tq-resume', $application_id );

    // if ( ! $media_id || is_wp_error($media_id) ) {
    //   throw new Exception('Failed uploading resume. ');
    // }

    // Atlantic_Residential_Job_Application_CPT::attach_resume($media_id, $application_id);

    $message = array(
      'success' => true,
      'message' => 'Thank you for your Online Application. Your Application ID is '.$application_id . '. We\'ll be in touch shortly.'
    );

    // send admin email notification
    $email_result = Atlantic_Residential_Job_Application_CPT::send_admin_notification( $_POST['tq-form-stage'], $application_id, $admin_email, $_POST );

    // Check email was sent correctly...
    if ( ! $email_result ) {
      throw new Exception('Your Online Application has been successfully submitted, but the admin notification has failed to send. Your Application ID is '.$application_id . '. Please contact us directly, quoting your Application ID, via: <a href="mailto:' . $admin_email .'">' . $admin_email . '</a>. Sorry for any inconvenience this causes.' );
    }

  } catch (Exception $e) {
    $message = array(
      'success' => false,
      'message' => $e->getMessage() !== '' ? $e->getMessage() : 'Something went wrong. Please try refreshing the page and re-sending the Online Application. If you continue to run into issues please contact us directly via: <a href="mailto:' . $admin_email .'">' . $admin_email . '</a>. Sorry for any inconvenience this causes.'
    );
  }
}

include locate_template( 'parts/forms/form-online-application-template.php', false, false);

?>
