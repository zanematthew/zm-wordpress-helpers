/**
 * Small functions to load: comments, the_loop, entry utlity via ajax 
 */
 jQuery( document ).ready(function( $ ){
    
    function close_post_container(){
        $('.zm-ajax-post-container').fadeOut();
    }

    /**
     * Default ajax setup
     */    
    if ( typeof( ajaxurl ) != "undefined" ) {
        $.ajaxSetup({
            type: "POST",
            url: ajaxurl
        });
    } else {
        console.log( 'make sure ajaxurl is defiend!' );
    }
    
$(document).keydown(function(e) {
    // ESCAPE key pressed
    if (e.keyCode == 27) {
        close_post_container();
    }
});    
    $('.zm-ajax-post-container .close').live('click', function( event ){
        event.preventDefault();
        close_post_container();
    });

    // Load post via ajax when user clicks on a title from the loop
    $('#zm_ajax_the_loop .post-title').on( 'click', function( event ){        
        event.preventDefault();
        var _this = $( this );
        
        // Hide any already visible
        $('.zm-ajax-post-show').fadeOut();
        
        data = {            
            post_id: $( this ).attr('data-post_id'),
            action: "zm_ajax_load_post"
        };

        $.ajax({            
            data: data,
            success: function( msg ){                                
                
                $( _this ).after( msg );
                $('.zm-ajax-post-container').addClass( 'zm-ajax-post-show' );
                //$( '#default_message_target' ).fadeIn().html( msg ).delay(1000);
            }
        });
    });

    $( window ).load(function(){
        
        /** @todo load [task] archive: needs to be part of class for dialog */    
        if ( $('.sample').length ) {

            template = $( '.sample' ).attr('data-template');            
            post_type = $( '.sample' ).attr('data-post_type');

            if ( post_type == undefined || template == undefined )                
                console.log( 'no post type, and/or tempalte: please use data-post_type/template="[your cpt]"');                            

            data = { 
                action: "loadTemplate",
                post_type: post_type,
                post_status: "publish",
                template: template
            };

           $.ajax({
                data: data,
                success: function( msg ){

                    var match = true;

                    $('#tt_main_target').fadeIn().html( msg );
                    filterRows();
                } // End 'suckit' 
            });
            return false;
        } // End 'if'

        /**
         * If we're on a single task page load our entry utility.         
         * @todo define: "entry utility"
         */
        if ( $('#task_entry_utility_handle').length ) {
            temp_load({
                "target_div": "#task_entry_utility_target",
                "template": $( '#task_entry_utility_handle' ).attr( 'data-template' ),
                "post_id": $( '#task_entry_utility_handle' ).attr( 'data-post_id' ),
                "post_type": $( '#task_entry_utility_handle' ).attr( 'data-post_type' )
            });
        } // End 'check for entry utility'

        if ( !$( '.comments-container' ).length ) {
            
            $( '#task_comment_target .tt_loading').show();

            temp_load({
                "target_div": "#task_comment_target",
                "template": $( '#task_comment_handle' ).attr( 'data-template' ),
                "post_id": $( '#task_comment_handle' ).attr( 'data-post_id' )
            });
        }

    }); // End 'window.load'    
}); // End 'document'    