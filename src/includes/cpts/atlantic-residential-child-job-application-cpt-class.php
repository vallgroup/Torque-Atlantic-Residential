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
		add_action( 'restrict_manage_posts', array( $this, 'filter_job_apps_by_taxonomies' ) , 10, 2);
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
	function filter_job_apps_by_taxonomies( $post_type, $which ) {
		// Apply this only on a specific post type
		if ( Torque_Job_Application_CPT::$job_applications_labels['post_type_name'] !== $post_type )
			return;

		// A list of taxonomy slugs to filter by
		$taxonomies = array( self::$JOB_APP_PROPERTY_TYPE_TAX_SLUG );

		foreach ( $taxonomies as $taxonomy_slug ) {

			// Retrieve taxonomy data
			$taxonomy_obj = get_taxonomy( $taxonomy_slug );
			$taxonomy_name = $taxonomy_obj->labels->name;

			// Retrieve taxonomy terms
			$terms = get_terms( $taxonomy_slug );

			// Display filter HTML
			echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
			echo '<option value="">' . sprintf( esc_html__( 'All %s', 'text_domain' ), $taxonomy_name ) . '</option>';
			foreach ( $terms as $term ) {
				printf(
					'<option value="%1$s" %2$s>%3$s (%4$s)</option>',
					$term->slug,
					( ( isset( $_GET[$taxonomy_slug] ) && ( $_GET[$taxonomy_slug] == $term->slug ) ) ? ' selected="selected"' : '' ),
					$term->name,
					$term->count
				);
			}
			echo '</select>';
		}
	}

	public function add_job_app_acf_metaboxes()
	{

		// Add the ACF fields to Job Application CPT
		if (function_exists('acf_add_local_field_group')) :

		/* TO BE REPLACED WITH PHP EXPORTED ACF FIELDS, ONCE COMPLETELY BUILT.... Replace the items below with the latest from WP PHP export. */

		/* acf_add_local_field_group(array(
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
			)); */

		endif;
	}

	public static function save_application(string $application_stage, string $applicant_name, array $application_data)
	{
		// Get the category ID, so we can assign the Job Application post to the correct category
		$stage_tax_obj = get_term_by('slug', 'stage-' . $application_stage, self::$JOB_APP_PROPERTY_TYPE_TAX_SLUG );

		switch ($application_stage) {

				// Stage 1 Job Application
			case "1":

				$email = $application_data['tq-email'];
				$phone = $application_data['tq-phone'];
				$intro = $application_data['tq-intro'];
				$state = $application_data['tq-state'];
				$zipcode = $application_data['tq-zipcode'];
				$job_title = $application_data['tq-job'];

				$application = array(
					'post_title'    => $applicant_name,
					'post_content'  => $intro,
					'post_status'   => 'publish',
					'post_type'			=> Torque_Job_Application_CPT::$job_applications_labels['post_type_name']
				);

				// Insert the post into the database
				$application_id = wp_insert_post($application);

				// Assign the correct Job Application Stage
				wp_set_object_terms( $application_id, $stage_tax_obj->term_id, self::$JOB_APP_PROPERTY_TYPE_TAX_SLUG );

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

				$email = $application_data['tq-email'];
				$phone = $application_data['tq-phone'];
				$intro = $application_data['tq-intro'];
				$state = $application_data['tq-state'];
				$zipcode = $application_data['tq-zipcode'];
				$job_title = $application_data['tq-job'];

				$application = array(
					'post_title'    => $applicant_name,
					'post_content'  => $intro,
					'post_status'   => 'publish',
					'post_type'			=> Torque_Job_Application_CPT::$job_applications_labels['post_type_name']
				);

				// Insert the post into the database
				$application_id = wp_insert_post($application);

				// Assign the correct Job Application Stage
				wp_set_object_terms( $application_id, $stage_tax_obj->term_id, self::$JOB_APP_PROPERTY_TYPE_TAX_SLUG );

				// Add ACF metadata to post
				update_field('field_5ca514f92f6b0', $email, $application_id);
				update_field('field_5ca5151a2f6b1', $phone, $application_id);
				update_field('field_5ca5151a2fj2d', $state, $application_id);
				update_field('field_5ca5151an24j2d', $zipcode, $application_id);
				update_field('field_5ca5151amxj23', $job_title, $application_id);

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
		$form_name = $application_data['tq-name'];
		$form_email = $application_data['tq-email'];
		$form_phone = $application_data['tq-phone'];
		$form_intro = $application_data['tq-intro'];
		$form_state = $application_data['tq-state'];
		$form_zipcode = $application_data['tq-zipcode'];
		$form_job = $application_data['tq-job'];

		// Compile email message
		$mail_content = '<p>Hi, <br><br>You have just received a new Stage ' . $application_stage . ' Job Application for Atlantic Residential. Please see below for details:</p><ul>';
		$mail_content .= '<li><strong>Name: </strong>' . $form_name . '</li>';
		$mail_content .= '<li><strong>Email: </strong>' . $form_email . '</li>';
		$mail_content .= '<li><strong>Phone: </strong>' . $form_phone . '</li>';
		$mail_content .= '<li><strong>State: </strong>' . $form_state . '</li>';
		$mail_content .= '<li><strong>Zip Code: </strong>' . $form_zipcode . '</li>';
		$mail_content .= '<li><strong>Job Title: </strong>' . $form_job . '</li>';
		$mail_content .= '<li><strong>Intro: </strong>' . $form_intro . '</li>';
		$mail_content .= '<li><strong>Resume: </strong><a href="' . get_site_url() . '/wp-admin/post.php?post=' . $application_id . '&action=edit">' . get_site_url() . '/wp-admin/post.php?post=' . $application_id . '&action=edit</a></li>';
		$mail_content .= '</ul>';
		$mail_content .= '<p>Note: to repond to the job applicant directly you can reply to this email.</p>';

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
	
	public static function prep_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
}
