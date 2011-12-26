jQuery(document).ready(function( $ ){
	console.log('created loaded');

    /** 
     * Setup our dialog for create a ticket 
     */
    dialogs = {
        "create_zm_quote_tracker_dialog":  { 
            autoOpen: false,        
            minWidth: 600,
            maxWidth: 600,
            minHeight: 630,            
            modal: true        
        }
    };  
    
    window.temp_load = function( params ) {
        params.action = "loadTemplate";        
        console.log( 'show loading icon in target' );
        console.log( params );
        $.ajax({
            data: params,
            success: function( msg ){                
                $( params.target_div ).fadeIn().html( msg );
                if(typeof params.callback === "function") {
                    params.callback();
                }
            },
            error: function( xhr ){                
                console.log( 'XHR Error: ' + xhr );
            }
        });
    }

    /**
     * Default ajax setup
     */
    $.ajaxSetup({
        type: "POST",
        url: ajaxurl
    });    

    $( '#create_zm_quote_tracker_dialog' ).each(function() {        
        $(this).dialog( dialogs[this.id] );
    });
	   
	$('#create_zm_quote_tracker_handle').on('click', function(){				
		$('#create_zm_quote_tracker_dialog').dialog('open');
        temp_load({
            "target_div": "#create_zm_quote_tracker_target",
            "template": $( this ).attr("data-template"),
            "post_type": $( this ).attr("data-post_type")
        });		
	});

 $(".chzn-select").chosen(); 
 $(".chzn-select-deselect").chosen({
	 allow_single_deselect:true
});

	$('body').ajaxSuccess(function(){		
		if ( jQuery().chosen ) {
			$(".chzn-select").chosen(); 
 			$(".chzn-select-deselect").chosen({
				allow_single_deselect: false
			});
		} else {
			console.log( 'Chosen not loaded' );
		}
	}); // End 'ajaxSuccess'	

});