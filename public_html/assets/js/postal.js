$(document).ready(function() {
// var cache = {};
//         $(".postal_code").autocomplete({
//             minLength: 0,
//             source: function(request, response) {
//                 var term = request.term;
//                 var token = '{{csrf_token()}}';
//                 if (term in cache) {
//                     response(cache[ term ]);
//                     return;
//                 }

//                 $.ajax({
//                     url: appUrl+"postal/suggestions",
//                     type: "get",
//                     dataType: "json",
//                     data: {'data': term,'_token':token},
//                     success: function(data) {
                      
//                         cache[ term ] = data;
//                         items1 = $.map(data, function(item) {

//                             return   {label: item.postcode +' , ' +item.town ,
//                                 value: item.postcode,
//                                 town :item.town ,
//                                 id: item.id}


//                         });
//                         response(items1);
//                     }
//                 });
//             },
            
//              //appendTo: '#customer-modal-data',
//             search: function(event, ui) {
               
//             },
//             response: function(event, ui) {
               
//             },
//             create: function(event, ui) {
//             },
//             open: function(event, ui) {
               
//             },
//             focus: function(event, ui) {

//             },
//             _resizeMenu: function() {
//                 this.menu.element.outerWidth(200);
//             },
//             select: function(event, ui) {
                
//                  var label = ui.item.town;
                 
//                 $('.city').val(label);
 

                

//             }
//         });


    var cache = {};
    $(".postal_code")
        // don't navigate away from the field on tab when selecting an item
        .bind("keydown", function (event) {
            if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).autocomplete("instance").menu.active) {
                event.preventDefault();
            }
        })
        .autocomplete({
            minLength: 0,
            source: function(request, response) {
              requestURL =  appUrl+"postal/suggestions";
                
              var term = request.term;
                if (term in cache) {
                    response(cache[term]);
                    return;
                }
                $.getJSON(requestURL, {term: request.term}, function (data, status, xhr) {
                   cache[ term ] = data;
                         items1 = $.map(data, function(item) {

                            return   {label: item.postcode +' , ' +item.town ,
                                value: item.postcode,
                                town :item.town ,
                                id: item.id}


                        });

                        response(items1);
                });
            },
             //appendTo: '#customer-modal-data',
            search: function(event, ui) {
               
            },
            response: function(event, ui) {
               
            },
            create: function(event, ui) {
            },
            open: function(event, ui) {
               
            },
            focus: function(event, ui) {

            },
            _resizeMenu: function() {
                this.menu.element.outerWidth(200);
            },
            select: function(event, ui) {
                
                 var label = ui.item.town;
                 
                $('.city').val(label);
 

                

            }
        });


// var cache = {};
//         $("#postalcode").autocomplete({

//             minLength: 0,
//             source: function(request, response) {
//                 var term = request.term;
//                 var token = $('#_token').val();
//                 if (term in cache) {
//                     response(cache[ term ]);
//                     return;
//                 }

//                 $.ajax({
//                     url: appUrl+"postal/suggestions",
//                     type: "get",
//                     dataType: "json",
//                     data: {'data': term,'_token':token},
//                     success: function(data) {
//                       console.log(data);
//                         cache[ term ] = data;
//                         items1 = $.map(data, function(item) {

//                             return   {label: item.postcode +' , ' +item.legal_town ,
//                                 value: item.postcode,
//                                 town :item.legal_town ,
//                                 id: item.id}


//                         });
//                         response(items1);
//                     }
//                 });
//             },
//             search: function(event, ui) {
               
//             },
//             response: function(event, ui) {
               
//             },
//             create: function(event, ui) {
//             },
//             open: function(event, ui) {
               
//             },
//             focus: function(event, ui) {

//             },
//             _resizeMenu: function() {
//                 this.menu.element.outerWidth(200);
//             },
//             select: function(event, ui) {
// console.log(ui);
//                  var label = ui.item.town;
              
//     $('#city').val(label);
 

                

//             }
//         });
    // $("#postcode").autocomplete({
    //         source: app_url+"postal/suggestions",
    //         selectFirst: true
    //   });

    // $('#postcode').on('input', function() {
    //     var postal_code = $( '#postal_code' ).val();
    //     var _token = $( this ).find( 'input[name=_token]' ).val();
    //     if(postal_code)
    //     {
    //         $.ajax({
    //                     url: app_url+"city/suggestions/"+postal_code,
    //                     type: "get",
    //                     dataType: "json",
    //                     success: function(data) {
    //                         $( '#city' ).val(data);
    //                     }
    //                 });
    //     }
    //     else
    //         $( '#city' ).val("");
    // });



});