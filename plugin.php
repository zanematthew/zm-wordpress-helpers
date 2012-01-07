<?php
if ( is_admin() ) {
//    ini_set('display_errors', 'on');
//    error_reporting( E_ALL );
}

/**
 * Registers Custom post type: "Quote" with Quote taxonoimes: 
 */

/**
 * Plugin Name: Quote Tracker
 * Plugin URI: --
 * Description: A way to record your most inspirational Quotes
 * Version: .alpha
 * Author: Zane M. Kolnik
 * Author URI: http://zanematthew.com/
 * License: GP
 */

// CPT Library
require_once dirname( plugin_dir_path( __FILE__ ) ) . '/zm-cpt/plugin.php';

// Unique Templates for this Plugin
require_once plugin_dir_path( __FILE__ ) . 'template-redirect.php';
require_once plugin_dir_path( __FILE__ ) . 'functions-create.php';

// Libraries/Actions
require_once plugin_dir_path( __FILE__ ) . 'library/zm-ajax/functions.php';
require_once plugin_dir_path( __FILE__ ) . 'library/inplace-edit/functions.php';
require_once plugin_dir_path( __FILE__ ) . 'library/hash/functions.php';
require_once plugin_dir_path( __FILE__ ) . 'library/zm-wordpress-helpers/functions.php';

do_action( 'inplace-edit' );
do_action( 'hash-filter' );
do_action( 'zm-ajax' );

/**
 * Our class
 */
class QuotePostType extends zMCustomPostTypeBase { 
    
    // @todo do we need this?
    static $instance;

    public $dependencies = array();    
    /**
     * Every thing that is "custom" to our CPT goes here.
     */
    public function __construct() {
        
        wp_localize_script( 'my-ajax-request', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );                

        self::$instance = $this;       
        
        $this->dependencies['script'] = array(
            'jquery',
            'jquery-ui-core',
            'jquery-ui-dialog'
        );

        $this->dependencies['style'] = array(
            'tt-base-style',
            'inplace-edit-style'
            );

        parent::__construct();

        add_action( 'init', array( &$this, 'registerPostType' ) );        
        add_action( 'init', array( &$this, 'registerTaxonomy' ) );                                    

        add_action( 'wp_footer', array( &$this, 'createPostTypeDiv' ) );            
        add_action( 'wp_footer', array( &$this, 'createDeleteDiv' ) );            
                                
        register_activation_hook( __FILE__, array( &$this, 'registerActivation') );        
    }        

    /**
     * Activation Method -- Insert a sample BMX Race Schedule, a few terms
     * with descriptions and assign our sample Race Schedule to some terms.
     *
     * Note: This is completly optional BUT must be present! i.e.
     * public function registerActivation() {} is completly valid
     *
     * BEFORE! taxonomies are regsitered! therefore
     * these terms and taxonomies are NOT derived from our object!
     * Set to we know its been installed at least once before        
     *
     * @uses get_option()
     * @uses get_current_user_id()
     * @uses wp_insert_term()
     * @uses wp_insert_post()
     * @uses term_exists()
     * @uses wp_set_post_terms()
     * @uses update_option()
     */        
    public function registerActivation() {
        
        $installed = get_option( 'zm_qt_number_installed' );

        if ( $installed == '1' ) {        
            return;
        }

        $_zm_taxonomies = array(
            'book',
            'movie',
            'song',
            'people',        
            'zm-quote-tag'
        );

        $_zm_cpt = 'zm-quote-tracker';        
        
        $author_ID = get_current_user_id();
        
        $inserted_term = wp_insert_term( 'Atlas Shrugged', 'book', array( 'description' => 'A good book', 'slug' => 'atlas-shrugged') );

        $post = array(
            'post_title'   => 'Leave them',
            'post_content' => 'Those who deny it cannot be conquered by it, do not count leave them alone.',
            'post_excerpt' => 'Dagny Taggarant trying to get others to help',
            'post_author'  => $author_ID,            
            'post_type'    => $_zm_cpt,            
            'post_status'  => 'publish'
        );
        
        $post_id = wp_insert_post( $post, true );        
        
        if ( isset( $post_id ) ) {
            $term_id = term_exists( 'Atlas Shrugged', 'book' );
            wp_set_post_terms( $post_id, $term_id, 'book' );            

            update_option( 'zm_brs_number_installed', '1' );
        }
    }    
        
} // End 'CustomPostType'

/**
 * The following is not needed only helpful
 */
$_zm_cpt = 'zm-quote-tracker';

$_zm_taxonomies = array(
    'book',
    'movie',
    'song',
    'people',        
    'zm-quote-tag'
    );

/**
 * Init our object
 */
$_GLOBALS[ $_zm_cpt ] = new QuotePostType();
$_GLOBALS[ $_zm_cpt ]->post_type = array(
    array(
        'name' => 'Quote',
        'type' => $_zm_cpt,
        'rewrite' => array( 
            'slug' => 'quote-archive'
            ),
        'supports' => array(
            'title',            
            'excerpt',
            'editor',     
            'comments'
        ),
        'taxonomies' => $_zm_taxonomies
    )
);

/**
 * Note the post_type is a var, granted we could of also used the
 */
$_GLOBALS[ $_zm_cpt ]->taxonomy = array(
    array(
        'name' => 'book',
        'post_type' => $_zm_cpt,
        ),
    array(
        'name' => 'movie',
        'post_type' => $_zm_cpt,
        ),
    array(
        'name' => 'song',
        'post_type' => $_zm_cpt,
        ),
    array(
        'name' => 'people',
        'post_type' => $_zm_cpt,
        ),
    array(
        'name' => 'zm-quote-tag',
        'post_type' => $_zm_cpt,
        'menu_name' => 'Quote Tag',
        'singular_name' => 'Quote Tag'
        )                                
); 
