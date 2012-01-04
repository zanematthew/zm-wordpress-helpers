<?php
/**
 * If we have a taxnonomy show the Term and Term Description
 */
 ?>
 <?php if ( is_tax() ) : ?>
    <div class="hentry hentry-first">
        <?php $taxonomy = get_term( $wp_query->queried_object->term_id, $wp_query->query_vars['taxonomy'] ); ?>             
        <h1><?php print $taxonomy->name; ?></h1>
        <span class="m-dash">&mdash;</span>                 
        <p><?php print $taxonomy->description; ?></p>               
    </div>
<?php
/**
 * Else just show a default Quote Archive message.
 */
 ?>    
<?php else : ?>
<div class="hentry hentry-first">                
    <h1>Quotes</h1>
    <span class="m-dash">&mdash;</span>                 
    <p>Archived collection of quotes.</p>
</div>            
<?php endif; ?>

<?php
/**
 * Build out our basic loop
 */
?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <div <?php post_class('result')?>>
        <h2 class="title post-title" data-post_id="<?php echo $post->ID; ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <div class="utility-zm-quote-tracker">
            <div class="tag-container">
                <?php print zm_base_get_the_term_list( array( 'post_id' => $id , 'post_type' => $post_type, 'taxonomy' => 'zm-quote-tag' ) ); ?>
            </div>
        </div>        
    </div>
<?php endwhile; ?>