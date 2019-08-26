<?php

require_once( get_stylesheet_directory() . '/includes/atlantic-residential-child-nav-menus-class.php');
require_once( get_stylesheet_directory() . '/includes/widgets/atlantic-residential-child-widgets-class.php');
require_once( get_stylesheet_directory() . '/includes/customizer/atlantic-residential-child-customizer-class.php');
/* ACF Includes */
require_once( get_stylesheet_directory() . '/includes/acf/atlantic-residential-child-acf-class.php');
/* CPT Includes */
require_once( get_stylesheet_directory() . '/includes/cpts/atlantic-residential-child-job-application-cpt-class.php');
require_once( get_stylesheet_directory() . '/includes/cpts/atlantic-residential-child-listing-cpt-class.php');
/* Roles CPT */
require_once( get_stylesheet_directory() . '/includes/atlantic-residential-child-roles-class.php');


/**
* Custom Roles
*/
if ( class_exists( 'Atlantic_Residential_Roles' ) ) {
  new Atlantic_Residential_Roles();
}

/**
 * Child Theme Nav Menus
 */
 if ( class_exists( 'Atlantic_Residential_Nav_Menus' ) ) {
   new Atlantic_Residential_Nav_Menus();
 }

/**
 * Child Theme Widgets
 */
if ( class_exists( 'Atlantic_Residential_Widgets' ) ) {
  new Atlantic_Residential_Widgets();
}

/**
 * Child Theme Customizer
 */
if ( class_exists( 'Atlantic_Residential_Customizer' ) ) {
  new Atlantic_Residential_Customizer();
}

/**
 * Child Theme ACF
 */
if ( class_exists( 'Atlantic_Residential_ACF' ) ) {
  new Atlantic_Residential_ACF();
}

/**
* Listing CPT
*/
if ( class_exists( 'Atlantic_Residential_Listing_CPT' ) ) {
  new Atlantic_Residential_Listing_CPT();
}

/**
* Careers plugin settings
*/
if ( class_exists( 'Torque_Careers' ) ) {
  if ( class_exists( 'Atlantic_Residential_Job_Application_CPT' ) ) {
    new Atlantic_Residential_Job_Application_CPT();
  }
}

/**
 * Admin settings
 */

 // remove menu items
 function torque_remove_menus(){

   //remove_menu_page( 'index.php' );                  //Dashboard
   //remove_menu_page( 'edit.php' );                   //Posts
   //remove_menu_page( 'upload.php' );                 //Media
   //remove_menu_page( 'edit.php?post_type=page' );    //Pages
   //remove_menu_page( 'edit-comments.php' );          //Comments
   //remove_menu_page( 'themes.php' );                 //Appearance
   //remove_menu_page( 'plugins.php' );                //Plugins
   //remove_menu_page( 'users.php' );                  //Users
   //remove_menu_page( 'tools.php' );                  //Tools
   //remove_menu_page( 'options-general.php' );        //Settings

 }
 add_action( 'admin_menu', 'torque_remove_menus' );

/**
 * Update author slug to 'team'
 */
add_action('init', 'update_author_slug');
function update_author_slug() {
    global $wp_rewrite;
    $author_slug = 'leadership'; // change slug name
    $wp_rewrite->author_base = $author_slug;
}

/**
 * Enqueues
 */

// enqueue child styles after parent styles, both style.css and main.css
// so child styles always get priority
add_action( 'wp_enqueue_scripts', 'torque_enqueue_child_styles' );
function torque_enqueue_child_styles() {

    $parent_style = 'parent-styles';
    $parent_main_style = 'torque-theme-styles';

    // make sure parent styles enqueued first
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( $parent_main_style, get_template_directory_uri() . '/bundles/main.css' );

    // enqueue child style
    wp_enqueue_style( 'atlantic-residential-child-styles',
        get_stylesheet_directory_uri() . '/bundles/main.css',
        array( $parent_style, $parent_main_style ),
        wp_get_theme()->get('Version')
    );
}

// enqueue child scripts after parent script
add_action( 'wp_enqueue_scripts', 'torque_enqueue_child_scripts');
function torque_enqueue_child_scripts() {

    wp_enqueue_script( 'atlantic-residential-child-script',
        get_stylesheet_directory_uri() . '/bundles/bundle.js',
        array( 'torque-theme-scripts' ), // depends on parent script
        wp_get_theme()->get('Version'),
        true       // put it in the footer
    );
}


/**
 * Customise the Jetpack 'Successful Submission' message
 */
add_filter( 'grunion_contact_form_success_message', 'jetpackcom_contact_confirmation' );
function jetpackcom_contact_confirmation() {
  // Add new confirmation message here:
  $conf = __( '<div class="contact-form-success-message">Thank you! Our team will respond as soon as possible.</div>', 'plugin-textdomain' );
  return $conf;
}


/**
 * Map Settings
 */
if ( class_exists( 'Torque_Map_CPT' ) ) {
  add_filter( Torque_Map_CPT::$POIS_ALLOWED_FILTER , function() { return 4; });
}
if ( class_exists( 'Torque_Map_Controller' ) ) {
  add_filter( Torque_Map_Controller::$DISPLAY_POIS_FILTER , function() { return true; });
  add_filter( Torque_Map_Controller::$POIS_LOCATION , function() { return 'top'; });
}


/**
 * Alter search posts per page
 */
/* function limit_search_results_per_page($query) {
  if ( $query->is_search ) {
      $query->set( 'posts_per_page', '10' );
  }
  return $query;
}
add_filter( 'pre_get_posts','limit_search_results_per_page' ); */


add_action('admin_footer', function(){ ?>
  <script>
    // Hide the default image and bio fields in user profile
    jQuery('h2:contains("About the user"), tr.user-description-wrap, tr.user-profile-picture').hide();
    
    if ( jQuery('textarea#description').text() != '' && jQuery('textarea[name="acf[field_5d640f368ef86]"]').text() == '' ) {
      // if no info in the new bio field, and the old bio field isn't empty, copy the text across
      jQuery('textarea[name="acf[field_5d640f368ef86]"]').text( jQuery('textarea#description').text() );
      jQuery('textarea#description').text('');
    } else if ( jQuery('textarea[name="acf[field_5d640f368ef86]"]').text() != '' ) {
      // if the new bio field has data, copy it across to the old field (in case this field is displayed anywhere; searches, etc...)
      // NB: requires page to be reloaded and saved...
      jQuery('textarea#description').text( jQuery('textarea[name="acf[field_5d640f368ef86]"]').text() );
    }
  </script>
<?php });

?>
