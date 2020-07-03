<?php
// include FPDF library
// require_once( get_stylesheet_directory() . '/libraries/fpdf182/fpdf.php' );
require_once( get_stylesheet_directory() . '/libraries/fpdf182/html2pdf/html2pdf.php' );

class Atlantic_Residential_Job_Application_CPT
{
	public static $JOB_APP_PROPERTY_TYPE_TAX_SLUG = 'atlantic_job_app_stage';
	public static $UNWANTED_FIELDS = [ 'g-recaptcha-response', '_wpnonce', '_wp_http_referer', 'tq-online-application-form', 'tq-careers-form', 'form-stage' ];
	public static $SECTION_TITLES = [
		'Personal Information ',
		'Desired Employment',
		'Education and Training',
		'Employment History',
		'Second Most Recent Employment',
		'Third Most Recent Employment',
		'References',
		'Pre-Employment Certification',
	];

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

	/**
	 * Associated the auto-generated PDF of application, to the application CPT by ID
	 * Returns the url of the generated PDF, or false if it failed.
	 */
	protected static function build_application_pdf(
		string $application_stage,
		array $application_data
	) {
		// get the WP upload DIR
		$wp_upload_dir = wp_upload_dir();
		// set the destination URL
		$dest_dir = trailingslashit ( $wp_upload_dir['path'] );
		// set the filename
		$filename = time() . '-s' . $application_stage . '-';
		$form_title = 'Form Submission'; // fallback
		if ( '1' === $application_stage ) {
			$filename .= sanitize_title( $application_data['tq-name'] );
			$form_title = 'Careers';
		} elseif ( '2' === $application_stage ) {
			$filename .= sanitize_title( $application_data['tq-s1-name-first'] . ' ' . $application_data['tq-s1-name-last'] );
			$form_title = 'Online Application';
		}
		$filename .= '.pdf';
		// set the PDF URL
		$file_path = $dest_dir . $filename;

		// output PDF contents
		$pdf = new PDF_HTML();
		$pdf->SetFont( 'Arial', '', 12 );
		$pdf->AddPage();
		
		/**
		 * NOTE: Image not working locally, as you must have the directive allow_url_open activated
		 * https://www.php.net/manual/fr/filesystem.configuration.php#ini.allow-url-fopen
		 */
		/* // output site logo
		require_once( get_template_directory() . '/includes/customizer/customizer-tabs/tabs/torque-customizer-tab-site-identity-class.php' );
		$tab_settings = Torque_Customizer_Tab_Site_Identity::get_settings();
		$logo_src = get_theme_mod( $tab_settings['logo_setting'] );
		if ( '' !== $logo_src ) {
			// $pdf->Image( $logo_src );
			$pdf->WriteHTML( '<img src="' . $logo_src . '" width="120" height="auto" /></b><br>' );
		} */
		
		// output form title
		$pdf->WriteHTML( '<b>'.$form_title.' Form | ' . get_bloginfo( 'name' ) . '</b><br>' );

		// first section
		$curr_section = 's0';

		foreach ( $application_data as $key => $value ) {

			// if stage 2 form, output section titles
			if ( '2' === $application_stage ) {
				// build section title
				$title = self::build_pdf_section_title( $curr_section, $key );
	
				// output section title to PDF
				if ( false !== $title ) {
					$curr_section = 's' . ( (int) str_replace( 's', '', $curr_section ) + 1 );
					$pdf->WriteHTML( '<br>' . $title . '<br><br>' );
				}
			} else {
				$pdf->WriteHTML( '<br><br>' );
			}

			// build line item for PDF
			$html = self::build_pdf_line_item( $key, $value, $curr_section );

			// output line item to PDF
			if ( false !== $html ) {
				// write html
				$pdf->WriteHTML( $html );
				// check if we need a new page, or new line
				if ( $pdf->GetY() >= $pdf->GetPageHeight() ) {
					$pdf->AddPage();
				} else {
					// $pdf->Ln();
					// $pdf->WriteHTML( '<br>' );
				}
			}
		}

		$pdf->Output( 'F', $file_path, true );

		// create attachment in WP
		$attachment = array(
			'guid' => trailingslashit ($wp_upload_dir['url']) . basename( $file_path ),
			'post_mime_type' => 'application/pdf',
			'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
			'post_content' => '',
			'post_status' => 'inherit'
		);
		// ID of media attachment
		$media_id = wp_insert_attachment( $attachment, $file_path );
		// URL of media attachment
		$pdf_url = wp_get_attachment_url( (int) $media_id );
		
		return $pdf_url;
	}

