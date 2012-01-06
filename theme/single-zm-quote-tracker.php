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
$obj_tax = get_taxonomies( array( 'object_type' => array($post_type) ), $output='objects' );

?>
<div class="container-zm-quote-tracker">
    <div class="single-zm-quote-tracker">
        <?php load_template( plugin_dir_path( __FILE__ ) . 'sidebar-zm-quote-tracker.php'); ?>

        <div class="main-zm-quote-tracker">
            <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>    
            <div class="next-previous-container">
                <?php zm_next_post(); ?>
                <?php zm_previous_post(); ?>
            </div>
            <!-- End 'next-previous' -->

            <span class="m-dash">&mdash;</span>    
            
            <div <?php post_class('result')?>>
                <div class="post-content">
                    <blockquote>
                        <?php the_content(); ?>
                    </blockquote>
                </div>
                <?php if ( get_the_excerpt() ) : ?>            
                <div class="post-excerpt">                         
                    <p><?php the_excerpt(); ?></p>
                </div>
                <?php endif; ?>
                
                <span class="m-dash">&mdash;</span>

                <?php if ( is_user_logged_in() ) : ?>            
                    <a href="#" id="default_utility_edit_handle">Edit</a>
                <?php endif; ?>

                <div class="utility-zm-quote-tracker" id="utility-container">        
                    <strong>Title </strong><h1 class="title post-title"><?php the_title(); ?></h1>
                    <?php foreach ( $cpt_obj[$post_type]->taxonomies as $tax ) : ?>
                        <?php $term = zm_base_get_the_term_list( array( 'post_id' => $id , 'post_type' => $post_type, 'taxonomy' => $tax, 'link' => 'anchor') ); ?>
                        <?php if ( ! is_null( $term ) ) : ?>
                        <div class="<?php print $tax; ?>-container">
                            <strong><?php print $obj_tax[$tax]->labels->singular_name; ?></strong>
                            <?php print $term; ?>            
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div> 
                <?php if ( is_user_logged_in() ) : ?>            
                    <div class="zm-default-form-container default-update-container" id="default_utility_update_container" style="display: none;">
                        <a name="update"></a>
                        <form action="javascript://" method="POST" id="default_utility_udpate_form">
                            <input type="hidden" name="PostID" id="post_id" value="<?php echo $post->ID; ?>" />
                            <?php zm_base_build_options( 'book' ); ?>
                            <?php zm_base_build_options( 'movie' ); ?>
                            <?php zm_base_build_options( 'song' ); ?>
                            <?php zm_base_build_options( 'people' ); ?>            
                            <?php zm_base_build_options( array( 'taxonomy' => 'zm-quote-tag', 'multiple' => true, 'extra_class' => 'my-tags', 'label' => 'Quote Tags' ) ); ?>
                            <div class="button-container">
                                <div id="publishing-action">
                                    <div class="mini-button-container">
                                        <input class="update" type="submit" value="Update" accesskey="p" name="save" />                    
                                        <a href="javascript://" id="default_utility_update_exit" class="exit">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>                
                <!-- End 'utility' -->

<!-- Start 'Comment' -->
<div id="zm_ajax_comment_handle" data-post_id="<?php echo $id; ?>" data-template="<?php print plugin_dir_path(__FILE__);?>comment.php">
    <div id="zm_ajax_comment_target">
        <div class="zm_ajax_loading" style="display: none;"></div>
    </div>    
</div>
<!-- End 'Comment' -->
            
            <!-- End 'post_class' -->
            <script type="text/javascript">
            _post_id = <?php print $post->ID; ?>
            </script>
        <?php endwhile; ?>
        </div>
        <!-- End 'main' -->
    </div>
    <!-- End 'single' -->
</div>
<!-- End 'container' -->
<?php get_footer(); ?>