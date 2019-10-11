<?php

class Atlantic_Residential_Job_Application_CPT
{
	public static $JOB_APP_PROPERTY_TYPE_TAX_SLUG = 'atlantic_job_app_stage';

	public function __construct()
	{
		add_filter(Torque_Job_Application_CPT::$PUBLIC_FILTER_HOOK, function () {
			return true;
		});

		add_action('init', array($this, 'add_job_app_listing_taxonomies'));
		add_action('acf/init', array($this, 'add_job_app_acf_metaboxes'));
		add_action('restrict_manage_posts', array($this, 'filter_job_apps_by_taxonomies'), 10, 2);
		add_action('template_redirect', array($this, 'redirect_post_single_view'));
	}

	function add_job_app_listing_taxonomies()
	{
		register_taxonomy(
			self::$JOB_APP_PROPERTY_TYPE_TAX_SLUG,
			Torque_Job_Application_CPT::$job_applications_labels['post_type_name'],
			array(
				'label'        => 'Application Stages',
				'labels'       => array(
					'singular_name'   => 'Application Stage'
				),
				'hierarchical' => true,
				'show_admin_column' => true,
				'show_in_rest' => true
			)
		);
	}

	public function redirect_post_single_view()
	{
		// Don't allow these job applications to be visible from the frontend -- they contain sensitive data about applicants...!
		$queried_post_type = get_query_var('post_type');
		if (is_single() && $queried_post_type == Torque_Job_Application_CPT::$job_applications_labels['post_type_name']) {
			wp_redirect(home_url(), 301);
			exit;
		}
	}

	/**
	 * Render the CPT filters on the admin UI
	 */
	function filter_job_apps_by_taxonomies($post_type, $which)
	{
		// Apply this only on a specific post type
		if (Torque_Job_Application_CPT::$job_applications_labels['post_type_name'] !== $post_type)
			return;

		// A list of taxonomy slugs to filter by
		$taxonomies = array(self::$JOB_APP_PROPERTY_TYPE_TAX_SLUG);

		foreach ($taxonomies as $taxonomy_slug) {

			// Retrieve taxonomy data
			$taxonomy_obj = get_taxonomy($taxonomy_slug);
			$taxonomy_name = $taxonomy_obj->labels->name;

			// Retrieve taxonomy terms
			$terms = get_terms($taxonomy_slug);

			// Display filter HTML
			echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
			echo '<option value="">' . sprintf(esc_html__('All %s', 'text_domain'), $taxonomy_name) . '</option>';
			foreach ($terms as $term) {
				printf(
					'<option value="%1$s" %2$s>%3$s (%4$s)</option>',
					$term->slug,
					((isset($_GET[$taxonomy_slug]) && ($_GET[$taxonomy_slug] == $term->slug)) ? ' selected="selected"' : ''),
					$term->name,
					$term->count
				);
			}
			echo '</select>';
		}
	}

