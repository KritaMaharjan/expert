$(document).ready(function() {

    $("#postal_code").autocomplete({
            source: app_url+"postal/suggestions",
            selectFirst: true
      });

    $('#postal_code').on('input', function() {
        var postal_code = $( '#postal_code' ).val();
        var _token = $( this ).find( 'input[name=_token]' ).val();
        if(postal_code)
        {
            $.ajax({
                        url: app_url+"city/suggestions/"+postal_code,
                        type: "get",
                        dataType: "json",
                        success: function(data) {
                            $( '#city' ).val(data);
                        }
                    });
        }
        else
            $( '#city' ).val("");
    });
});