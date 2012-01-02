jQuery(document).ready(function( $ ){
	    
    $( '#filter_task_form input[type=checkbox]' ).on( 'change', function(){    	

    	// Slide down and animte our box
    	$('#filter_control_target').slideDown();
	    $( '#zm_ajax_the_loop').animate({
	    	paddingTop: '42px'
	    });

	    // assign some stuff
	    _this = $(this);
	    console.log(_this);
	    term = $( this ).attr( 'data-name' );
	    taxonomy = $( this ).attr( 'data-taxonomy' );	    
		html = '<div class="filter-control-item" data-name="' + term + '"><strong>' + taxonomy + ' </strong>' + term + '</div>';	  	    

		if ( $(_this.attr('data-name') ).is(":visible") ) {
			console.log('yes');
		} else {
			console.log('no');
		}

	    $('#filter_control_target div').each(function(){	    		    		    	
		    if ( _this.attr( 'data-name' ) == $( $(this) ).attr('data-name') ) {
				$( $( this ) ).fadeOut();			
			} 
	    });		    	    	

	    $('#filter_control_target').append( html );	    	   		    

		build_filters( _filter_selector='#filter_task_form' );	    
	});	

	$('#filter_control_target').on('click', 'div', function(){
		
		_this = $(this);

		$( _this ).toggle('fast', function(){
			$( '#zm_ajax_the_loop').animate({
		    	paddingTop: '0'
		    });
		    
		    // Uncheck our matching checkbox
		    $('#filter_task_form input[type="checkbox"]').each(function(){		    			    
		    	if ( _this.attr( 'data-name' ) == $( $(this) ).attr('data-name') ) {
					$( $( this ) ).attr( "checked", false );
				} 
		    });		    

			build_filters( _filter_selector='#filter_control_target' );
		});
	});

	/**
	 * Toggle our advanced search
	 *
	 * We prevent the default action of clicking the href
	 * assign instance of this. Toggle class for current 
	 * item in navigation show or hide the search sidebar.
	 */
	$('#search_navigation').on('click', 'a', function( event ){		
		event.preventDefault();

		_this = $(this);		
		
		$('#search_navigation a').each(function(){
			parentID = '#' + $(this).parent().attr('id');
			$( parentID + ' a' ).removeClass('current');			
			$( _this ).toggleClass('current', true);
		});			

		$('.search-by').toggle('fast');
	});
});