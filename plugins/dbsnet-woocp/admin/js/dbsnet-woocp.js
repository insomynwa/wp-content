jQuery(document).ready( function ($) {

	$('body').on('focus','.custom-woocp-datepicker', function(){
		$(this).datepicker({
			dateFormat: 'yy-mm-dd'
		});
	});

	 var i=1;
     $("#add_row").click(function(){
     	i=parseInt($("#add_row").children("span").attr("id"));
      $('#addr'+i).html("<td><input type='hidden' value='' name='batch_id[]'>"+ (i+1)+"</td>"+
      	"<td><input name='batch_start_date[]' type='text' placeholder='Start Date' class='custom-woocp-datepicker'  /> </td>" +
      	"<td><input  name='batch_end_date[]' type='text' placeholder='End Date'  class='custom-woocp-datepicker'></td>" + 
      	"<td><input  name='batch_stock[]' type='number' placeholder='Stock'  class=''></td>" +
      	"<td><input  name='batch_price[]' type='text' placeholder='Price'  class=''></td>" +
      	"<td><a id='' class='delete-batch-row pull-right btn btn-default'><span id=''></span>Delete Row</a></td>");

      $('#tab_logic').append('<tr class="batch_row_table" id="addr'+(i+1)+'"></tr>');
      i++; 
      $("#add_row").children("span").attr("id",i);
 	 	});

     $('body').on('click', "a.delete-batch-row", function(){
     	//parseInt($("#delete_row").children("span").attr("id",(i-1)));
     	var clicker = $(this);
     	var owner = $(this).closest("tr");
     	var str = $(this).closest("tr").attr("id");
     	var num = str.length;
     	var deleted_addr = parseInt(str.substring(4,num)); // 4 = addrXX
      owner.remove();
     	console.log(clicker);
   		$("input#inpt"+deleted_addr).attr("value" , clicker.children("span").attr("id"));//inpt0->100,99
   		$("input#inpt"+deleted_addr).attr("id",'deleted_id'+clicker.children("span").attr("id"));//delete_id100,99->100,99
     	
       	$( "tr.batch_row_table" ).each(function( index ) {

  		  	var current_str_addr = $(this).attr("id"); //addr0
  	     	var current_len_str = current_str_addr.length;//5
  	     	var current_addr = current_str_addr.substring(4,current_len_str);//0
  	     	
  	     	if(current_addr > deleted_addr){

  	     		var new_addr = current_addr-1;
  	     		//console.log(clicker.children("span").attr("id"));
  	     		// owner.remove();
  	     		$(this).attr("id", "addr"+new_addr);//addr0
  	     		$("input#inpt"+current_addr).attr("id",'inpt'+new_addr);//inpt0
  	     		$(this).children(":first").html(new_addr+1);
  	     	}
  		});

      
     	var before_val = $("#add_row").children("span").attr("id") - 1;
     	$("#add_row").children("span").attr("id", before_val);
     	$(this).closest("tr").html("");

     });

     $("#delete_row").click(function(){
     	i=parseInt($("#delete_row").children("span").attr("id"));
    	 if(i>1){
			 $("#addr"+(i-1)).html('');
			 i=parseInt($("#delete_row").children("span").attr("id",(i-1)));
			 i--;
		 }
	 });

});