	public static function save_application(string $application_stage, array $application_data)
	{
		// Get the category ID, so we can assign the Job Application post to the correct category
		$stage_tax_obj = get_term_by('slug', 'stage-' . $application_stage, self::$JOB_APP_PROPERTY_TYPE_TAX_SLUG);

		switch ($application_stage) {

				// Stage 1 Job Application
			case "1":

				$name = $application_data['tq-name'];
				$email = $application_data['tq-email'];
				$phone = $application_data['tq-phone'];
				$intro = $application_data['tq-intro'];
				$state = $application_data['tq-state'];
				$zipcode = $application_data['tq-zipcode'];
				$job_title = $application_data['tq-job'];

				$application = array(
					'post_title'    => $name,
					'post_content'  => $intro,
					'post_status'   => 'publish',
					'post_type'			=> Torque_Job_Application_CPT::$job_applications_labels['post_type_name']
				);

				// Insert the post into the database
				$application_id = wp_insert_post($application);

				// Assign the correct Job Application Stage number
				wp_set_object_terms($application_id, $stage_tax_obj->term_id, self::$JOB_APP_PROPERTY_TYPE_TAX_SLUG);

				// Add ACF metadata to post
				update_field('field_5ca514f92f6b0', $email, $application_id);
				update_field('field_5ca5151a2f6b1', $phone, $application_id);
				update_field('field_5ca5151a2fj2d', $state, $application_id);
				update_field('field_5ca5151an24j2d', $zipcode, $application_id);
				update_field('field_5ca5151amxj23', $job_title, $application_id);

				return $application_id;
				break; // Defensive programming...

				// Stage 2 Job Application
			case "2":

				$application = array(
					'post_title'    => $application_data['tq-s1-name-first'] . ' ' . $application_data['tq-s1-name-last'],
					'post_status'   => 'publish',
					'post_type'			=> Torque_Job_Application_CPT::$job_applications_labels['post_type_name']
				);

				// Insert the post into the database
				$application_id = wp_insert_post($application);

				// Assign the correct Job Application Stage number
				wp_set_object_terms($application_id, $stage_tax_obj->term_id, self::$JOB_APP_PROPERTY_TYPE_TAX_SLUG);

				// Add ACF metadata to post
				// Section 1 -- 14 items
				update_field('field_5d48d736a9ff5', isset($application_data['tq-s1-name-first']) ? $application_data['tq-s1-name-first'] : '', $application_id);
				update_field('field_5d48d736aa0d6', isset($application_data['tq-s1-name-last']) ? $application_data['tq-s1-name-last'] : '', $application_id);
				update_field('field_5d48d736aa1cb', isset($application_data['tq-s1-address']) ? $application_data['tq-s1-address'] : '', $application_id);
				update_field('field_5d48d736aa29d', isset($application_data['tq-s1-address-2']) ? $application_data['tq-s1-address-2'] : '', $application_id);
				update_field('field_5d48d736aa356', isset($application_data['tq-s1-city']) ? $application_data['tq-s1-city'] : '', $application_id);
				update_field('field_5d48d736aa411', isset($application_data['tq-s1-state']) ? $application_data['tq-s1-state'] : '', $application_id);
				update_field('field_5d48d736aa4e4', isset($application_data['tq-s1-zipcode']) ? $application_data['tq-s1-zipcode'] : '', $application_id);
				update_field('field_5d48d736aa5ca', isset($application_data['tq-s1-phone']) ? $application_data['tq-s1-phone'] : '', $application_id);
				update_field('field_5d48d736aa696', isset($application_data['tq-s1-email']) ? $application_data['tq-s1-email'] : '', $application_id);
				update_field('field_5d48d736aa772', isset($application_data['tq-s1-legal-right']) ? $application_data['tq-s1-legal-right'] : '', $application_id);
				update_field('field_5d48d736aa90d', isset($application_data['tq-s1-alternate-names']) ? $application_data['tq-s1-alternate-names'] : '', $application_id);
				update_field('field_5d48d736aab3a', isset($application_data['tq-s1-over-18']) ? $application_data['tq-s1-over-18'] : '', $application_id);
				update_field('field_5d48d736aad0f', isset($application_data['tq-s1-prior-convictions']) ? $application_data['tq-s1-prior-convictions'] : '', $application_id);
				update_field('field_5d48d736aaeee', isset($application_data['tq-s1-pending-legal-charges']) ? $application_data['tq-s1-pending-legal-charges'] : '', $application_id);
				// Section 2 -- 9 items
				update_field('field_5d48d876eaacb', isset($application_data['tq-s2-role']) ? $application_data['tq-s2-role'] : '', $application_id);
				update_field('field_5d48d876eaba6', isset($application_data['tq-s2-salary']) ? $application_data['tq-s2-salary'] : '', $application_id);
				update_field('field_5d48d876eac7b', isset($application_data['tq-s2-available']) ? $application_data['tq-s2-available'] : '', $application_id);
				update_field('field_5d48d876ead39', isset($application_data['tq-s2-employed']) ? $application_data['tq-s2-employed'] : '', $application_id);
				update_field('field_5d48d876eae33', isset($application_data['tq-s2-contact-employer']) ? $application_data['tq-s2-contact-employer'] : '', $application_id);
				update_field('field_5d48d876eaf0a', isset($application_data['tq-s2-supervisors-name']) ? $application_data['tq-s2-supervisors-name'] : '', $application_id);
				update_field('field_5d48d876eafe1', isset($application_data['tq-s2-supervisors-phone']) ? $application_data['tq-s2-supervisors-phone'] : '', $application_id);
				update_field('field_5d48d876eb0b2', isset($application_data['tq-s2-prior-atl-resi-employee']) ? $application_data['tq-s2-prior-atl-resi-employee'] : '', $application_id);
				update_field('field_5d48d876eb18f', isset($application_data['tq-s2-referral']) ? $application_data['tq-s2-referral'] : '', $application_id);
				// Section 3 -- 10 items
				update_field('field_5d48d8ff04a51', isset($application_data['tq-s3-highschool']) ? $application_data['tq-s3-highschool'] : '', $application_id);
				update_field('field_5d48d8ff04b2e', isset($application_data['tq-s3-university']) ? $application_data['tq-s3-university'] : '', $application_id);
				update_field('field_5d48d8ff04bd9', isset($application_data['tq-s3-uni-degree']) ? $application_data['tq-s3-uni-degree'] : '', $application_id);
				update_field('field_5d48d8ff04c81', isset($application_data['tq-s3-uni-major']) ? $application_data['tq-s3-uni-major'] : '', $application_id);
				update_field('field_5d48d8ff04d49', isset($application_data['tq-s3-graduate']) ? $application_data['tq-s3-graduate'] : '', $application_id);
				update_field('field_5d48d8ff04ec6', isset($application_data['tq-s3-grad-degree']) ? $application_data['tq-s3-grad-degree'] : '', $application_id);
				update_field('field_5d48d8ff04fe0', isset($application_data['tq-s3-grad-major']) ? $application_data['tq-s3-grad-major'] : '', $application_id);
				update_field('field_5d48d8ff050fa', isset($application_data['tq-s3-highest-degree']) ? $application_data['tq-s3-highest-degree'] : '', $application_id);
				update_field('field_5d48d8ff051e5', isset($application_data['tq-s3-extras']) ? $application_data['tq-s3-extras'] : '', $application_id);
				update_field('field_5d48d8ff052ce', isset($application_data['tq-s3-languages']) ? $application_data['tq-s3-languages'] : '', $application_id);
				// Section 4 -- 13 items
				update_field('field_5d48d97c03398', isset($application_data['tq-s4-name']) ? $application_data['tq-s4-name'] : '', $application_id);
				update_field('field_5d48d97c0352c', isset($application_data['tq-s4-phone']) ? $application_data['tq-s4-phone'] : '', $application_id);
				update_field('field_5d48d97c03611', isset($application_data['tq-s4-address']) ? $application_data['tq-s4-address'] : '', $application_id);
				update_field('field_5d48d97c03729', isset($application_data['tq-s4-address-2']) ? $application_data['tq-s4-address-2'] : '', $application_id);
				update_field('field_5d48d97c03835', isset($application_data['tq-s4-city']) ? $application_data['tq-s4-city'] : '', $application_id);
				update_field('field_5d48d97c03be0', isset($application_data['tq-s4-state']) ? $application_data['tq-s4-state'] : '', $application_id);
				update_field('field_5d48d97c03d0e', isset($application_data['tq-s4-zipcode']) ? $application_data['tq-s4-zipcode'] : '', $application_id);
				update_field('field_5d48d97c03e6a', isset($application_data['tq-s4-job-titles']) ? $application_data['tq-s4-job-titles'] : '', $application_id);
				update_field('field_5d48d97c03f51', isset($application_data['tq-s4-rate-start']) ? $application_data['tq-s4-rate-start'] : '', $application_id);
				update_field('field_5d48d97c04031', isset($application_data['tq-s4-rate-end']) ? $application_data['tq-s4-rate-end'] : '', $application_id);
				update_field('field_5d48d97c04111', isset($application_data['tq-s4-supervisor']) ? $application_data['tq-s4-supervisor'] : '', $application_id);
				update_field('field_5d48d97c041f0', isset($application_data['tq-s4-duties']) ? $application_data['tq-s4-duties'] : '', $application_id);
				update_field('field_5d48d97c042e4', isset($application_data['tq-s4-reason-left']) ? $application_data['tq-s4-reason-left'] : '', $application_id);
				// Section 5 -- 13 items
				update_field('field_5d48da85159e4', isset($application_data['tq-s5-name']) ? $application_data['tq-s5-name'] : '', $application_id);
				update_field('field_5d48da8515acb', isset($application_data['tq-s5-phone']) ? $application_data['tq-s5-phone'] : '', $application_id);
				update_field('field_5d48da8515bba', isset($application_data['tq-s5-address']) ? $application_data['tq-s5-address'] : '', $application_id);
				update_field('field_5d48da8515c7f', isset($application_data['tq-s5-address-2']) ? $application_data['tq-s5-address-2'] : '', $application_id);
				update_field('field_5d48da8515fee', isset($application_data['tq-s5-city']) ? $application_data['tq-s5-city'] : '', $application_id);
				update_field('field_5d48da85160cc', isset($application_data['tq-s5-state']) ? $application_data['tq-s5-state'] : '', $application_id);
				update_field('field_5d48da85161af', isset($application_data['tq-s5-zipcode']) ? $application_data['tq-s5-zipcode'] : '', $application_id);
				update_field('field_5d48da851627b', isset($application_data['tq-s5-job-titles']) ? $application_data['tq-s5-job-titles'] : '', $application_id);
				update_field('field_5d48da8516339', isset($application_data['tq-s5-rate-start']) ? $application_data['tq-s5-rate-start'] : '', $application_id);
				update_field('field_5d48da8516413', isset($application_data['tq-s5-rate-end']) ? $application_data['tq-s5-rate-end'] : '', $application_id);
				update_field('field_5d48da85164d9', isset($application_data['tq-s5-supervisor']) ? $application_data['tq-s5-supervisor'] : '', $application_id);
				update_field('field_5d48da851659f', isset($application_data['tq-s5-duties']) ? $application_data['tq-s5-duties'] : '', $application_id);
				update_field('field_5d48da851667a', isset($application_data['tq-s5-reason-left']) ? $application_data['tq-s5-reason-left'] : '', $application_id);
				// Section 6 -- 13 items
				update_field('field_5d48dbda60742', isset($application_data['tq-s6-name']) ? $application_data['tq-s6-name'] : '', $application_id);
				update_field('field_5d48dbda6083d', isset($application_data['tq-s6-phone']) ? $application_data['tq-s6-phone'] : '', $application_id);
				update_field('field_5d48dbda60921', isset($application_data['tq-s6-address']) ? $application_data['tq-s6-address'] : '', $application_id);
				update_field('field_5d48dbda609ea', isset($application_data['tq-s6-address-2']) ? $application_data['tq-s6-address-2'] : '', $application_id);
				update_field('field_5d48dbda60acb', isset($application_data['tq-s6-city']) ? $application_data['tq-s6-city'] : '', $application_id);
				update_field('field_5d48dbda60bab', isset($application_data['tq-s6-state']) ? $application_data['tq-s6-state'] : '', $application_id);
				update_field('field_5d48dbda60c84', isset($application_data['tq-s6-zipcode']) ? $application_data['tq-s6-zipcode'] : '', $application_id);
				update_field('field_5d48dbda60d74', isset($application_data['tq-s6-job-titles']) ? $application_data['tq-s6-job-titles'] : '', $application_id);
				update_field('field_5d48dbda60e30', isset($application_data['tq-s6-rate-start']) ? $application_data['tq-s6-rate-start'] : '', $application_id);
				update_field('field_5d48dbda60f0c', isset($application_data['tq-s6-rate-end']) ? $application_data['tq-s6-rate-end'] : '', $application_id);
				update_field('field_5d48dbda61001', isset($application_data['tq-s6-supervisor']) ? $application_data['tq-s6-supervisor'] : '', $application_id);
				update_field('field_5d48dbda610e1', isset($application_data['tq-s6-duties']) ? $application_data['tq-s6-duties'] : '', $application_id);
				update_field('field_5d48dbda61223', isset($application_data['tq-s6-reason-left']) ? $application_data['tq-s6-reason-left'] : '', $application_id);
				// Section 7 -- 12 items
				update_field('field_5d48dd0dceb10', isset($application_data['tq-s7-r1-name']) ? $application_data['tq-s7-r1-name'] : '', $application_id);
				update_field('field_5d48dd18ceb11', isset($application_data['tq-s7-r1-email']) ? $application_data['tq-s7-r1-email'] : '', $application_id);
				update_field('field_5d48dd24ceb12', isset($application_data['tq-s7-r1-phone']) ? $application_data['tq-s7-r1-phone'] : '', $application_id);
				update_field('field_5d48dd33ceb13', isset($application_data['tq-s7-r1-relationship']) ? $application_data['tq-s7-r1-relationship'] : '', $application_id);
				update_field('field_5d48dd56ceb18', isset($application_data['tq-s7-r2-name']) ? $application_data['tq-s7-r2-name'] : '', $application_id);
				update_field('field_5d48dd43ceb15', isset($application_data['tq-s7-r2-email']) ? $application_data['tq-s7-r2-email'] : '', $application_id);
				update_field('field_5d48dd47ceb16', isset($application_data['tq-s7-r2-phone']) ? $application_data['tq-s7-r2-phone'] : '', $application_id);
				update_field('field_5d48dd4aceb17', isset($application_data['tq-s7-r2-relationship']) ? $application_data['tq-s7-r2-relationship'] : '', $application_id);
				update_field('field_5d48dd8dceb1a', isset($application_data['tq-s7-r3-name']) ? $application_data['tq-s7-r3-name'] : '', $application_id);
				update_field('field_5d48dd92ceb1b', isset($application_data['tq-s7-r3-email']) ? $application_data['tq-s7-r3-email'] : '', $application_id);
				update_field('field_5d48dd96ceb1c', isset($application_data['tq-s7-r3-phone']) ? $application_data['tq-s7-r3-phone'] : '', $application_id);
				update_field('field_5d48dd9cceb1d', isset($application_data['tq-s7-r3-relationship']) ? $application_data['tq-s7-r3-relationship'] : '', $application_id);
				// Section 8 -- 5 items
				update_field('field_5d48deaaecd5d', isset($application_data['tq-s8-terms-one']) ? $application_data['tq-s8-terms-one'] : '', $application_id);
				update_field('field_5d48df197f894', isset($application_data['tq-s8-terms-two']) ? $application_data['tq-s8-terms-two'] : '', $application_id);
				update_field('field_5d48df577fa9c', isset($application_data['tq-s8-terms-three']) ? $application_data['tq-s8-terms-three'] : '', $application_id);
				update_field('field_5da09bcc9028c', isset($application_data['tq-s8-terms-four']) ? $application_data['tq-s8-terms-four'] : '', $application_id);
				update_field('field_5d48df6e7fa9d', isset($application_data['tq-s8-digital-signature']) ? $application_data['tq-s8-digital-signature'] : '', $application_id);
				update_field('field_5d48df847fa9e', isset($application_data['tq-s8-digital-signature-date']) ? $application_data['tq-s8-digital-signature-date'] : '', $application_id);

				return $application_id;
				break; // Defensive programming...
		}
	}

