$(document).on('click', '.add-client', function(e) {
    e.preventDefault();
    $('.client-box').show('slow');
    $('#client-select').val(0);
    $('.client-info').hide();
});

$(document).on('change', '#client-select', function(e) {
    var val = this.value;
    if(val != 0) {
        var $this = $(this);
        var client_id = $this.val();
        var doing = false;

        if (doing == false) {
            doing = true;
            $('.client-box').hide();
            $('.client-info').show('slow').html('<i class="fa fa-spinner fa-spin"></i> Processing...');
            $.ajax({
                url: appUrl + '/system/client/details/' + client_id,
                type: 'GET',
                dataType: 'json'
            })
                .done(function (response) {
                    if (response.status === 1) {
                        var clientInfo = response.data.template;
                        $('.client-info').html(clientInfo);
                    } else {
                        alert('Something went wrong!');
                        $('.client-info').html('');
                    }
                })
                .fail(function () {
                    alert('something went wrong');
                    $('.client-info').html('');
                })
                .always(function () {
                    doing = false;
                });
        }
    }
});

function DetailsTemplate(details) {
    var template = '<strong>' + details.preferred_name +
        '</strong><br>' + details.street_name + ' ' + details.street_number +
        '<br>' + details.town + '<br>Phone: ' + details.telephone + '<br>Email: ' + details.email;
    return template;
}