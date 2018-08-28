$(function() {
	
	$("#frm_list_header table tbody").sortable( {
		stop: function(event, ui){
			selected_row_sort = ui;
			ajax_sort.connect("POST","main/header/dragsort",
				$('#frm_list_header').serializeArray()
			);
		}
	});
	
	$(document).on('submit', '#frm_setting_header,#frm_setting_header_dialog', function(e) {
		//ajax call here
		var frm_id = this.id;
		var formData = System.get_form_data(frm_id);
    	var ajax = new System();	
    		
    	System.message_confirm('Xác Nhận Lưu ?',
    		function(){
				ajax.done_func = function(data) {
					System.message_success('Lưu Header Thành Công.',function(){
		    			System.reload();
		    		});
		    	};
		    	ajax.connect("POST","main/header/update",formData);
		    	
			}
    	);

		//stop form submission
		e.preventDefault();
	});
	
	$(document).on('click', '.btn_delete_header', function() {
    	var id = this.value ;
    	System.message_confirm('Xóa Menu Đã Chọn ?',
    		function(){
    			var ajax = new System();
				ajax.done_func = function(html) {
		    		System.message_success('Xóa Menu Thành Công.',function(){
		    			System.reload();
		    		});
		    	};
		    	ajax.connect("POST","main/header/delete",{
		            		"m_site_header_id": id  
			    });
			}
    	);
    });
    
    $(document).on('click', '.btn_edit_header', function() {
    	var ajax = new System();
    	var id = this.value;
    	ajax.done_func = function(html) {
    		System.show_dialog(html,'Cập Nhật Header',function(){
    			$('.selectpicker').selectpicker();
    		});
    	};
    	ajax.connect("POST","main/header/edit",{
            		"m_site_header_id": id  
	    });
    });
	
});