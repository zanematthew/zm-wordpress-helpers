<?php

$cpt = $_POST['post_type'];
$cpt_obj = get_post_types( array( 'name' => $cpt), 'objects' );

?>

<div class="zm-default-form-container" id="default_create_form">

    <form action="javascript://" id="create_zm_quote_tracker_form" class="form-stacked">

        <div id="default_message_target"></div>

        <input type="hidden" name="security" value="<?php print wp_create_nonce( 'zm-quote-tracker-forms' );?>">

        <div class="form-wrapper">
            <input type="hidden" value="<?php print $cpt; ?>" name="post_type" />            

            <div class="row">
                <label>Title</label>
                <input type="text" name="post_title" id="post_title" class="xxlarge" />
            </div>        
            
            <div class="row">
                <label>Quote</label>
                <textarea name="content" class="xxlarge" rows="12"></textarea>
            </div>

            <div class="row">
                <label>Excerpt</label>
                <textarea name="excerpt" class="xxlarge" rows="6"></textarea>
            </div>        
                                                    
			<div class="row">
				<?php zm_base_build_options( array( 'extra_data' => 'data-allows-new-values="true"', 'extra_class' => 'chzn-select', 'taxonomy' => 'book', 'value' => 'name' ) ); ?>
				<?php zm_base_build_options( array( 'extra_data' => 'data-allows-new-values="true"', 'extra_class' => 'chzn-select', 'taxonomy' => 'movie', 'value' => 'name' ) ); ?>
				<?php zm_base_build_options( array( 'extra_data' => 'data-allows-new-values="true"', 'extra_class' => 'chzn-select', 'taxonomy' => 'song', 'value' => 'name' ) ); ?>
				<?php zm_base_build_options( array( 'extra_data' => 'data-allows-new-values="true"', 'extra_class' => 'chzn-select', 'taxonomy' => 'people', 'value' => 'name' ) ); ?>				
            </div>
			<div class="row">
                <label>Tags</label>
                <input type="text" name="zm-quote-tag" class="xxlarge" />			
			</div>            

        </div>        

        <div class="well">
            <div id="publishing-action">
                <div class="left">                    
                    <input id="save_exit_submit_bmx_race_schedule" class="button" type="submit" value="Save &amp; Close" accesskey="p" name="save_exit" data-template="<?php print plugin_dir_path( __FILE__ ); ?>archive-table.php" data-post_type="<?php print $cpt; ?>"/>            
                    <button id="save_add_submit_zm_quote_tracker" class="clean" data-template="<?php print plugin_dir_path( __FILE__ ); ?>archive-table.php" data-post_type="<?php print $cpt; ?>">Save &amp; add another</button>
                    <button id="clear" class="clean">Clear</button>
                    <button id="exit" class="clean" data-template="<?php print plugin_dir_path( __FILE__ ); ?>archive-table.php" data-post_type="<?php print $cpt; ?>">Exit</button>                    
                </div>
            </div>
        </div>
    </form>
</div>
