$(document).ready(function () {
    window.wiselinks = new Wiselinks($('#app-content'));
    $(document).off('page:loading').on('page:loading', function (event, $target, render, url) {
        //show loading
        $('body').prepend('<div class="overlay"></div><div class="loading"><i class="fa fa-spinner"></i> Loading...</div>');

    });
    $(document).off('page:always').on('page:always', function (event, xhr, settings) {
       // hide loading
       $('.overlay').remove();
       $('.loading').remove();

    });
 /*   $(document).off('page:done').on('page:done', function (event, $target, status, url, data) {
    });
    $(document).off('page:fail').on('page:fail', function (event, $target, status, url, error, code) {
    });*/
});