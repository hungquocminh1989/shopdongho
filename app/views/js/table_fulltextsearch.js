$(function() {
	
	$.each($('.grid_table_result'), function( index, child ) {
		
		var child_data = $(child);
		
		//Table fulltextsearch
		child_data.find(".txt_fulltextsearch").keyup(function(){
			var input, filter, table, tr, td, i;
			input = child_data.find(".txt_fulltextsearch");
			filter = input.val().toUpperCase();
			table = child_data.find(".table_fulltextsearch");
			tr = table.find("tr");
			for (i = 0; i < tr.length; i++) {
				td = tr[i].getElementsByTagName("td");
				if (td) {
					var rowValid = false;
					for (c = 0; c < td.length; c++) {//Bỏ column class=col_sort_exclude
						if(td[c].className.indexOf('col_sort_exclude') == -1){
							if (td[c].innerHTML.toUpperCase().indexOf(filter) > -1) {
								rowValid = true;
								//console.log(td[c].innerHTML);
							}
						}
					}
					if(rowValid == true){
						tr[i].style.display = "";
					}
					else{
						tr[i].style.display = "none";
					}
				}       
			}
			child_data.find(".table_fulltextsearch thead tr").show();
		});
		
		//Table drag sort
		child_data.find(".table_drag_sort tbody").sortable( {
			//placeholder: "ui-state-highlight",
			axis: 'y',
			stop: function(event, ui){
				alert('Override to call ajax update sort...');
				ui.item.children('td').effect('highlight', {}, 1000);
			},
			update: function( event, ui ) {
				$(this).children().each(function(index) {
						$(this).find('.col_order_no span').html(index + 1);
						$(this).find('.col_order_no input[name="arr_sort_no[]"]').val(index + 1);
				});
			}
		});
		
		//Column không có class=col_drag_sort thì không thể drag sort được
		child_data.find(".table_drag_sort tbody td").not('.col_drag_sort').mousedown(function(event){
		    event.stopImmediatePropagation();
		});
		
	});
	
});