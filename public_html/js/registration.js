jQuery( document ).ready( function( $ ) {
 
    $( '#register' ).on( 'submit', function(e) {
    	e.preventDefault();
    	$('#submit-btn').attr('disabled', true);
    	$('#submit-btn').html('Loading...');

    	$.post(
            $( this ).prop( 'action' ),
            {
                "_token": $( this ).find( 'input[name=_token]' ).val(),
                "company": $( '#company' ).val(),
                "email": $( '#email' ).val()
            },
            function( data ) {
            	if(data.fail) {
		      	$('#submit-btn').attr('disabled', false);
		      	$('#submit-btn').html('<strong>Sign up »</strong>');
			      $.each(data.errors, function( index, value ) {
			        var errorDiv = '#'+index;
			        $(errorDiv).addClass('error');
			        $('.'+index+'-error').html(value);
			        //$(errorDiv).empty().append(value);
			      });          
			    } 

			    if(data.success) {
			        window.location.replace(data.redirect_url);
			    } //success
            },
            'json'
        );
		
		return false;
    } );

    //domain suggestion
    $('#company').on('input', function() { //You can bind the 'input' event to the textbox. This would fire every time the input changes, so when you paste something (even with right click), delete and type anything.
    	var company = $( '#company' ).val();
    	if(company)
    	{
	    	$.ajax({url: app_url+"domain/suggestion/"+company, success: function(result){
		        $('.domain-suggestion').html(result);
		    }});
	    }
	    else
	    {
	    	$('.domain-suggestion').html('name');
	    }

	});
 
} );