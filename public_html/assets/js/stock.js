$(document).ready(function() {
	function loadStockList(page) {
       

        if (typeof page != 'undefine' && page < 0)
            page = 1

        $('#stock-list').load(appUrl + 'inventory/stock?page=' + page);
    }

    $(document).on('click', '.mail-next,.mail-previous', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var page = href.replace('#', '');
      
        loadStockList(page);
    });

});