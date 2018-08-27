$(function() {
	
	$(document).on('submit', '#frm_setting_category,#frm_setting_category_dialog', function(e) {
		//ajax call here
		var frm_id = this.id;
		var formData = System.get_form_data(frm_id);
    	var ajax = new System();
    		
    	System.message_confirm('Xác Nhận Lưu ?',
    		function(){
				ajax.done_func = function(data) {
					System.message_success('Lưu Danh Mục Thành Công.',function(){
		    			System.reload();
		    		});
		    	};
		    	if(frm_id == 'frm_setting_category'){
					ajax.connect("POST","main/category/add",formData);
				}
				else{
					ajax.connect("POST","main/category/update",formData);
				}
		    	
			}
    	);

		//stop form submission
		e.preventDefault();
	});
	
	$(document).on('click', '.btn_edit_ctg', function() {
    	var ajax = new System();
    	var m_category_id = this.value;
    	ajax.done_func = function(html) {
    		System.show_dialog(html,'Cập Nhật Danh Mục');
    	};
    	ajax.connect("POST","main/category/edit",{
            		"m_category_id": m_category_id  
	    });
    });
    
    $(document).on('click', '.btn_delete_ctg', function() {
    	var m_category_id = this.value ;
    	System.message_confirm('Xóa Danh Mục Đã Chọn ?',
    		function(){
    			var ajax = new System();
				ajax.done_func = function(html) {
		    		System.message_success('Xóa Danh Mục Thành Công.',function(){
		    			System.reload();
		    		});
		    	};
		    	ajax.connect("POST","main/category/delete",{
		            		"m_category_id": m_category_id  
			    });
			}
    	);
    });
	
});