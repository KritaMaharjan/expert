jQuery( document ).ready( function( $ ) {
 
    $( '#block-user' ).on( 'click', function(e) {
    	e.preventDefault();
    	var confirm = confirm("Do you really want to block the sub user?"); 

    	if(confirm)
    	{
    		var guid = this.attr('guid');
	    	$.ajax({
                        url: app_url+"block/user/"+guid,
                        type: "get",
                        dataType: "json",
                        success: function(data) {
                            
                        }
                    });
			return false;
	    }
		
    } );
 
} );