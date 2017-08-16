jQuery(document).ready( function ($) {

    $('body').on('focus','.custom-woocp-datepicker', function(){
        $(this).datepicker({
        dateFormat: 'yy-mm-dd'
        });
    });


    $("body").on("click",".update-batch-btn", function(event){
        event.preventDefault();
        $("#batch-add-progress").show();
        var batch_id = $(this).attr('data-batch-id'),
        start_date = $("input#start-date"+batch_id).val(),
        end_date = $("input#end-date"+batch_id).val(),
        stock = $("input#stock"+batch_id).val(),
        price = $("input#price"+batch_id).val(),
        product_id = $(this).attr('data-product-id');

        var data = {
            'action': 'AjaxUpdateBatch',
            'batch': batch_id,
            'start_date': start_date,
            'end_date': end_date,
            'stock': stock,
            'price': price,
            'product_title' : $("input#product-title").val(),
            'product': product_id
        };

        $.post(
            dbsnet_ajax.ajax_url,
            data,
            function(response){
            //console.log("Hallo");
                $("#batch-add-progress").hide();
                var result = jQuery.parseJSON( response );
                if(result.status){
                    console.log("SUCCESS update batch");
                }else{
                    alert(result.message);
                }
            }
        );
    });

    var i=1;
    $("#add_row").click(function(event){
        event.preventDefault();
        i=parseInt($("#add_row").children("span").attr("id"));
        $("#batch-add-progress").show();

        var data = {
            'action': 'AjaxAddBatch',
            'product': $(this).attr('data-product-id'),
            'product_title' : $("input#product-title").val(),
            'index_batch' : i
        };
        
        $.post(
            dbsnet_ajax.ajax_url,
            data,
            function(response){
                $("#batch-add-progress").hide();
                var result = jQuery.parseJSON( response );
                //console.log(result);
                if( result.status ) {

                    $('#addr'+i).html("<td><input type='hidden' value='"+ result.data.batch.id+"' name='batch_id[]'>"+ (i)+"</td>"+
                    "<td><input id='start-date"+ result.data.batch.id+"' name='start-date"+ result.data.batch.id+"' type='text' placeholder='Start Date' class='custom-woocp-datepicker'  /> </td>" +
                    "<td><input id='end-date"+ result.data.batch.id+"'  name='end-date"+ result.data.batch.id+"' type='text' placeholder='End Date' class='custom-woocp-datepicker'></td>" + 
                    "<td><input id='stock"+ result.data.batch.id+"'  name='stock"+ result.data.batch.id+"' type='number' placeholder='Stock' class=''></td>" +
                    "<td><input id='price"+ result.data.batch.id+"'  name='price"+ result.data.batch.id+"' type='text' placeholder='Price' class=''></td>" +
                    "<td>"+
                    "<button id='' data-product-id='"+ result.data.product.id+"' data-batch-id='"+ result.data.batch.id+"' class='update-batch-btn button-primary'>Update</button>"+
                    "</td>"+
                    "<td>"+
                    "<a id='' data-batch-id='"+ result.data.batch.id+"' href='#' class='delete-batch-row btn btn-default'><span id=''></span>Delete</a>"+
                    "</td>");

                    $('#tab_logic').append('<tr class="batch_row_table" id="addr'+(i+1)+'"></tr>');
                    i++;

                    $("#add_row").children("span").attr("id",i);
                }
                else{
                    alert(result.message);
                }
            }
        );
    });

    $('body').on('click', "a.delete-batch-row", function(e){
        e.preventDefault();
        var clicker = $(this);
        var owner = $(this).closest("tr");
        var str = $(this).closest("tr").attr("id");
        $("#batch-add-progress").show();
        var batch_id = $(this).attr('data-batch-id');

        var data = {
        'action': 'AjaxDeleteBatch',
        'batch': batch_id
        };
        $.post(
            dbsnet_ajax.ajax_url,
            data,
            function(response){
                //console.log("Hallo");
                $("#batch-add-progress").hide();
                var result = jQuery.parseJSON( response );
                if(result.status){
                    console.log("SUCCESS delete batch");
                    var num = str.length;
                    var deleted_addr = parseInt(str.substring(4,num)); // 4 = addrXX
                    owner.remove();
                    //console.log(clicker);
                    $("input#inpt"+deleted_addr).attr("value" , clicker.children("span").attr("id"));//inpt0->100,99
                    $("input#inpt"+deleted_addr).attr("id",'deleted_id'+clicker.children("span").attr("id"));//delete_id100,99->100,99

                    $( "tr.batch_row_table" ).each(function( index ) {
                        var current_str_addr = $(this).attr("id"); //addr0
                        var current_len_str = current_str_addr.length;//5
                        var current_addr = current_str_addr.substring(4,current_len_str);//0

                        if(current_addr > deleted_addr){

                            var new_addr = current_addr-1;
                            $(this).attr("id", "addr"+new_addr);//addr0
                            $("input#inpt"+current_addr).attr("id",'inpt'+new_addr);//inpt0
                            $(this).children(":first").html(new_addr+1);
                        }
                    });


                    var before_val = $("#add_row").children("span").attr("id") - 1;
                    $("#add_row").children("span").attr("id", before_val);
                    $(this).closest("tr").html("");
                }
                else{
                    alert(result.message);
                }
            }
        );
    });

    $("#delete_row").click(function(){
        i=parseInt($("#delete_row").children("span").attr("id"));
        if(i>1){
            $("#addr"+(i-1)).html('');
            i=parseInt($("#delete_row").children("span").attr("id",(i-1)));
            i--;
        }
    });

    $( "#batch-add-progress" ).progressbar({ value: false }).hide();

});
