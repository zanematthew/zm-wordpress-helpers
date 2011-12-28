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

?>
<div class="container-zm-quote-tracker">
    <div class="taxonomy-zm-quote-tracker">
        <div class="sidebar-zm-quote-tracker">
            <ul>
                <li>Admin Menu</li>
                <li><?php do_action('create_quote'); ?></li>
                <?php if ( current_user_can( 'administrator' ) ) : ?>
                    <li><a href="<?php bloginfo('wpurl');?>/wp-admin" title="Click to go to WordPress admin">WordPress Admin</a></li>
                <?php endif; ?>                                                 
				<span class="m-dash">&mdash;</span>    
                <li><a href="<?php echo wp_logout_url( 'http://' . $_SERVER['HTTP_HOST'] . '/quotes' ); ?>" title="Click here to Log out">Logout</a></li>
            </ul>
            Browse by
            <span class="m-dash">&mdash;</span>                
            <?php foreach ( $cpt_obj[ $post_type ]->taxonomies as $tax ) : ?>
                <?php zm_base_list_terms( array('taxonomy' => $tax, 'label' => '', 'extra_class' => 'my-twipsy', 'post_type' => $post_type ) ); ?>
            <?php endforeach; ?>
        </div>
        <!-- End 'sidebar' -->

        <div class="main-zm-quote-tracker">        	
        	<div class="hentry">            	
				<h1>Quotes</h1>
            	<span class="m-dash">&mdash;</span>    				
				<p>Archived collection of quotes.</p>
			</div>        
            <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <div <?php post_class('result')?>>
                <h2 class="title post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div class="utility-zm-quote-tracker">
                	<div class="tag-container">
						<?php print zm_base_get_the_term_list( array( 'post_id' => $id , 'post_type' => $post_type, 'taxonomy' => 'zm-quote-tag', 'link' => 'anchor') ); ?>
					</div>
                </div> 
                <!-- End 'utility' -->
            </div>
            <!-- End 'post_class' -->
        <?php endwhile; ?>
        </div>
        <!-- End 'main' -->
    </div>
    <!-- End 'single' -->
</div>
<!-- End 'container' -->
<?php get_footer(); ?>