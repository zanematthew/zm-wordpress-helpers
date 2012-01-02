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

<div id="search_navigation" class="search-navigation-container">
    <em>Browse by</em> 
    <a href="#" class="current">Basic</a><span class="bar">|</span><a href="#" class="inative">Advanced</a>
</div>
<div id="basic_search" class="search-by">
    <?php zm_base_list_terms( array('taxonomy' => 'book', 'extra_class' => 'my-twipsy', 'post_type' => $post_type ) ); ?>            
    <span class="m-dash">&mdash;</span>
    <?php zm_base_list_terms( array('taxonomy' => 'movie', 'extra_class' => 'my-twipsy', 'post_type' => $post_type ) ); ?>            
    <span class="m-dash">&mdash;</span>
    <?php zm_base_list_terms( array('taxonomy' => 'song', 'extra_class' => 'my-twipsy', 'post_type' => $post_type ) ); ?>            
    <span class="m-dash">&mdash;</span>
    <?php zm_base_list_terms( array('taxonomy' => 'people', 'extra_class' => 'my-twipsy', 'post_type' => $post_type ) ); ?>            
    <span class="m-dash">&mdash;</span>
    <?php zm_base_list_terms( array('taxonomy' => 'zm-quote-tag', 'label' => 'Quote Tag', 'extra_class' => 'my-twipsy', 'post_type' => $post_type ) ); ?>            
</div>
<div id="advanced_search" class="search-by" style="display: none;">
    <div class="zm-default-form-container">
        <form action="javascript://" id="filter_task_form">        
            <div class="form-wrapper">
                <input type="hidden" value="task" name="post_type" />
                <?php zm_base_build_input( array( 'taxonomy' => 'book', 'prepend' => 'book-', 'type' => 'checkbox' ) ); ?>                
                <span class="m-dash">&mdash;</span> 
                <?php zm_base_build_input( array( 'taxonomy' => 'movie', 'prepend' => 'movie-', 'type' => 'checkbox' ) ); ?>                
                <span class="m-dash">&mdash;</span> 
                <?php zm_base_build_input( array( 'taxonomy' => 'song', 'prepend' => 'song-', 'type' => 'checkbox' ) ); ?>                
                <span class="m-dash">&mdash;</span> 
                <?php zm_base_build_input( array( 'taxonomy' => 'people', 'prepend' => 'people-', 'type' => 'checkbox' ) ); ?>                
                <span class="m-dash">&mdash;</span> 
                <?php zm_base_build_input( array( 'taxonomy' => 'zm-quote-tag', 'prepend' => 'zm-quote-tag-', 'type' => 'checkbox', 'label' => 'Quote Tag' ) ); ?>                
            </div>
        </form>
    </div>
</div>
        </div>
        <!-- End 'sidebar' -->

        <div class="main-zm-quote-tracker">        	
        	<div class="hentry">
            	<?php $taxonomy = get_term( $wp_query->queried_object->term_id, $wp_query->query_vars['taxonomy'] ); ?>            	
				<h1><?php print $taxonomy->name; ?></h1>
            	<span class="m-dash">&mdash;</span>    				
				<p><?php print $taxonomy->description; ?></p> 				
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