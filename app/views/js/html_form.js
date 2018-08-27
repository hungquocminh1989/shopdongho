$(function() {
	
	$(document).on('submit', '#frm_setting_html,#frm_setting_html_dialog', function(e) {
		//ajax call here
		var frm_id = this.id;
		var formData = System.get_form_data(frm_id);
    	var ajax = new System();
    		
    	System.message_confirm('Xác Nhận Lưu ?',
    		function(){
				ajax.done_func = function(data) {
					System.message_success('Lưu Nội Dung HTML Thành Công.',function(){
		    			System.reload();
		    		});
		    	};
		    	
		    	ajax.connect("POST","main/html/update",formData);
		    	
			}
    	);

		//stop form submission
		e.preventDefault();
	});
	
	$(document).on('click', '.btn_edit_html', function() {
    	var ajax = new System();
    	var m_html_data_id = this.value;
    	ajax.done_func = function(html) {
    		System.show_dialog(html,'Cập Nhật Nội Dung',function(){
    			//Chạy sau khi dialog đã được open
    			$('#txt_content_html_edit').summernote({
					lang: 'vi-VN' ,
					dialogsInBody: true,
					dialogsFade: true,
					callbacks: {
						onImageUpload: function(files) {
				            summernote_uploadimage(files[0], this);
				        }	
					}
				});
				//-----
    		});
    	};
    	ajax.connect("POST","main/html/edit",{
            		"m_html_data_id": m_html_data_id  
	    });
    });
    
    $(document).on('click', '.btn_delete_html', function() {
    	var m_html_data_id = this.value ;
    	System.message_confirm('Xóa HTML Đã Chọn ?',
    		function(){
    			var ajax = new System();
				ajax.done_func = function(html) {
		    		System.message_success('Xóa HTML Thành Công.',function(){
		    			System.reload();
		    		});
		    	};
		    	ajax.connect("POST","main/html/delete",{
		            		"m_html_data_id": m_html_data_id  
			    });
			}
    	);
    });
	
});