<?php

function zm_inplace_edit(){
	if ( ! is_admin() ) {	
    	wp_enqueue_script( 'inplace-edit-script', plugin_dir_url( __FILE__ ) . 'inplace-edit.js', array('jquery'), '0.1' );
    	wp_enqueue_script( 'temp-localize', plugin_dir_url( __FILE__ ) . 'script.js', array('inplace-edit-script'), '0.1' );
	    wp_enqueue_style( 'inplace-edit-style', plugin_dir_url( __FILE__ ) . 'inplace-edit.css', '', 'all' );	    
	}
}
add_action( 'inplace-edit', 'zm_inplace_edit' );

/**
 * Update a Post using the Current Users ID
 *
 * @package Ajax
 *
 * @uses wp_update_post()
 * @uses wp_get_current_user()
 * @uses is_user_logged_in()
 * @uses current_user_can()
 *
 * @todo add check_ajax_refere()
 */
function zm_inplace_edit_update_post( $post ) {    
    // @todo add check_ajax_referer
    if ( !is_user_logged_in() )
        return false;

    if ( current_user_can( 'publish_posts' ) )
        $status = 'publish';
    else
        $status = 'pending';

    unset( $_POST['action'] );
            
    // @todo validateWhiteList( $white_list, $data )

    $current_user = wp_get_current_user();                
    $_POST['post_author'] = $current_user->ID;
    $_POST['post_modified'] = current_time('mysql');                

    $update = wp_update_post( $_POST );

    die();
} // postTypeUpdate
add_action( 'wp_ajax_zm_inplace_edit_update_post', 'zm_inplace_edit_update_post' );
add_action( 'wp_ajax_nopriv_zm_inplace_edit_update_post', 'zm_inplace_edit_update_post' );


// @todo ajax refer
function zm_inplace_edit_update_utility(){

    if ( !is_user_logged_in() )
        return false;
    
    $post_id = $_POST['PostID'];
    
    unset( $_POST['action'] );
    unset( $_POST['PostID'] );
    
    $taxonomies = $_POST;
    
    // prep our data    
    foreach( $taxonomies as $taxonomy => $term ){
        if ( is_array( $term ) ) {            
            $taxonomies[ $taxonomy ] = implode( ",", $term );
        }
    }

    foreach ( $taxonomies as $taxonomy => $term ) {
        if ( $term ) {            
            wp_set_post_terms( $post_id, $term, $taxonomy );    
        }
    }

    die();
}
add_action( 'wp_ajax_zm_inplace_edit_update_utility', 'zm_inplace_edit_update_utility' );
add_action( 'wp_ajax_nopriv_zm_inplace_edit_update_utility', 'zm_inplace_edit_update_utility' );
