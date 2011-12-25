<?php

/**
 * Get somethings and do a little bit of thinking before calling the redirect methods.
 * @package Template Redirect
 *
 * @uses wp_register_style()
 * @uses wp_registere_script()
 * @uses is_admin()
 * @uses get_query_var()
 * @uses $this->singleRedirect()
 * @uses $this->taxonomyRedirect()
 * @uses $this->archiveRedirect()
 */
function quote_tracker_redirect( $params=array() ) {    
    global $post;    
    $current_post_type = $post->post_type;
    $custom_template  = plugin_dir_path( __FILE__ ) . 'theme/single-' . $current_post_type . '.php';

    wp_enqueue_style( 'quote-tracker-base', plugin_dir_url( __FILE__ ) . 'theme/style.css', '', 'all' );
/*

    if ( ! is_admin() ) {
        // Regsiter our jQuery plugins and extra JavaScript
        wp_register_script( 'zm-cpt-hash',         plugin_dir_url( __FILE__ ) . 'js/hash.js',                                   array('jquery', 'jquery-ui-core', 'jquery-ui-dialog' ), '0.0.1' );
        wp_register_script( 'zm-cpt-cud',          plugin_dir_url( __FILE__ ) . 'js/cud.js',                                    array('jquery'), '0.0.1' );
        wp_register_script( 'jquery-ui-effects',   plugin_dir_url( __FILE__ ) . 'js/jquery-ui/jquery-ui-1.8.13.effects.min.js', array('jquery'), '1.8.13' );            
        wp_register_script( 'inplace-edit-script', plugin_dir_url( __FILE__ ) . 'js/inplace-edit/inplace-edit.js',              array('jquery'), '0.1' );                        
        wp_register_style(  'inplace-edit-style',  plugin_dir_url( __FILE__ ) . 'js/inplace-edit/inplace-edit.css',             '', 'all' );

        // Regsiter our base JS, note the dependencies
        wp_register_script( 'zm-cpt-base', plugin_dir_url( __FILE__ ) . 'js/base.js', array( 'jquery', 'inplace-edit-script', 'zm-cpt-hash', 'zm-cpt-cud', 'jquery-ui-effects' ), '0.0.1' );

        // Regsiter our CSS files
        wp_register_style( 'zm-cpt-base',        plugin_dir_url( __FILE__ ) . 'css/style.css',    '',                   'all' );
        wp_register_style( 'zm-cpt-single',      plugin_dir_url( __FILE__ ) . 'css/single.css',   array('zm-cpt-base'), 'all' );
        wp_register_style( 'zm-cpt-taxonomy',    plugin_dir_url( __FILE__ ) . 'css/taxonomy.css', array('zm-cpt-base'), 'all' );
        wp_register_style( 'zm-cpt-archive',     plugin_dir_url( __FILE__ ) . 'css/archive.css',  array('zm-cpt-base'), 'all' );            
        
        // Load twitter bootstrap
        wp_enqueue_style( 'twitter-bootstrap',  plugin_dir_url( __FILE__ ) . 'twitter-bootstrap/bootstrap.css', '', 'all' );            

        // Register some twitter bootstrap
        wp_register_script( 'bootstrap-twipsy',  plugin_dir_url( __FILE__ ) . 'twitter-bootstrap/js/bootstrap-twipsy.js',  array('jquery'), '1.4.0' );
        wp_register_script( 'bootstrap-popover', plugin_dir_url( __FILE__ ) . 'twitter-bootstrap/js/bootstrap-popover.js', '', '1.4.0' );
        wp_register_script( 'bootstrap-modal',   plugin_dir_url( __FILE__ ) . 'twitter-bootstrap/js/bootstrap-modal.js',   array('jquery'), '1.4.0' );
        wp_register_script( 'bootstrap-alerts',  plugin_dir_url( __FILE__ ) . 'twitter-bootstrap/js/bootstrap-alerts.js',  array('jquery'), '1.4.0' );
    }
*/    

    if ( is_single() ) {
        
        if ( file_exists( $custom_template ) ) {            
            
            wp_enqueue_script( 'bootstrap-twipsy' );
            wp_enqueue_script( 'bootstrap-popover' );

            if ( current_user_can( 'publish_posts' ) ) {
                wp_enqueue_script( 'inplace-edit-script' );
                wp_enqueue_style( 'inplace-edit-style' );
            }            

            wp_enqueue_style( 'zm-cpt-single' );
            wp_enqueue_script( 'zm-cpt-base' );                        

            load_template( $custom_template );                        
        }
        
    } elseif ( is_post_type_archive() ) {        
        $custom_template  = plugin_dir_path( __FILE__ ) . 'theme/archive-' . $current_post_type . '.php';        

        if ( file_exists( $custom_template ) ) {     
            wp_enqueue_style( 'zm-cpt-single' );
            wp_enqueue_script( 'zm-cpt-base' );            

            wp_enqueue_script( 'bootstrap-twipsy' );
            wp_enqueue_script( 'bootstrap-popover' );            
                      
            load_template( $custom_template );
        } else {
            print '<p>Default: ' . $default_template . '</p>';
            print '<p>Custom: ' . $custom_template . '</p>';                
            wp_die('Unable to load any template');
        }
        die();                
    } 
    else {
        die('for now');
    }
}
add_action('template_redirect', 'quote_tracker_redirect' );        

