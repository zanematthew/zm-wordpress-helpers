<?php get_header(); ?>
<?php
/**
 * Derive our post_id, either from the post or if this file is loaded via ajax
 */
if ( !empty( $_POST['post_id'] ) )
    $id = (int)$_POST['post_id'];
else 
    $id = $post->ID;

/**
 * Derive our post_type, either from the post or if this file is loaded via ajax
 */
if ( !empty( $_POST['post_type'] ) )
    $post_type = $_POST['post_type'];
else 
    $post_type = 'zm-quote-tracker';

/**
 * Once we have our post_type, we get the object to have access to our taxonomies
 */
$cpt_obj = get_post_types( array( 'name' => $post_type), 'objects' );
zm_cpt_json_feed( $post_type='zm-quote-tracker', $taxonomies=$cpt_obj[ $post_type ]->taxonomies );
?>
<div class="container-zm-quote-tracker">
    <div class="taxonomy-zm-quote-tracker">
        <?php load_template( plugin_dir_path( __FILE__ ) . 'sidebar-zm-quote-tracker.php'); ?>
        <div class="main-zm-quote-tracker">        	
            <div id="filter_control_target" style="display: none;"></div>        	
            <div id="zm_ajax_the_loop">            
              <?php load_template( plugin_dir_path( __FILE__ ) . 'the-loop.php'); ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>