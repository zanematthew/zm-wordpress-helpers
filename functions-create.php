<?php
function add_quote(){ 
    // @todo needs to be generic for cpt
    check_ajax_referer( 'zm-quote-tracker-forms', 'security' );

    if ( !is_user_logged_in() )
        return false;

    $error = null;        

/*
    if ( empty( $_POST['post_title'] ) ) {
        $error .= '<div class="message">Please enter a <em>title</em>.</div>';
    }

    if ( ! is_null( $error ) ) {
        print '<div class="error-container">' . $error . '</div>';
        exit;
    }
*/

    foreach( $_POST as $k => $v )
        $_POST[$k] = esc_attr( $v );

    $author_ID = get_current_user_id();

    $post = array(
        'post_title' => $_POST['post_title'],
        'post_content' => $_POST['content'],
        'post_excerpt' => $_POST['excerpt'],
        'post_author' => $author_ID,            
        'post_type' => 'zm-quote-tracker',
        'post_date' => date( 'Y-m-d H:i:s' ),
        'post_status' => 'publish'
    );

    // should be white listed        
    // We'll trust anything left over is our tax => term
    unset( $_POST['action'] );
    unset( $_POST['security'] );
    unset( $_POST['post_type'] );
	unset( $_POST['post_title'] );
    unset( $_POST['content'] );
    unset( $_POST['excerpt'] );  
        
    $_POST['zm-quote-tag'] = explode( ", ", $_POST['zm-quote-tag'] );
    
    $post_id = wp_insert_post( $post, true );        

    if ( is_wp_error( $post_id ) ) {         
        print_r( $post_id->get_error_message() );              
        print_r( $post_id->get_error_messages() );              
        print_r( $post_id->get_error_data() );
        return;
    } else {            
        print '<div class="success-container"><div class="message">Your content was successfully <strong>Saved</strong></div></div>';
    }

    // Remember we "trust" whats left over from $_POST to be taxes
    // $v = term, $k = taxonomy
    foreach ( $_POST as $k => $v ) {            

        // If its an array we have tags
        if ( is_array( $v ) ) {
            
            foreach( $v as $tags => $tag ) {                                        
                $tag_id = term_exists( $tag, $k );
                
                // no tag id, add it                    
                if ( is_null( $tag_id ) ) {                        
                    $temp_tag = wp_insert_term( $tag, $k );            
                    $tag_id = $temp_tag['term_id'];                                 
                    wp_set_post_terms( $post_id, $tag_id, $k, true );
                } else {
                    $tag_id = $tag_id['term_id'];
                }
                wp_set_post_terms( $post_id, $tag_id, $k, true );                    
            }
        } 
        
        else {
            $term_id = term_exists( $v, $k );
            // we have a term update our post            
            if ( $term_id ) {
                wp_set_post_terms( $post_id, $term_id, $k );
            } else {
                // else insert the new term then update our post
                if ( !empty( $v ) ) {
                    $term = wp_insert_term( $v, $k );
                    $success = wp_set_post_terms( $post_id, $term['term_id'], $k );            
                }
            }                
        }            
    }                
    
	die();
}
add_action( 'wp_ajax_add_quote', 'add_quote' );

function create_zm_quote_tracker( ) {

    $js_depends = array(
        'jquery', 
        'jquery-ui-core', 
        'jquery-ui-dialog', 
        'jquery-effects-core',
        'chosen'
        );

	wp_enqueue_style( 'chosen-css', plugin_dir_url( __FILE__ ) . 'library/chosen/chosen.css',             '', 'all' );
    wp_enqueue_style( 'wp-jquery-ui-dialog' );
    wp_enqueue_script( 'chosen', plugin_dir_url( __FILE__ ) . 'library/chosen/chosen.jquery.js', array('jquery') );
    wp_enqueue_script( 'quote-tracker-script', plugin_dir_url( __FILE__ ) . 'theme/create.js', $js_depends );    
       
    add_action( 'wp_footer', function(){
        print '<div id="create_zm_quote_tracker_dialog" class="dialog-container" title="Add a new <em>Quote</em>">
        <div id="create_zm_quote_tracker_target" style="display: none;"></div>
        </div>';    
    });
    
    print '<a href="javascript:void(0);" id="create_zm_quote_tracker_handle" data-template="' . plugin_dir_path( __FILE__ ) . 'theme/create.php" data-post_type="'. $cpt .'">Add a Quote!</a>';
}
add_action( 'create_quote', 'create_zm_quote_tracker', 10 );


 