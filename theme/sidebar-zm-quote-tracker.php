<!-- Start 'sidebar' -->
<div class="sidebar-zm-quote-tracker">
    <ul>
        <li><strong>Admin Menu</strong></li>
        <?php if ( current_user_can( 'administrator' ) ) : ?>
            <li><?php do_action('create_quote'); ?></li>    
            <li><a href="<?php bloginfo('wpurl');?>/wp-admin" title="Click to go to WordPress admin" class="admin">WordPress Admin</a></li>        
        <li><a href="<?php echo wp_logout_url( 'http://' . $_SERVER['HTTP_HOST'] . '/quotes' ); ?>" title="Click here to Log out" class="logout">Logout</a></li>
        <?php endif; ?>                                                                 
    </ul>
    <span class="m-dash">&mdash;</span>        
    <a href="<?php bloginfo('url');?>/quote-archive/#/">View All</a>
    <span class="m-dash">&mdash;</span>        
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