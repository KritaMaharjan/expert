$(function () {

    function loadTaskList(type,page) {

        if (type != 0 && type != 1)
            type = 0;
       
        if (typeof page != 'undefine' && page < 0)
            page = 1;

        $('#task-list').load(appUrl + 'tasks?type=' + type + '&page=' + page);
    }

    $(document).on('click', '.mail-next,.mail-previous', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var page = href.replace('#', '');
        loadTaskList(0,page);

        $('input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });
    });


    function loadCompletedList(type,page) {
        if (type != 0 && type != 1)
            type = 1;
       
        if (typeof page != 'undefine' && page < 0)
            page = 1;

        $('#completed-list').load(appUrl + 'tasks?type=' + type + '&page=' + page);
    }

    $(document).on('click', '.mail-next1,.mail-previous1', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var page = href.replace('#', '');
        loadCompletedList(1,page);
    });


$(document).on('submit', '#task-form', function (e) {
        e.preventDefault();
        var form = $(this);
        var formAction = form.attr('action');
        var formData = form.serialize();
        var requestType = form.find('.task-submit').val();

        form.find('.task-submit').val('loading...');
        form.find('.task-submit').attr('disabled', 'disabled');

        form.find('.has-error').removeClass('has-error');
        form.find('label.error').remove();
        form.find('.callout').remove();

        $.ajax({
            url: formAction,
            type: 'POST',
            dataType: 'json',
            data: formData
        })
            .done(function (response) {
                if (response.status === 1) {
                    $('#fb-modal').modal('hide');
                    var ul = $('.box-body ul');
                    if (requestType == 'Add') {
                        $('.mainContainer .main-box-solid').before(notify('success', 'Task added Successfully'));
                        $('.upcoming-tasks').prepend(response.data.template);
                    }
                    else {
                        $('.mainContainer .main-box-solid').before(notify('success', 'Task updated Successfully'));
                        ul.find('#' + response.data.id).html(response.data.template);
                    }
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);
                }
                else {

                    if ("errors" in response.data) {

                        $.each(response.data.errors, function (id, error) {
                            $('.modal-body #' + id).parent().addClass('has-error')
                            $('.modal-body #' + id).after('<label class="error error-' + id + '">' + error[0] + '<label>');
                        })
                    }

                    if ("error" in response.data) {
                        form.prepend(notify('danger', response.data.error));
                    }

                }
            })
            .fail(function () {
                alert('something went wrong');
            })
            .always(function () {
                form.find('.task-submit').removeAttr('disabled');
                form.find('.task-submit').val(requestType);
                $('input[type="checkbox"]').iCheck({
                    checkboxClass: 'icheckbox_flat-blue',
                    radioClass: 'iradio_flat-blue'
                });
            });
    });
    return false;
});


$(document).on('click', '.btn-delete-task', function (e) {
    e.preventDefault();
    var $this = $(this);
    var parentLi = $this.parent().parent();
    var id = $this.attr('data-id');
    var doing = false;

    if (!confirm('Are you sure, you want delete? This action will delete data permanently and can\'t be undo')) {
        return false;
    }

    if (id != '' && doing == false) {
        doing = true;
        parentLi.hide('slow');

        $.ajax({
            url: appUrl + 'tasks/' + id + '/delete',
            type: 'GET',
            dataType: 'json'
        })
            .done(function (response) {
                if (response.status === 1) {
                    $('.mainContainer .main-box-solid').before(notify('success', response.data.message));
                    parentLi.remove();
                } else {
                    $('.mainContainer .main-box-solid').before(notify('error', response.data.message));
                    parentLi.show('fast');
                }
                setTimeout(function () {
                    $('.callout').remove()
                }, 2500);
            })
            .fail(function () {
                parentLi.show('fast');
                alert('something went wrong');
            })
            .always(function () {
                doing = false;
            });
    }

});

$('#todo-check').on('ifChanged', function(event){
    alert(event.type + ' callback');
});

$(document).on('change', '.box-body ul input:checkbox', function (e) {
    $(this).parent().parent().find('.text').toggleClass('strike');
});

function notify(type, text) {
    return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
}

function showActionbtn(row) {
    return '<div class="box-tools">' +
    '<a href="#" title="Edit" data-original-title="Edit" class="btn btn-box-tool" data-toggle="modal" data-url="' + row.edit_url + '" data-target="#fb-modal">' +
    '<i class="fa fa-edit"></i>' +
    '</a>' +
    '<button class="btn btn-box-tool btn-delete-tasks" data-toggle="tooltip" data-id="' + row.id + '" data-original-title="Remove"><i class="fa fa-times"></i></button>' +
    '</div>';

}

/* Mark complete merge these two later */
$(document).on('ifChecked', '.upcoming-tasks .icheck', function (e) {
//$('.icheck').on('ifChecked', function(event){
    //alert(event.type + ' callback');
    var parentLi = $(this).parent().parent();
    parentLi.find('.text').toggleClass('strike');

    var html = parentLi.clone();
    var up = $('.upcomingtaskpage').text();
    //alert(up);
    var total = up.split("of");
    var res1 = up.split("-");
    var totaling = total[1]-1;
    var totaling1 = total[1] +1;
    var onpage = res1[1].split("of");
    var on = onpage[0]-1;
    var on1 = onpage[0] +1;
    $('.upcomingtaskpage').text(res1[0]+'-'+on +'of'+ totaling);
    $('.completedtaskpage').text(res1[0]+'-'+on1 +'of'+ totaling1);
    parentLi.hide('slow', function(){
        parentLi.remove();

    });
    var completedUl = $('.completed-tasks');
    completedUl.find('.no-results').remove();
    //completedUl.prepend(html);
    var taskId = parentLi.attr('id');

    $.ajax({
     url: appUrl + 'tasks/'+taskId+'/complete',
     type: 'GET',
     dataType: 'json'
     }).done(function (response) {
         completedUl.prepend(response.data.template);
         $('.icheck').iCheck({
             checkboxClass: 'icheckbox_flat-blue',
             radioClass: 'iradio_flat-blue',
             tap: true
         });
     });
});

/* Undo complete */
$(document).on('ifUnchecked', '.completed-tasks .icheck', function (e) {
    var parentLi = $(this).parent().parent();
    parentLi.find('.text').toggleClass('strike');

    var html = parentLi.clone();

    var up = $('.completedtaskpage').text();
    //alert(up);
    var total = up.split("of");
    var res1 = up.split("-");
    var totaling = total[1]-1;
    var totaling1 = total[1] +1;
    var onpage = res1[1].split("of");
    var on = onpage[0]-1;
    var on1 = onpage[0] +1;
    $('.completedtaskpage').text(res1[0]+'-'+on +'of'+ totaling);
    $('.upcomingtaskpage').text(res1[0]+'-'+on1 +'of'+ totaling1);
    parentLi.hide('slow', function(){
        parentLi.remove();
    });

    var todoUl = $('.upcoming-tasks');
    todoUl.find('.no-results').remove();
    var taskId = parentLi.attr('id');

    $.ajax({
        url: appUrl + 'tasks/'+taskId+'/redo',
        type: 'GET',
        dataType: 'json'
    }).done(function (response) {
        todoUl.prepend(response.data.template);
        $('.icheck').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue',
            tap: true
        });
    });
});
