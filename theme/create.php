<?php

$cpt = $_POST['post_type'];
$cpt_obj = get_post_types( array( 'name' => $cpt), 'objects' );

?>

<div class="zm-default-form-container" id="default_create_form">

    <form action="javascript://" id="create_default_form" class="form-stacked">

        <div id="default_message_target"></div>

        <input type="hidden" name="security" value="<?php print wp_create_nonce( 'tt-ajax-forms' );?>">

        <div class="form-wrapper">
            <input type="hidden" value="<?php print $cpt; ?>" name="post_type" />            

            <div class="clearfix">
                <label>Title</label>
                <input type="text" name="post_title" id="post_title" class="xxlarge" />
            </div>        
            
            <div class="clearfix">
                <label>Content</label>
                <textarea name="content" class="xxlarge" rows="12"></textarea>
            </div>

            <div class="clearfix">
                <label>Excerpt</label>
                <textarea name="excerpt" class="xxlarge" rows="6"></textarea>
            </div>        
         
                                
                <div class="clearfix">
                    <label>State</label>
                    <div class="input-prepend">
                        <span class="add-on">eq: "Maryland"</span>                
                        <input type="text" name="state" />
                    </div>
                </div>            

            <div class="row-container">
                <div class="clearfix">
                    <label>Track/Venue</label>
                    <input type="text" name="track" />            
                </div>
            
                <div class="clearfix">
                    <label>Point Scale</label>



<?php zm_base_build_options( array( 
	'extra_data' => 'data-allows-new-values="true"', 
	'extra_class' => 'chzn-select', 
	'taxonomy' => 'book', 
	'label' => '', 
	'value' => 'name' 
	) ); ?>
                    <span class="help-block">
                        <strong>Note:</strong> Use <em>Tripple</em> point scale for National events.
                    </span>
                </div>
            </div>
        </div>
        <div class="well">
            <div id="publishing-action">
                <div class="left">                    
                    <input id="save_exit_submit_bmx_race_schedule" class="button" type="submit" value="Save &amp; Close" accesskey="p" name="save_exit" data-template="<?php print plugin_dir_path( __FILE__ ); ?>archive-table.php" data-post_type="<?php print $cpt; ?>"/>            
                    <button id="save_add_submit_bmx_race_schedule" class="clean" data-template="<?php print plugin_dir_path( __FILE__ ); ?>archive-table.php" data-post_type="<?php print $cpt; ?>">Save &amp; add another</button>
                    <button id="clear" class="clean">Clear</button>
                    <button id="exit" class="clean" data-template="<?php print plugin_dir_path( __FILE__ ); ?>archive-table.php" data-post_type="<?php print $cpt; ?>">Exit</button>                    
                </div>
            </div>
        </div>
    </form>
</div>