	public static function attach_resume($media_id, $application_id)
	{
		update_field('field_5ca515302f6b2', $media_id, $application_id);
	}

	public static function send_admin_notification(string $application_stage, string $application_id, string $notification_email, array $application_data)
	{

		// Email subject
		$mail_subject = 'Job Application | Stage ' . $application_stage . ' | ' . get_bloginfo('name');

		// Gather $_POST vars
		// Set them based on which Stage Number var is passed in
		$form_name = $application_stage == '1' ? $application_data['tq-name'] : $application_data['tq-s1-name-first'] . ' ' . $application_data['tq-s1-name-last'];
		$form_email = $application_stage == '1' ? $application_data['tq-email'] : $application_data['tq-s1-email'];
		$form_phone = $application_stage == '1' ? $application_data['tq-phone'] : $application_data['tq-s1-phone'];
		$form_intro = $application_stage == '1' ? $application_data['tq-intro'] : '';
		$form_state = $application_stage == '1' ? $application_data['tq-state'] : $application_data['tq-s1-state'];
		$form_zipcode = $application_stage == '1' ? $application_data['tq-zipcode'] : $application_data['tq-s1-zipcode'];
		$form_job = $application_stage == '1' ? $application_data['tq-job'] : '';

		// Compile email message
		// Compose email content based on which Stage Number var is passed in
		$mail_content = '<p>Hi, <br><br>You have just received a new Stage ' . $application_stage . ' Job Application for Atlantic Residential. Please see below for details:</p><ul>';
		$mail_content .= '<li><strong>Name: </strong>' . $form_name . '</li>';
		$mail_content .= '<li><strong>Email: </strong>' . $form_email . '</li>';
		$mail_content .= '<li><strong>Phone: </strong>' . $form_phone . '</li>';
		$mail_content .= '<li><strong>State: </strong>' . $form_state . '</li>';
		$mail_content .= '<li><strong>Zip Code: </strong>' . $form_zipcode . '</li>';
		$mail_content .= $form_job != '' ? '<li><strong>Job Title: </strong>' . $form_job . '</li>' : '';
		$mail_content .= $form_intro != '' ? '<li><strong>Intro: </strong>' . $form_intro . '</li>' : '';
		$mail_content .= $application_stage == '1' ? '<li><strong>Resume: </strong>' : '<li><strong>View Full Application: </strong>';
		$mail_content .= '<a href="' . get_site_url() . '/wp-admin/post.php?post=' . $application_id . '&action=edit">' . get_site_url() . '/wp-admin/post.php?post=' . $application_id . '&action=edit</a></li>';
		$mail_content .= '</ul><p>Note: to repond to the job applicant directly you can reply to this email.</p>';

		// Email body content
		$mail_body = $mail_content;

		// Add a recipient
		$mail_to = ($notification_email != '' ? $notification_email : get_option('admin_email'));

		// Email headers
		$mail_headers = array(
			'From: Atlantic Residential Careers <' . $notification_email . '>',
			'Reply-To: ' . $form_name . ' <' . $form_email . '>',
			'Content-Type: text/html; charset=UTF-8;'
		);

		// Attempt to send the email notification
		$mail_result = wp_mail($mail_to, $mail_subject, $mail_body, $mail_headers);

		return $mail_result;
	}

	public function html_email_content_type()
	{
		return 'text/html';
	}

	public static function prep_input($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	public function add_job_app_acf_metaboxes()
	{
		/**
		 * 20190812: CURRENTLY IMPLEMENTED USING THE JSON DEFINITIONS (/acf-json/)
		 */
	}
}