/**
 * Basic post submission for use with an ajax request
 *
 * @package Ajax
 *
 * @uses wp_insert_post();
 * @uses get_current_user_id()
 * @uses is_user_logged_in()
 * @uses is_wp_error()
 * @uses check_ajax_referer()     
 */
function postTypeSubmit() {
    // @todo needs to be generic for cpt
    check_ajax_referer( 'tt-ajax-forms', 'security' );

    if ( !is_user_logged_in() )
        return false;

    $error = null;        

    if ( empty( $_POST['post_title'] ) ) {
        $error .= '<div class="message">Please enter a <em>title</em>.</div>';
    }

    if ( empty( $_POST['content'] ) ) {
        $error .= '<div class="message">Please enter a some <em>content</em>.</div>';
    }

    if ( !is_null( $error ) ) {
        print '<div class="error-container">' . $error . '</div>';
        exit;
    }

    if ( current_user_can( 'publish_posts' ) )
        $status = 'publish';
    else
        $status = 'pending';

    unset( $_POST['action'] );

    foreach( $_POST as $k => $v )
        $_POST[$k] = esc_attr( $v );

    $type = $_POST['post_type'];
    $title = $_POST['post_title'];
    $content = $_POST['content'];

    unset( $_POST['post_title'] );
    unset( $_POST['content'] );
    unset( $_POST['post_author'] );
    unset( $_POST['post_type'] );
    unset( $_POST['security'] );
    
    $taxonomies = $_POST;

    $author_ID = get_current_user_id();

    $post = array(
        'post_title' => $title,
        'post_content' => $content,
        'post_author' => $author_ID,            
        'post_type' => $type,
        'post_status' => $status,
        'tax_input' => $_POST
    );

    $post_id = wp_insert_post( $post, true );
    
    if ( is_wp_error( $post_id ) ) {         
        print_r( $post_id->get_error_message() );              
        print_r( $post_id->get_error_messages() );              
        print_r( $post_id->get_error_data() );                      
    } else {            
        print '<div class="success-container"><div class="message">Your content was successfully <strong>Saved</strong></div></div>';
    }
    die();
} // End 'postTypeSubmit'
add_action( 'wp_ajax_postTypeSubmit', 'postTypeSubmit' );


/**
 * Define callback function
 * Inside this function you can do whatever you can imagine
 * with the variables that are loaded in the do_action() call above.
 */
function who_is_hook( $a, $b ) {
    echo '<code>';
    print_r( $a ); // `print_r` the array data inside the 1st argument
    echo '</code>';
    echo '<br />'.$b; // echo linebreak and value of 2nd argument
} 

// add_action( $tag, $function_to_add, $priority, $accepted_args );
add_action( 'i_am_hook', 'who_is_hook', 10, 2 );  

// Define the arguments for the action hook
$a = array(
     'eye patch' => 'yes'
    ,'parrot' => true
    ,'wooden leg' => (int) 1
);
$b = 'And hook said: "I ate ice cream with peter pan."'; 

// Defines the action hook named 'i_am_hook'
//do_action( 'i_am_hook', $a, $b );