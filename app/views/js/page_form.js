$(function() {
	
	$(document).on('submit', '#frm_setting_page', function(e) {
		//ajax call here
		var formData = System.get_form_data(this.id, true);
    	var ajax = new SystemUpload();
    	var ajax_update = new SystemUpload();
    	System.loading(false);	
    	
    	formData = get_data_images(formData);
    	console.log(formData);	
    	System.message_confirm('Xác Nhận Lưu ?',
    		function(){
				ajax.done_func = function(data) {
					var save = false;
					if(data!= null && data.status == 'NG'){
						System.message_confirm('Trang Chi Tiết Đã Tồn Tại. Xác Nhận Xử Lý Ghi Đè ?',
							function(){
								formData['old_id'] = data.old_id;
								ajax_update.done_func = function(data) {
									System.message_success('Lưu Trang Thành Công.',function(){
						    			System.reload();
						    		});
								}
								ajax_update.connect("POST","main/page/update",formData);
							}
						);
					}
					else{
						ajax_update.done_func = function(data) {
							System.message_success('Lưu Trang Thành Công.',function(){
				    			System.reload();
				    		});	
						}
						ajax_update.connect("POST","main/page/update",formData);
					}
		    	};
		    	ajax.connect("POST","main/page/checkexistpagetype",formData);
			}
    	);

		//stop form submission
		e.preventDefault();
	});
	
	$(document).on('click', '.btn_delete_page', function() {
    	var id = this.value ;
    	System.message_confirm('Xóa Trang Đã Chọn ?',
    		function(){
    			var ajax = new System();
				ajax.done_func = function(html) {
		    		System.message_success('Xóa Trang Thành Công.',function(){
		    			System.reload();
		    		});
		    	};
		    	ajax.connect("POST","main/page/delete",{
		            		"m_site_page_id": id  
			    });
			}
    	);
    });
    
    $(document).on('click', '.btn_edit_page', function() {
    	var ajax = new System();
    	var id = this.value;
    	ajax.done_func = function(html) {
    		System.show_dialog(html,'Cập Nhật Trang',function(){
    			//Chạy sau khi dialog đã được open
    			$('#txt_free_section_dialog').summernote({
					lang: 'vi-VN' ,
					dialogsInBody: true,
					dialogsFade: true,
					callbacks: {
						onImageUpload: function(files) {
				            summernote_uploadimage(files[0], $('#'+this.id));
				        }	
					}
				});
    			$('.selectpicker').selectpicker();
			});
    	};
    	ajax.connect("POST","main/page/edit",{
            		"m_site_page_id": id  
	    });
    });
    
    $(document).on('submit', '#frm_setting_page_dialog', function(e) {
		//ajax call here
		var formData = System.get_form_data(this.id, true);
    	var ajax = new SystemUpload();
    	var ajax_update = new SystemUpload();
    	System.loading(false);	
    	formData = get_data_images(formData);	
    	System.message_confirm('Xác Nhận Lưu ?',
    		function(){
				ajax_update.done_func = function(data) {
					System.message_success('Lưu Trang Thành Công.',function(){
		    			System.reload();
		    		});	
				}
				ajax_update.connect("POST","main/page/update",formData);
			}
    	);

		//stop form submission
		e.preventDefault();
	});
	
	$(document).on('click', '#add_section', function() {
		if($('#section_type').val() != ''){
			var ajax = new System();
	    	ajax.done_func = function(html) {
	    		$('#section_contents').append(html);
				$('.selectpicker').selectpicker();
	    	};
	    	ajax.connect("POST","main/section/add", {
	            		"section_type": $('#section_type').val()  
		    });
		}
		else{
			System.message_error('Chưa chọn loại trang.');
		}
    });
    
    $(document).on('click', '#add_section_dialog', function() {
		if($('#section_type_dialog').val() != ''){
			var ajax = new System();
	    	ajax.done_func = function(html) {
	    		$('#section_contents_dialog').append(html);
				$('.selectpicker').selectpicker();
	    	};
	    	ajax.connect("POST","main/section/add", {
	            		"section_type": $('#section_type_dialog').val()  
		    });
		}
		else{
			System.message_error('Chưa chọn loại trang.');
		}
    });
    
    function get_data_images(formData){
		//get image
    	if($('#upload_1').length > 0 && $('#upload_1')[0].files.length > 0 ){
            for (i = 0; i < $('#upload_1')[0].files.length; i++) {
                formData.append('section_image_upload[]',$('#upload_1')[0].files[i] );
            }
		}
		
		if($('#upload_2').length > 0 && $('#upload_2')[0].files.length > 0 ){
            for (i = 0; i < $('#upload_2')[0].files.length; i++) {
                formData.append('section_image_upload[]',$('#upload_2')[0].files[i] );
            }
		}
		
		if($('#upload_3').length > 0 && $('#upload_3')[0].files.length > 0 ){
            for (i = 0; i < $('#upload_3')[0].files.length; i++) {
                formData.append('section_image_upload[]',$('#upload_3')[0].files[i] );
            }
		}
		
		return formData;
	}
	
});