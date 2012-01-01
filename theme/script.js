jQuery(document).ready(function( $ ){
	console.log('loaded');
	    
    $( '#filter_task_form input[type=checkbox]' ).on( 'change', function(){    	
	    build_filters( _form_selector='#filter_task_form' );
	});	
});