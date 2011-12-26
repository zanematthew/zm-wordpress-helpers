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
    <div class="single-zm-quote-tracker">
        <div class="sidebar-zm-quote-tracker">
            Browse by
            <span class="m-dash">&mdash;</span>    
            <?php foreach ( $cpt_obj[ $post_type ]->taxonomies as $tax ) : ?>
                <?php zm_base_list_terms( array('taxonomy' => $tax, 'label' => '', 'extra_class' => 'my-twipsy', 'link' => 'anchor', 'post_type' => $post_type ) ); ?>
            <?php endforeach; ?>
        </div>
        <!-- End 'sidebar' -->

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

                <div class="utility-zm-quote-tracker">        
                    <strong>Title </strong><h1 class="title post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                    <?php foreach ( $cpt_obj[$post_type]->taxonomies as $tax ) : ?>
                        <?php $term = zm_base_get_the_term_list( array( 'post_id' => $id , 'post_type' => $post_type, 'taxonomy' => $tax, 'link' => 'anchor') ); ?>
                        <?php if ( ! is_null( $term ) ) : ?>
                            <div class="<?php print $tax; ?>-container"><strong><?php print $tax; ?></strong>        
                                <?php print $term; ?>            
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
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