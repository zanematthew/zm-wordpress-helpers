jQuery(document).ready(function( $ ){
    /**
     * Check if the inPlaceEdit plugin is loaded    
     */
    if ( jQuery().inPlaceEdit ) {

        if ( typeof _post_id !== "undefined" && $(".post-title").length ) {
            $(".post-title").inPlaceEdit({ 
                    postId: _post_id, 
                    field: "title" 
            });

            $(".post-content").inPlaceEdit({ 
                    postId: _post_id, 
                    field: "content" 
            });

            $(".post-excerpt").inPlaceEdit({ 
                    postId: _post_id, 
                    field: "excerpt" 
            });            
        } else {
        	console.log( 'Please put the post_id in globa scope for me.' );
        }
    } else {
    	console.log('inplace edit not loaded');
    }

    /**
     * When you submit your post to be updated this function is ran.
     */       
    $( '.update_content' ).live( 'submit', function(){
        $.ajax({
            data: "action=zm_inplace_edit_update_post&ID=" + $(this).attr('data-post_id') + "&"+ $(this).serialize(), 
            success: function( msg ){
                location.reload( true );                           
                //$('.ui-widget-overlay').fadeOut();                
            }
        });    
    }); // End 'update'
    
    if ( jQuery().chosen )
        $("select").chosen();         

    $('#default_utility_udpate_form').live('submit', function(){        
        $.ajax({
            data: "action=zm_inplace_edit_update_utility&" + $( this ).serialize(),
            success: function( msg ) {
                console.log( msg );
            }
        });
    });        

});