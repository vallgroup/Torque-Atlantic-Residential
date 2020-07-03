<?php

if (isset($_POST['tq-careers-form'])) {

  // Retrieve notification email. Must be done here, before the 'try' statement, as it could be used in multiple places.
  $notification_email = get_field( 'notification_email' );
  $admin_email = ( $notification_email != '' ? $notification_email : get_option( 'admin_email' ) );

  // form was submitted
  try {
    if (
      ! $_POST['tq-name']       ||
      ! $_POST['tq-email']      ||
      ! $_POST['tq-phone']      ||
      ! $_POST['tq-state']      ||
      ! $_POST['tq-zipcode']    ||
      ! $_POST['tq-intro']      ||
      ! $_POST['tq-job']        ||
      ! isset($_FILES['tq-resume'])
    ) {
      throw new Exception('All form fields are required. Please check all fields and re-submit the form.');
    }

    if (
      ! isset($_POST['_wpnonce']) ||
      ! wp_verify_nonce( $_POST['_wpnonce'], 'submit_careers_form' )
    ) {
      // couldnt verify nonce
      throw new Exception('Form failed validation');
    }

    if ( ! class_exists('Torque_Job_Application_CPT') ) {
      // job applications cpt failed to load
      throw new Exception('Couldnt find plugin class');
    }

    // form is validated - can save the application post

    $application_id = Atlantic_Residential_Job_Application_CPT::save_application( $_POST['tq-form-stage'], $_POST );

    if ( ! $application_id ) {
      throw new Exception();
    }

    // lets upload the resume pdf
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
  	require_once( ABSPATH . 'wp-admin/includes/file.php' );
  	require_once( ABSPATH . 'wp-admin/includes/media.php' );
    $media_id = media_handle_upload( 'tq-resume', $application_id );

    if ( ! $media_id || is_wp_error($media_id) ) {
      throw new Exception('Thank you for your application, however, unfortunately, your resume failed to upload. Please email it to us directly via: <a href="mailto:' . $admin_email .'">' . $admin_email . '</a>. Sorry for any inconvenience this causes.');
    }

    Atlantic_Residential_Job_Application_CPT::link_resume_to_application( $media_id, $application_id );

    $message = array(
      'success' => true,
      'message' => 'Thank you for your application. Your application ID is '.$application_id . '. We\'ll be in touch shortly.'
    );

    // send admin email notification
    $email_result = Atlantic_Residential_Job_Application_CPT::send_admin_notification( $_POST['tq-form-stage'], (string) $application_id, $media_id, $admin_email, $_POST );

    // Check email was sent correctly...
    if ( ! $email_result ) {
      throw new Exception('Your application has been successfully submitted, but the admin notification has failed to send. Please contact us directly via: <a href="mailto:' . $admin_email .'">' . $admin_email . '</a>. Sorry for any inconvenience this causes.' );
    }

  } catch (Exception $e) {
    $message = array(
      'success' => false,
      'message' => $e->getMessage() !== '' ? $e->getMessage() : 'Something went wrong. Please try refreshing the page and re-sending the application. If you continue to run into issues please contact us directly via: <a href="mailto:' . $admin_email .'">' . $admin_email . '</a>. Sorry for any inconvenience this causes.'
    );
  }
}

include locate_template( 'parts/forms/form-careers-template.php', false, false);

?>
