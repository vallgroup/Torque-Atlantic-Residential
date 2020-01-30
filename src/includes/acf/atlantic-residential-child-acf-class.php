<?php

require_once(get_template_directory() . '/includes/acf/torque-acf-search-class.php');

class Atlantic_Residential_ACF {

  public function __construct() {
    add_action('admin_init', array( $this, 'acf_admin_init' ), 99 );
    add_action('acf/init', array( $this, 'register_acf_fields' ) );

    // hide acf in admin - client doesnt need to see this
    // add_filter('acf/settings/show_admin', '__return_false');

    // add acf fields to wp search
    if (class_exists('Torque_ACF_Search')) {
      add_filter(Torque_ACF_Search::$ACF_SEARCHABLE_FIELDS_FILTER_HANDLE, array($this, 'add_fields_to_search'));
    }
  }

  public function acf_admin_init() {
    // hide options page
    // remove_menu_page('acf-options');
  }

  public function add_fields_to_search( $fields ) {
    // $fields[] = 'custom_field_name';
    $fields[] = 'city';
    $fields[] = 'state';
    $fields[] = 'street_address';
    return $fields;
  }

  public function register_acf_fields() {
    /**
     * UPDATED: 20200130
     * 
     * NOTE 1: For some reason the ACF definitions aren't loading when placed here, as a part of the 'acf/init' action callback.
     *  So instead, for the moment, the definitions are currently located in the '/acf-json/' folder, found in the child theme root
     *  directory, and have been removed from the DB.
     *  See ACF documentation on local JSON for clarification: https://www.advancedcustomfields.com/resources/local-json/
     * 
     * NOTE 2: The ACF defintions are working from the Atlantic_Residential_Roles class, therefore I have left them in-place.
     * 
     * - Al Notara
    */ 
  }
}
