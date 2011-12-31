<?php

if ( ! is_admin() ) {
    wp_enqueue_script( 'zm-cpt-hash', plugin_dir_url( __FILE__ ) . 'library/hash.js', array('jquery' ), '0.0.1' );
    wp_enqueue_script( 'zm-ajax-load', plugin_dir_url( __FILE__ ) . 'library/wp-ajax-load.js', array('jquery' ), '0.0.1' );
    wp_enqueue_style( 'zm-ajax-css', plugin_dir_url( __FILE__ ) . 'library/wp-ajax-load.css' );
}

/** 
 * loads a template from a specificed path
 *
 * @uses load_template()
 */
function zm_ajax_load_post() {	
    //if ( empty( $_POST['template'] ) )
    //    wp_die( 'Yo, you need a template!');	
	$post = get_post( $_POST['post_id'] ); 
    
    $title = '<div class="post-title">' . $post->post_title . '</div>';
    $content = '<div class="post-content"><p>' . $post->post_content . '</p></div>';    
    $perma_link = '<a href="'.$post->post_name.'">Link</a>';
    $spacer = '<span class="spacer">|</span>';
    $comment = '<a href="#" class="comment">Comment</a>';
    $close = '<a href="#" class="close">X</a>';    
    $navigation = '<div class="navigation-container">'.$perma_link.$spacer.$comment.$spacer.$close.'</div>';

    
    print '<div class="zm-ajax-post-container">' . $title.$content.$navigation . '</div>';   
    die();
} // loadTemplate    
add_action( 'wp_ajax_zm_ajax_load_post', 'zm_ajax_load_post' );
add_action( 'wp_ajax_nopriv_zm_ajax_load_post', 'zm_ajax_load_post' );
