<?php

require_once( get_template_directory() . '/includes/acf/torque-acf-search-class.php' );

class Atlantic_Residential_ACF {

  public function __construct() {
    add_action('admin_init', array( $this, 'acf_admin_init'), 99);
    add_action('acf/init', array( $this, 'acf_init' ) );

    // hide acf in admin - client doesnt need to see this
    // add_filter('acf/settings/show_admin', '__return_false');

    // add acf fields to wp search
    if ( class_exists( 'Torque_ACF_Search' ) ) {
      add_filter( Torque_ACF_Search::$ACF_SEARCHABLE_FIELDS_FILTER_HANDLE, array( $this, 'add_fields_to_search' ) );
    }
  }

  public function acf_admin_init() {
    // hide options page
    // remove_menu_page('acf-options');
  }

  public function add_fields_to_search( $fields ) {
    // $fields[] = 'custom_field_name';
    return $fields;
  }

  public function acf_init() {

    acf_add_local_field_group(array(
      'key' => 'group_5c953fd028818',
      'title' => 'Company Details',
      'fields' => array(
        array(
          'key' => 'field_5c953fd49ef57',
          'label' => 'Address',
          'name' => 'address',
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
          'rows' => 4,
          'new_lines' => 'br',
        ),
        array(
          'key' => 'field_5c953fe99ef58',
          'label' => 'Phone',
          'name' => 'phone',
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
          'key' => 'field_5c953fff9ef59',
          'label' => 'Fax',
          'name' => 'fax',
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
          'key' => 'field_5c953fff9ef22',
          'label' => 'Email',
          'name' => 'email',
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
          'key' => 'field_5c9540109ef5a',
          'label' => 'Copyright',
          'name' => 'copyright',
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

    acf_add_local_field_group(array(
			'key' => 'group_5ce3438132e73',
			'title' => 'Social Media',
			'fields' => array(
				array(
					'key' => 'field_5ce34402d4dab',
					'label' => 'Social Media',
					'name' => 'social_media',
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
					'button_label' => '',
					'sub_fields' => array(
						array(
							'key' => 'field_5ce34426d4dac',
							'label' => 'Social Channel',
							'name' => 'social_channel',
							'type' => 'select',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'choices' => array(
								'twitter' => 'Twitter',
								'linkedin' => 'LinkedIn',
								'instagram' => 'Instagram',
								'facebook' => 'Facebook',
								'youtube' => 'YouTube',
							),
							'default_value' => array(
							),
							'allow_null' => 0,
							'multiple' => 0,
							'ui' => 0,
							'return_format' => 'value',
							'ajax' => 0,
							'placeholder' => '',
						),
						array(
							'key' => 'field_5ce34444d4dad',
							'label' => 'Social URL',
							'name' => 'social_url',
							'type' => 'url',
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
    
    acf_add_local_field_group(array(
      'key' => 'group_5d17d7b1829b6',
      'title' => 'Header Style',
      'fields' => array(
        array(
          'key' => 'field_5d17d7f1eb04a',
          'label' => 'Light or Dark?',
          'name' => 'light_or_dark_header',
          'type' => 'select',
          'instructions' => 'Select light for darkly colored backgrounds, and dark for lightly colored backgrounds',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'choices' => array(
            'light' => 'Light Header',
            'dark' => 'Dark Header',
          ),
          'default_value' => array(
            0 => 'dark: Dark Header',
          ),
          'allow_null' => 0,
          'multiple' => 0,
          'ui' => 0,
          'return_format' => 'value',
          'ajax' => 0,
          'placeholder' => '',
        ),
      ),
      'location' => array(
        array(
          array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'page',
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
      'key' => 'group_5c954a9073a65',
      'title' => 'Page Hero',
      'fields' => array(
        array(
          'key' => 'field_5c954a9886085',
          'label' => 'Type',
          'name' => 'hero_type',
          'type' => 'select',
          'instructions' => '',
          'required' => 1,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'choices' => array(
            'none' => 'None',
            'image' => 'Image',
            'image_slideshow' => 'Image Slideshow',
            'video' => 'Video',
          ),
          'allow_null' => 0,
          'other_choice' => 0,
          'default_value' => 'image',
          'layout' => 'horizontal',
          'return_format' => 'value',
          'save_other_choice' => 0,
        ),
        array(
          'key' => 'field_3c568c452lak',
          'label' => 'Positioning',
          'name' => 'hero_positioning',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'choices' => array(
            'none' => 'None',
            'top' => 'Top of the viewport',
            'after' => 'After the header bar',
          ),
          'allow_null' => 0,
          'other_choice' => 0,
          'default_value' => 'none',
          'layout' => 'horizontal',
          'return_format' => 'value',
          'save_other_choice' => 0,
        ),
        array(
          'key' => 'field_5c568c9903dfjx',
          'label' => 'Text Alignment',
          'name' => 'hero_alignment',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'choices' => array(
            'none' => 'None',
            'left' => 'Left Aligned',
            'center' => 'Center Aligned',
            'right' => 'Right Aligned',
          ),
          'allow_null' => 0,
          'other_choice' => 0,
          'default_value' => 'none',
          'layout' => 'horizontal',
          'return_format' => 'value',
          'save_other_choice' => 0,
        ),
        array(
          'key' => 'field_5c954ac486086',
          'label' => 'Image',
          'name' => 'hero_image',
          'type' => 'image',
          'instructions' => '',
          'required' => 1,
          'conditional_logic' => array(
            array(
              array(
                'field' => 'field_5c954a9886085',
                'operator' => '==',
                'value' => 'image',
              ),
            ),
          ),
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
          'key' => 'field_5c954ae486087',
          'label' => 'Image Slideshow',
          'name' => 'hero_image_slideshow',
          'type' => 'post_object',
          'instructions' => '',
          'required' => 1,
          'conditional_logic' => array(
            array(
              array(
                'field' => 'field_5c954a9886085',
                'operator' => '==',
                'value' => 'image_slideshow',
              ),
            ),
          ),
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'post_type' => array(
            0 => 'torque_slideshow',
          ),
          'taxonomy' => array(
          ),
          'allow_null' => 0,
          'multiple' => 0,
          'return_format' => 'id',
          'ui' => 1,
        ),
        array(
          'key' => 'field_5c954e7f5e0fc',
          'label' => 'Video Src',
          'name' => 'hero_video_src',
          'type' => 'file',
          'instructions' => '',
          'required' => 1,
          'conditional_logic' => array(
            array(
              array(
                'field' => 'field_5c954a9886085',
                'operator' => '==',
                'value' => 'video',
              ),
            ),
          ),
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'default_value' => '',
          'placeholder' => '',
                      'return_format' => 'url',
          'prepend' => '',
          'append' => '',
          'maxlength' => '',
        ),
        array(
          'key' => 'field_5c954bb12e42b',
          'label' => 'Overlay Title',
          'name' => 'hero_overlay_title',
          'type' => 'text',
          'instructions' => 'use em tags to emphasise certain words',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'default_value' => '',
          'placeholder' => 'eg <em>Emphasised text</em> in title',
          'prepend' => '',
          'append' => '',
          'maxlength' => '',
        ),
        array(
          'key' => 'field_5c954be22e42c',
          'label' => 'Overlay Subtitle',
          'name' => 'hero_overlay_subtitle',
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
            'value' => 'page',
          ),
          array(
            'param' => 'post_template',
            'operator' => '==',
            'value' => 'default',
          ),
        ),
        array(
          array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'page',
          ),
          array(
            'param' => 'post_template',
            'operator' => '==',
            'value' => 'contact.php',
          ),
        ),
        array(
          array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'page',
          ),
          array(
            'param' => 'post_template',
            'operator' => '==',
            'value' => 'careers.php',
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
      'key' => 'group_5c955c2570f80',
      'title' => 'Page Intro',
      'fields' => array(
        array(
          'key' => 'field_5c955c931df7b',
          'label' => 'Text Alignment',
          'name' => 'page_intro_alignment',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'choices' => array(
            'none' => 'None',
            'left' => 'Left Aligned',
            'center' => 'Center Aligned',
            'right' => 'Right Aligned',
          ),
          'allow_null' => 0,
          'other_choice' => 0,
          'default_value' => 'none',
          'layout' => 'horizontal',
          'return_format' => 'value',
          'save_other_choice' => 0,
        ),
        array(
          'key' => 'field_5c945c456df9e',
          'label' => 'Color Combination (Background/Text)',
          'name' => 'page_intro_color',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'choices' => array(
            'color1' => 'Dark Green/White',
            'color2' => 'Dark Green/Medium Green',
            'color3' => 'Dark Green/Light Green',
            'color4' => 'Medium Green/White',
            'color5' => 'Medium Green/Dark Green',
            'color6' => 'Medium Green/Light Green',
            'color7' => 'Light Green/White',
            'color8' => 'Light Green/Dark Green',
            'color9' => 'Light Green/Medium Green',
            'color10' => 'White/Dark Green',
            'color11' => 'White/Medium Green',
            'color12' => 'White/Light Green',
          ),
          'allow_null' => 0,
          'other_choice' => 0,
          'default_value' => 'none',
          'layout' => 'horizontal',
          'return_format' => 'value',
          'save_other_choice' => 0,
        ),
        array(
          'key' => 'field_5c955c421df79',
          'label' => 'Heading',
          'name' => 'page_heading',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => array(
            array(
              array(
                'field' => 'field_5c955c931df7b',
                'operator' => '!=',
                'value' => 'none',
              ),
            ),
          ),
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
          'key' => 'field_5c955c581df7a',
          'label' => 'Intro',
          'name' => 'page_intro',
          'type' => 'textarea',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => array(
            array(
              array(
                'field' => 'field_5c955c931df7b',
                'operator' => '!=',
                'value' => 'none',
              ),
            ),
          ),
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'default_value' => '',
          'placeholder' => '',
          'maxlength' => '',
          'rows' => 4,
          'new_lines' => 'br',
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
            'value' => 'default',
          ),
        ),
        array(
          array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'page',
          ),
          array(
            'param' => 'post_template',
            'operator' => '==',
            'value' => 'contact.php',
          ),
        ),
        array(
          array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'page',
          ),
          array(
            'param' => 'post_template',
            'operator' => '==',
            'value' => 'careers.php',
          ),
        ),
      ),
      'menu_order' => 2,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => 1,
      'description' => '',
    ));

  }
}

?>
