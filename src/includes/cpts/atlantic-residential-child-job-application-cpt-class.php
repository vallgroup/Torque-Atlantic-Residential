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
			'From: Interra Careers <' . $notification_email . '>',
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
		/* if (function_exists('acf_add_local_field_group')) :

			// CAREERS FORM DATA

			acf_add_local_field_group(array(
				'key' => 'group_5ca514ef6a1ae',
				'title' => 'Job Application Data',
				'fields' => array(
					array(
						'key' => 'field_5ca514f92f6b0',
						'label' => 'Email',
						'name' => 'job_application_email',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5ca5151a2f6b1',
						'label' => 'Phone',
						'name' => 'job_application_phone',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5ca5151a2fj2d',
						'label' => 'State',
						'name' => 'job_application_state',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5ca5151an24j2d',
						'label' => 'Zip Code',
						'name' => 'job_application_zipcode',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5ca5151amxj23',
						'label' => 'Job Title',
						'name' => 'job_application_job_title',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5ca515302f6b2',
						'label' => 'Resume',
						'name' => 'job_application_resume',
						'type' => 'file',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'return_format' => 'id',
						'library' => 'all',
						'min_size' => '',
						'max_size' => '',
						'mime_types' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'torque_job_app',
						),
						array(
							'param' => 'post_taxonomy',
							'operator' => '==',
							'value' => 'atlantic_job_app_stage:stage-1',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));

			acf_add_local_field_group(array(
				'key' => 'group_5d02766fe2b64',
				'title' => 'Career Form Settings',
				'fields' => array(
					array(
						'key' => 'field_5d0276901e091',
						'label' => 'Notification Email',
						'name' => 'notification_email',
						'type' => 'email',
						'instructions' => 'Please enter the email address for which you\'d like to receive notifications of Career submissions.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_template',
							'operator' => '==',
							'value' => 'careers.php',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'side',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
				'modified' => false,
			));

			// ONLINE APPLICATION FORM DATA

			acf_add_local_field_group(array(
				'key' => 'group_5d435e30616c8',
				'title' => 'Online Applications Modules',
				'fields' => array(
					array(
						'key' => 'field_5d435f0f73abe',
						'label' => 'Notification Email',
						'name' => 'notification_email',
						'type' => 'email',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => 'careers@example.com',
						'prepend' => '',
						'append' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'page',
						),
						array(
							'param' => 'post_template',
							'operator' => '==',
							'value' => 'online-application.php',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));

			acf_add_local_field_group(array(
				'key' => 'group_5d48d7369eccb',
				'title' => 'Online Application Data | Personal Information',
				'fields' => array(
					array(
						'key' => 'field_5d48d736a9ff5',
						'label' => 'First Name',
						'name' => 's1_first_name',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d736aa0d6',
						'label' => 'Last Name',
						'name' => 's1_last_name',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d736aa1cb',
						'label' => 'Address',
						'name' => 's1_address',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d736aa29d',
						'label' => 'Address 2',
						'name' => 's1_address_2',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d736aa356',
						'label' => 'City',
						'name' => 's1_city',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d736aa411',
						'label' => 'State',
						'name' => 's1_state',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d736aa4e4',
						'label' => 'Zip Code',
						'name' => 's1_zip_code',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d736aa5ca',
						'label' => 'Phone Number',
						'name' => 's1_phone_number',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d736aa696',
						'label' => 'Email Address',
						'name' => 's1_email_address',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d736aa772',
						'label' => 'After employment, can you submit verification of your legal right to work in the United States?',
						'name' => 's1_after_employment_can_you_submit_verification_of_your_legal_right_to_work_in_the_united_states',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d736aa90d',
						'label' => 'Have you ever used any other name? If yes, please explain.',
						'name' => 's1_have_you_ever_used_any_other_name_if_yes_please_explain',
						'type' => 'textarea',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => '',
						'new_lines' => '',
					),
					array(
						'key' => 'field_5d48d736aab3a',
						'label' => 'Are you 18 years old or over?',
						'name' => 's1_are_you_18_years_old_or_over',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d736aad0f',
						'label' => 'Have you ever been convicted of a felony, misdemeanor, child abuse or sex-related crimes? If yes, please explain.',
						'name' => 's1_have_you_ever_been_convicted_of_a_felony_misdemeanor_child_abuse_or_sex_related_crimes_if_yes_please_explain',
						'type' => 'textarea',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => '',
						'new_lines' => '',
					),
					array(
						'key' => 'field_5d48d736aaeee',
						'label' => 'Do you have any pending legal charges against you? If yes, please explain.',
						'name' => 's1_do_you_have_any_pending_legal_charges_against_you_if_yes_please_explain',
						'type' => 'textarea',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => '',
						'new_lines' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'torque_job_app',
						),
						array(
							'param' => 'post_taxonomy',
							'operator' => '==',
							'value' => 'atlantic_job_app_stage:stage-2',
						),
					),
				),
				'menu_order' => 1,
				'position' => 'acf_after_title',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));

			acf_add_local_field_group(array(
				'key' => 'group_5d48d876deb34',
				'title' => 'Online Application Data | Desired Employment',
				'fields' => array(
					array(
						'key' => 'field_5d48d876eaacb',
						'label' => 'Desired Role',
						'name' => 's2_desired_role',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d876eaba6',
						'label' => 'Desired Salary',
						'name' => 's2_desired_salary',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d876eac7b',
						'label' => 'Date Available',
						'name' => 's2_date_available',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d876ead39',
						'label' => 'Are you presently employed?',
						'name' => 's2_are_you_presently_employed',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d876eae33',
						'label' => 'If yes, may we contact your present employer?',
						'name' => 's2_if_yes_may_we_contact_your_present_employer',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d876eaf0a',
						'label' => 'Supervisor\'s Name',
						'name' => 's2_supervisors_name',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d876eafe1',
						'label' => 'Supervisor\'s Phone',
						'name' => 's2_supervisors_phone',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d876eb0b2',
						'label' => 'Have you ever been employed by ATLANTIC RESIDENTIAL before? <br>If yes, when/where?',
						'name' => 's2_have_you_ever_been_employed_by_atlantic_residential_before_if_yes_when_where',
						'type' => 'textarea',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => '',
						'new_lines' => '',
					),
					array(
						'key' => 'field_5d48d876eb18f',
						'label' => 'How were you referred to Atlantic Residential?',
						'name' => 's2_how_were_you_referred_to_atlantic_residential',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'torque_job_app',
						),
						array(
							'param' => 'post_taxonomy',
							'operator' => '==',
							'value' => 'atlantic_job_app_stage:stage-2',
						),
					),
				),
				'menu_order' => 2,
				'position' => 'acf_after_title',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));

			acf_add_local_field_group(array(
				'key' => 'group_5d48d8feeee6f',
				'title' => 'Online Application Data | Education and Training',
				'fields' => array(
					array(
						'key' => 'field_5d48d8ff04a51',
						'label' => 'Did you graduate from High School?',
						'name' => 's3_did_you_graduate_from_high_school',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d8ff04b2e',
						'label' => 'Did you graduate from College/University?',
						'name' => 's3_did_you_graduate_from_college_university',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d8ff04bd9',
						'label' => 'Degree',
						'name' => 's3_uni_degree',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d8ff04c81',
						'label' => 'Major',
						'name' => 's3_uni_major',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d8ff04d49',
						'label' => 'Did you attend a graduate program?',
						'name' => 's3_did_you_attend_a_graduate_program',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d8ff04ec6',
						'label' => 'Degree',
						'name' => 's3_grad_degree',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d8ff04fe0',
						'label' => 'Major',
						'name' => 's3_grad_major',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d8ff050fa',
						'label' => 'Highest Degree Earned',
						'name' => 's3_highest_degree_earned',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d8ff051e5',
						'label' => 'Additional training, honors, awards, certification or license',
						'name' => 's3_additional_training_honors_awards_certification_or_license',
						'type' => 'textarea',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => '',
						'new_lines' => '',
					),
					array(
						'key' => 'field_5d48d8ff052ce',
						'label' => 'Do you speak or write any foreign languages',
						'name' => 's3_do_you_speak_or_write_any_foreign_languages',
						'type' => 'textarea',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => '',
						'new_lines' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'torque_job_app',
						),
						array(
							'param' => 'post_taxonomy',
							'operator' => '==',
							'value' => 'atlantic_job_app_stage:stage-2',
						),
					),
				),
				'menu_order' => 3,
				'position' => 'acf_after_title',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));

			acf_add_local_field_group(array(
				'key' => 'group_5d48d97bec470',
				'title' => 'Online Application Data | Employment History | Current or Most Recent',
				'fields' => array(
					array(
						'key' => 'field_5d48d97c03398',
						'label' => 'Company Name',
						'name' => 's4_company_name',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d97c0352c',
						'label' => 'Company Phone',
						'name' => 's4_company_phone',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d97c03611',
						'label' => 'Address',
						'name' => 's4_address',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d97c03729',
						'label' => 'Address 2',
						'name' => 's4_address_2',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d97c03835',
						'label' => 'City',
						'name' => 's4_city',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d97c03be0',
						'label' => 'State',
						'name' => 's4_state',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d97c03d0e',
						'label' => 'Zip Code',
						'name' => 's4_zip_code',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d97c03e6a',
						'label' => 'Job Title(s)',
						'name' => 's4_job_titles',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d97c03f51',
						'label' => 'Base Rate of Pay - Start',
						'name' => 's4_base_rate_of_pay_start',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d97c04031',
						'label' => 'Base Rate of Pay - End',
						'name' => 's4_base_rate_of_pay_end',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d97c04111',
						'label' => 'Supervisor',
						'name' => 's4_supervisor',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48d97c041f0',
						'label' => 'Description of Job Duties',
						'name' => 's4_description_of_job_duties',
						'type' => 'textarea',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => '',
						'new_lines' => '',
					),
					array(
						'key' => 'field_5d48d97c042e4',
						'label' => 'Reason for Leaving',
						'name' => 's4_reason_for_leaving',
						'type' => 'textarea',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => '',
						'new_lines' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'torque_job_app',
						),
						array(
							'param' => 'post_taxonomy',
							'operator' => '==',
							'value' => 'atlantic_job_app_stage:stage-2',
						),
					),
				),
				'menu_order' => 4,
				'position' => 'acf_after_title',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));

			acf_add_local_field_group(array(
				'key' => 'group_5d48da8509e51',
				'title' => 'Online Application Data | Employment History | Second Most Recent',
				'fields' => array(
					array(
						'key' => 'field_5d48da85159e4',
						'label' => 'Company Name',
						'name' => 's5_company_name',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48da8515acb',
						'label' => 'Company Phone',
						'name' => 's5_company_phone',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48da8515bba',
						'label' => 'Address',
						'name' => 's5_address',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48da8515c7f',
						'label' => 'Address 2',
						'name' => 's5_address_2',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48da8515fee',
						'label' => 'City',
						'name' => 's5_city',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48da85160cc',
						'label' => 'State',
						'name' => 's5_state',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48da85161af',
						'label' => 'Zip Code',
						'name' => 's5_zip_code',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48da851627b',
						'label' => 'Job Title(s)',
						'name' => 's5_job_titles',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48da8516339',
						'label' => 'Base Rate of Pay - Start',
						'name' => 's5_base_rate_of_pay_start',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48da8516413',
						'label' => 'Base Rate of Pay - End',
						'name' => 's5_base_rate_of_pay_end',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48da85164d9',
						'label' => 'Supervisor',
						'name' => 's5_supervisor',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48da851659f',
						'label' => 'Description of Job Duties',
						'name' => 's5_description_of_job_duties',
						'type' => 'textarea',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => '',
						'new_lines' => '',
					),
					array(
						'key' => 'field_5d48da851667a',
						'label' => 'Reason for Leaving',
						'name' => 's5_reason_for_leaving',
						'type' => 'textarea',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => '',
						'new_lines' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'torque_job_app',
						),
						array(
							'param' => 'post_taxonomy',
							'operator' => '==',
							'value' => 'atlantic_job_app_stage:stage-2',
						),
					),
				),
				'menu_order' => 5,
				'position' => 'acf_after_title',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));

			acf_add_local_field_group(array(
				'key' => 'group_5d48dbda579b4',
				'title' => 'Online Application Data | Employment History | Third Most Recent',
				'fields' => array(
					array(
						'key' => 'field_5d48dbda60742',
						'label' => 'Company Name',
						'name' => 's6_company_name',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48dbda6083d',
						'label' => 'Company Phone',
						'name' => 's6_company_phone',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48dbda60921',
						'label' => 'Address',
						'name' => 's6_address',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48dbda609ea',
						'label' => 'Address 2',
						'name' => 's6_address_2',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48dbda60acb',
						'label' => 'City',
						'name' => 's6_city',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48dbda60bab',
						'label' => 'State',
						'name' => 's6_state',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48dbda60c84',
						'label' => 'Zip Code',
						'name' => 's6_zip_code',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48dbda60d74',
						'label' => 'Job Title(s)',
						'name' => 's6_job_titles',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48dbda60e30',
						'label' => 'Base Rate of Pay - Start',
						'name' => 's6_base_rate_of_pay_start',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48dbda60f0c',
						'label' => 'Base Rate of Pay - End',
						'name' => 's6_base_rate_of_pay_end',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48dbda61001',
						'label' => 'Supervisor',
						'name' => 's6_supervisor',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48dbda610e1',
						'label' => 'Description of Job Duties',
						'name' => 's6_description_of_job_duties',
						'type' => 'textarea',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => '',
						'new_lines' => '',
					),
					array(
						'key' => 'field_5d48dbda61223',
						'label' => 'Reason for Leaving',
						'name' => 's6_reason_for_leaving',
						'type' => 'textarea',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => '',
						'new_lines' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'torque_job_app',
						),
						array(
							'param' => 'post_taxonomy',
							'operator' => '==',
							'value' => 'atlantic_job_app_stage:stage-2',
						),
					),
				),
				'menu_order' => 6,
				'position' => 'acf_after_title',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));

			acf_add_local_field_group(array(
				'key' => 'group_5d48dc69a2c03',
				'title' => 'Online Application Data | References',
				'fields' => array(
					array(
						'key' => 'field_5d48dd0dceb10',
						'label' => 'First Reference',
						'name' => 's7_r1_first_reference',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48dd18ceb11',
						'label' => 'Email',
						'name' => 's7_r1_email',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48dd24ceb12',
						'label' => 'Phone',
						'name' => 's7_r1_phone',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48dd33ceb13',
						'label' => 'Relationship',
						'name' => 's7_r1_relationship',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48dd56ceb18',
						'label' => 'Second Reference',
						'name' => 's7_r2_second_reference',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48dd43ceb15',
						'label' => 'Email',
						'name' => 's7_r2_emai',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48dd47ceb16',
						'label' => 'Phone',
						'name' => 's7_r2_phone',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48dd4aceb17',
						'label' => 'Relationship',
						'name' => 's7_r2_relationship',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48dd8dceb1a',
						'label' => 'Third Reference',
						'name' => 's7_r3_second_reference',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48dd92ceb1b',
						'label' => 'Email',
						'name' => 's7_r3_email',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48dd96ceb1c',
						'label' => 'Phone',
						'name' => 's7_r3_phone',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48dd9cceb1d',
						'label' => 'Relationship',
						'name' => 's7_r3_relationship',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'torque_job_app',
						),
						array(
							'param' => 'post_taxonomy',
							'operator' => '==',
							'value' => 'atlantic_job_app_stage:stage-2',
						),
					),
				),
				'menu_order' => 7,
				'position' => 'acf_after_title',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));

			acf_add_local_field_group(array(
				'key' => 'group_5d48de94c8361',
				'title' => 'Online Application Data | Pre-Employment Certification',
				'fields' => array(
					array(
						'key' => 'field_5d48deaaecd5d',
						'label' => 'Agreement One',
						'name' => 's8_agreement_one',
						'type' => 'text',
						'instructions' => 'Atlantic Residential is an Equal Opportunity Employer. Applicants for all openings are welcome and will be considered without regard to race, color, religion, national origin, sex, age, sexual orientation, physical or mental disability, or any other basis protected by state, federal or local law. It is the intent of the association to comply with all applicable federal, state and local legislation concerning equal opportunity in employment. Proof of citizenship or authorization for employment in the USA is required before final selection. Atlantic Residential is committed to protecting the health and safety of our employees. I also understand that this application is only valid for the position applied for at present and that Atlantic Residential is not obligated to retain or consider this application for future openings.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48df197f894',
						'label' => 'Agreement Two',
						'name' => 's8_agreement_two',
						'type' => 'text',
						'instructions' => 'I agree to submit to legally permissible drug and/or alcohol testing and a background check upon request by Atlantic Residential. I recognize that the results of these tests may be used to determine my employment or continued employment. I understand and expressly agree that if employed, storage areas provided for me (locker, desk, computer, etc.) are open to investigation by Atlantic Residential without prior notice to me.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48df577fa9c',
						'label' => 'Agreement Three',
						'name' => 's8_agreement_three',
						'type' => 'text',
						'instructions' => 'If I am employed by Atlantic Residential, I understand my employment is ‘at-will’ and can be terminated, with or without cause and with or without notice, at any time at the option of Atlantic Residential or myself. I understand that, other than the President of Atlantic Residential, no manager, supervisor or representative of Atlantic Residential has authority to enter into any agreement for employment for any specific period of time, or to make any agreement contrary to the foregoing. Only the President of Atlantic Residential has the authority to make any agreement contrary to the foregoing and then only in writing. I further expressly agree that, with respect to the ‘at-will’ employment relationship, this constitutes the full, complete and final expression of the parties’ intent concerning the nature of any employment relationship between myself and Atlantic Residential.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48df6e7fa9d',
						'label' => 'Digital Signature',
						'name' => 's8_digital_signature',
						'type' => 'text',
						'instructions' => 'My signature below certifies that I have read and understand the foregoing and to the best of my knowledge and belief, the information on this form is true and correct.
				
				My signature below also certifies that I agree to be bound by the terms and conditions stated in this application. This application contains all the understandings and agreements between me and Atlantic Residential concerning the nature of my employment, if any, by Atlantic Residential and supersedes all prior and/or contemporaneous practices, oral or written agreements, understandings, statements, representations and promises, express or implied, between me and Atlantic Residential. I understand and agree that, except as noted above, no person who is either an agent or employee of Atlantic Residential may modify, delete, vary or contradict, whether orally or in writing, the terms and conditions set forth herein.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5d48df847fa9e',
						'label' => 'Date Submitted',
						'name' => 's8_date_submitted',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'torque_job_app',
						),
						array(
							'param' => 'post_taxonomy',
							'operator' => '==',
							'value' => 'atlantic_job_app_stage:stage-2',
						),
					),
				),
				'menu_order' => 8,
				'position' => 'acf_after_title',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));

		endif; */
	}
}
