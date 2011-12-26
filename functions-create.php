<?php
function add_quote(){
	print_r( $_POST );	
}

function create_zm_quote_tracker( ) {

    $js_depends = array(
        'jquery', 
        'jquery-ui-core', 
        'jquery-ui-dialog', 
        'jquery-effects-core',
        'chosen'
        );

	wp_enqueue_style( 'chosen-css', plugin_dir_url( __FILE__ ) . 'library/chosen/chosen.css',             '', 'all' );
    wp_enqueue_script( 'chosen', plugin_dir_url( __FILE__ ) . 'library/chosen/chosen.jquery.js', array('jquery') );
    wp_enqueue_script( 'quote-tracker-script', plugin_dir_url( __FILE__ ) . 'theme/create.js', $js_depends );
    
    wp_enqueue_style( 'wp-jquery-ui-dialog' );

    add_action( 'wp_ajax_add_quote', 'add_quote' );
   
    add_action( 'wp_footer', function(){
        print '<div id="create_zm_quote_tracker_dialog" class="dialog-container" title="Add a new <em>Quote</em>">
        <div id="create_zm_quote_tracker_target" style="display: none;"></div>
        </div>';    
    });
    
    add_action( 'wp_footer', function(){
    	?>
    	<style type="text/css">

/*= Dialog
-------------------------------------------------------------- */
.ui-dialog { background: #fff; border: 1px solid #ccc; border-radius: 4px; box-shadow: 0 0 30px #666; float: left; }
.ui-dialog .form-container { background: none; padding: 0; }

.ui-dialog-buttonpane,
.ui-dialog .button-container { border-top: 1px solid #E3E3E3; float: left; margin: 20px 0 0 0; padding: 10px 0 10px 10px; width: 100%; }

.ui-dialog-title { color: #333; float: left; font: bold 16px/1 sans-serif; margin: 0; padding: 10px; }
.ui-dialog-title em { color: #888; }
.ui-widget-overlay { 
    background: -moz-radial-gradient(rgba(127, 127, 127, 0.5), rgba(127, 127, 127, 0.5) 35%, rgba(0, 0, 0, 0.7)); 
    background: -webkit-radial-gradient(rgba(127, 127, 127, 0.5), rgba(127, 127, 127, 0.5) 35%, rgba(0, 0, 0, 0.7)); 
    }
    
.ui-draggable .ui-dialog-titlebar { background: -moz-linear-gradient(center top , #E3E3E3, #F9F9F9) repeat scroll 0 0 transparent; border-bottom: 1px solid #E3E3E3; }
/* -------------------------------------------------------------- */</style>
    <?php });
    ?>
<a 
href="javascript:void(0);" 
id="create_zm_quote_tracker_handle" 
data-template="<?php print plugin_dir_path( __FILE__ ); ?>theme/create.php" 
data-post_type="<?php print $cpt; ?>" 
class="">Add a Quote!</a>

<?php }
add_action( 'create_quote', 'create_zm_quote_tracker', 10 );
