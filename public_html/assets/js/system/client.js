$(function () {

    var clientDatatable = $("#table-client").dataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": appUrl + '/system/client/data',
            "type": "POST"
        },

        
        "columnDefs": [{
            "orderable": false,
            "targets": 3,
            "render": function (data, type, row) {
                return showActionbtn(row);
            }
        }],
        "columns": [
            {"data": "id"},
            {"data": "domain"},
            {"data": "email"},
           
        ],

        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            
            $('td:eq(1)', nRow).html('<a href="'+appUrl+'/system/client/'+aData.id+'">' +
               aData.domain + '</a>');
            return nRow;
        },

    });


    





function showActionbtn(row) {
    
     if(row.status == 1) 
    {
         return '<div class="box-tools">' +
   
    '<a class="block" href="javascript:;" domain="'+row.domain+'" token="" link ="'+appUrl+'/system/block" code="'+row.guid+'">Block</a>' +
    '</div>';

    }
    else
    {
        return '<div class="box-tools">' +
   
    '<a class="block" href="javascript:;" domain="'+row.domain+'" token="" link ="'+appUrl+'/system/block" code="'+row.guid+'">Unblock</a>' + 
    '</div>';
 
    }
   


       
       

}




$(document).on( 'click','.block', function() {
        $this = $(this);
       
        var domain = $this.attr('domain');
         var code = $this.attr('code');
         var url = $this.attr('link');
        $.ajax({
            url: url,
            dataType: 'json',
            data: {'domain':domain,'code':code},
            type: 'get',
            success: function(response) {
              
                if (response.status == 'true')
                {
                   
                    $this.text(response.block);
                    
                }
                
            }
        });


    });


})


