<?php

class Atlantic_Residential_Roles {

  public static $BROKER_ROLE_SLUG = 'broker';

  public static $MANAGER_ROLE_SLUG = 'manager';

  public static $SORTED_USERS_BY_JOB_TITLE = array();

  public function __construct() {
    add_action('init', array($this, 'add_broker'));
		add_action('init', array($this, 'add_manager'));

		// Added option to remove roles, as not sure if these two roles are required yet...
		/* 
		add_action('init', array($this, 'remove_broker'));
		add_action('init', array($this, 'remove_manager')); 
		*/

		add_action('acf/init', array( $this, 'add_custom_role_metaboxes'));
		add_action('acf/init', array($this, 'add_job_titles_acf'));
			
		// setup job title choices select based on job title ACF
		add_filter('acf/load_field/key=field_5cc096378bc25', array($this, 'setup_job_title_choices'));

    // vcard support
    add_filter('upload_mimes', function ($mime_types){
      $mime_types['vcf'] = 'text/vcard';
      $mime_types['vcard'] = 'text/vcard';
      return $mime_types;
		}, 1, 1);

		$this::$SORTED_USERS_BY_JOB_TITLE = $this->get_sorted_user_array();
  }

  public function add_broker() {
    $parent_role = get_role( 'editor' );
    add_role(
      self::$BROKER_ROLE_SLUG,
      'Broker',
      array_merge(
        $parent_role->capabilities,
        array() // override capabilities
      )
    );
  }

  public function add_manager() {
    $parent_role = get_role( 'administrator' );
    add_role(
      self::$MANAGER_ROLE_SLUG,
      'Manager',
      array_merge(
        $parent_role->capabilities,
        array() // override capabilities
      )
    );
  }

  public function remove_broker() {
	if ( get_role(self::$BROKER_ROLE_SLUG) ){
		remove_role(self::$BROKER_ROLE_SLUG);
	}
  }

  public function remove_manager() {
	if ( get_role(self::$MANAGER_ROLE_SLUG) ){
		remove_role(self::$MANAGER_ROLE_SLUG);
  	}
  }

  public function add_custom_role_metaboxes() {
    if( function_exists('acf_add_local_field_group') ):

      acf_add_local_field_group(array(
      	'key' => 'group_5cc094e88f3b3',
      	'title' => 'User Fields',
      	'fields' => array(
      		array(
      			'key' => 'field_5cc096138bc24',
      			'label' => 'Featured Image',
      			'name' => 'featured_image',
      			'type' => 'image',
      			'instructions' => '',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '',
      				'class' => '',
      				'id' => '',
      			),
      			'return_format' => 'url',
      			'preview_size' => 'thumbnail',
      			'library' => 'all',
      			'min_width' => '',
      			'min_height' => '',
      			'min_size' => '',
      			'max_width' => '',
      			'max_height' => '',
      			'max_size' => '',
      			'mime_types' => '',
      		),
      		array(
      			'key' => 'field_5cc096378bc25',
      			'label' => 'Job Title',
      			'name' => 'job_title',
      			'type' => 'select',
      			'instructions' => 'Defaults to user role',
      			'required' => 0,
      			'conditional_logic' => 0,
      			'wrapper' => array(
      				'width' => '',
      				'class' => '',
      				'id' => '',
      			),
      			'default_value' => '',
      			'prepend' => '',
      			'append' => '',
      		),
			array(
				'key' => 'field_5d640f368ef86',
				'label' => 'Staff Bio',
				'name' => 'staff_bio',
				'type' => 'wysiwyg',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'media_upload' => 0,
				'tabs' => 'all',
				'toolbar' => 'full',
				'delay' => 0,
			),
      	),
      	'location' => array(
      		array(
      			array(
      				'param' => 'user_role',
      				'operator' => '==',
      				'value' => 'broker',
      			),
      		),
      		array(
      			array(
      				'param' => 'user_role',
      				'operator' => '==',
      				'value' => 'manager',
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

      endif;
	}
	
	// Add ability to add/remove/reorder staff roles.
	// These are displayed on the staff grid and single staff pages.
	// Order is used to display staff in order of role, on staff grid page.
	public function add_job_titles_acf() {
		if( function_exists('acf_add_local_field_group') ):

			acf_add_local_field_group(array(
				'key' => 'group_5cd44dac63578',
				'title' => 'Staff Details',
				'fields' => array(
					array(
						'key' => 'field_5cd44dd099191',
						'label' => 'Job Titles',
						'name' => 'staff_job_titles',
						'type' => 'repeater',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 0,
						'max' => 0,
						'layout' => 'table',
						'button_label' => 'Add a Job Title',
						'sub_fields' => array(
							array(
								'key' => 'field_5cd44e82fd6d5',
								'label' => 'Job Title',
								'name' => 'staff_job_title',
								'type' => 'text',
								'instructions' => 'Add and re-order staff job titles. Staff will be displayed in order of the job titles, and then alphabetically within each job title group.',
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
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'acf-options',
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
			
		endif;
	}
	
	public function setup_job_title_choices( $field ) {
		/* Check the ACF for rows */
		if( have_rows('staff_job_titles', 'options') ):
			
			/* Loop through any existing rows */
			while ( have_rows('staff_job_titles', 'options') ) : the_row();

				//$job_title_id = get_row_index();
				$job_title = get_sub_field('staff_job_title');

				$choices[] = $job_title;
				$titles[] = $job_title;

				if( is_array($choices) ){
					foreach (array_combine($choices, $titles) as $choice => $title) {
						$field['choices'][ $choice ] = $title;
					}
				}

			endwhile;

		else :

			// Display placeholder
			$field['choices'] = array(
				'0' => 'No job titles found...'
			);

		endif;

		return $field;
	}


	private function get_sorted_user_array(){
		$sorted_users = array();
	
		/* Check the ACF for rows */
		if( have_rows('staff_job_titles', 'options') ):
		  
		  /* Loop through any existing rows */
		  while ( have_rows('staff_job_titles', 'options') ) : the_row();
		
		  //$job_title_id = get_row_index();
		  $job_title = get_sub_field('staff_job_title', 'options');
		
		  /* Setup arguments for WP DB Query */
		  $args = array(
			'role__in' => array( Atlantic_Residential_Roles::$BROKER_ROLE_SLUG, Atlantic_Residential_Roles::$MANAGER_ROLE_SLUG ),
			'meta_key'      => 'job_title',
			'meta_value'    => $job_title,
			'meta_compare'  => '=',
			'orderby'       => 'display_name',
			'order'         => 'ASC'
		  );
		
		  $user_query = new WP_User_Query( $args );
		
		  if ( ! empty( $user_query->get_results() ) ) {
			/* Append results to end of sorted users array */
			$sorted_users = array_merge( $sorted_users, $user_query->get_results() );
		  }
		
		  endwhile;
		
		else :
		
		  /* No AFC job titles added to system, therefore just query the users in alphabetical order */
		  $args = array(
			'role__in' => array( Atlantic_Residential_Roles::$BROKER_ROLE_SLUG, Atlantic_Residential_Roles::$MANAGER_ROLE_SLUG ),
			'orderby'       => 'display_name',
			'order'         => 'ASC'
		  );
		
		  $sorted_users = new WP_User_Query( $args );
		  $sorted_users = $sorted_users->get_results();
		
		endif;
	
		return $sorted_users;
	  }

}