	/**
	 * Build a section title for the PDF, based on current section slug and line item key
	 */
	protected static function build_pdf_section_title(
		$curr_section,
		$key
	) {
		$title = false;
		// weed out fields we don't want...
		if ( ! preg_match( '/'.implode( '|', self::$UNWANTED_FIELDS ) . '/', $key ) ) {

			$exploded_key = explode('-', $key, 3); // limit to 3, assuming 'tq-s1-field-key'
			$new_section = !empty( $exploded_key ) ? $exploded_key[1] : false;

			if (
				false !== $new_section
				&& $new_section !== $curr_section
			) {
				$section_number = (int) str_replace( 's', '', $new_section ) - 1;
				$title = self::$SECTION_TITLES[ $section_number ];
			}

		}
		return $title;
	}

	/**
	 * Build a line item for the PDF, based on a key/value pair
	 */
	protected static function build_pdf_line_item(
		$key,
		$value,
		$curr_section
	) {
		$html = false;
		// weed out fields we don't want...
		if ( ! preg_match( '/'.implode( '|', self::$UNWANTED_FIELDS ) . '/', $key ) ) {
			$title = str_replace( 'tq-', '', $key ); // remove 'tq-' slug
			$title = str_replace( $curr_section . '-', ' ', $title ); // remove section slug
			$title = str_replace( '-', ' ', $title ); // remove additional '-'

			// edge cases
			if ( $title == 'terms one' ) {
				$title = 'Equal Opportunity Employer';
			} elseif ( $title == 'terms two' ) {
				$title = ' Application for Employment';
			} elseif ( $title == 'terms three' ) {
				$title = 'Drug and/or Alcohol Testing';
			} elseif ( $title == 'terms four' ) {
				$title = 'Consideration for Employment';
			}

			$html = '- <strong>' . ucwords( $title ) . ':</strong> ' . $value . '<br>';
		}
		return $html;
	}

	public static function send_admin_notification(
		string $application_stage, 
		string $application_id, 
		string $media_id = null, 
		string $notification_email,
		array $application_data
	) {

		// build and save PDF
		$application_pdf = self::build_application_pdf( $application_stage, $application_data );
		// link to application CPT
		self::link_pdf_to_application( $application_pdf, $application_id, $application_stage );

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
		$mail_content .= $application_stage == '1'
			? '<li><strong>Resume: </strong><a href="' . wp_get_attachment_url( (int) $media_id ) . '">'  . wp_get_attachment_url( (int) $media_id ) . '</a></li>' 
			: '';
		$mail_content .= '<li><strong>Application PDF: </strong><a href="' . $application_pdf . '">' . $application_pdf . '</a></li>';
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

		// Create PDF of 

		// Attempt to send the email notification
		$mail_result = wp_mail( $mail_to, $mail_subject, $mail_body, $mail_headers );

		return $mail_result;
	}

	/**
	 * Associate the user-submitted resume, with post ID, to the application CPT by ID
	 */
	public static function link_resume_to_application(
		$media_id,
		$application_id
	) {
		// ACF field, located in /acf-json/group_5ca514ef6a1ae.json
		update_field('field_5ca515302f6b2', $media_id, $application_id);
	}

	/**
	 * Associate the auto-generated PDF to the application CPT by ID
	 */
	protected static function link_pdf_to_application(
		$pdf_url,
		$application_id,
		$application_stage
	) {
		if ( '1' === $application_stage ) {
			// ACF field, located in /acf-json/group_5ca514ef6a1ae.json
			update_field( 'field_5ca51530jkjs822', $pdf_url, $application_id );
		} elseif ( '2' === $application_stage ) {
			// ACF field, located in /acf-json/group_5ef305c28797f.json
			update_field( 'field_5ef305ca2de61', $pdf_url, $application_id );
		}
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
