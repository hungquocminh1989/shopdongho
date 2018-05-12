$(function() {
	
	$('#txt_product_info,#txt_content_html').summernote({
		lang: 'vi-VN',
		dialogsInBody: true,
		dialogsFade: false,
		callbacks: {
			onImageUpload: function(files) {
	            summernote_uploadimage(files[0], $('#'+this.id));
	        }	
		}
	});
	
	function summernote_uploadimage(file, control) {
		var ajax = new SystemUpload();
		data = new FormData();
        data.append("file_upload", file);
    	
    	ajax.done_func = function(data) {
    		control.summernote('editor.insertImage', data['url']);
    	};
    	ajax.connect("POST","main/image/upload", data);
    }
	
	$('.selectpicker').selectpicker();
	
	$(document).on('click', '#add_section', function() {
		if($('#section_type').val() != ''){
			var ajax = new System();
	    	ajax.done_func = function(html) {
	    		$('#section_contents').append(html);
	    		$('#txt_free_section').summernote({
					lang: 'vi-VN',
					dialogsInBody: true,
					dialogsFade: false,
					callbacks: {
						onImageUpload: function(files) {
				            summernote_uploadimage(files[0], $('#txt_free_section'));
				        }	
					}
				});
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
	    		$('#txt_free_section').summernote({
					lang: 'vi-VN',
					dialogsInBody: true,
					dialogsFade: false,
					callbacks: {
						onImageUpload: function(files) {
				            summernote_uploadimage(files[0], $('#txt_free_section'));
				        }	
					}
				});
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
    
    $(document).on('submit', '#frm_setting_page_dialog', function(e) {
		//ajax call here
		var formData = System.get_form_data(this.id);
    	var ajax = new System();
    	var ajax_update = new System();
    	System.loading(false);		
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
    
    $(document).on('submit', '#frm_setting_page', function(e) {
		//ajax call here
		var formData = System.get_form_data(this.id);
    	var ajax = new System();
    	var ajax_update = new System();
    	System.loading(false);		
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
	
	$(document).on('submit', '#frm_setting_site', function(e) {
		//ajax call here
		var frm_id = this.id;
		var formData = System.get_form_data(frm_id, true);
		formData.append('upload_logo_site', $('#select_logo_site')[0].files[0]);
		
    	var ajax = new SystemUpload();
    		
    	System.message_confirm('Xác Nhận Lưu ?',
    		function(){
				ajax.done_func = function(data) {
					System.message_success('Lưu Thong Tin Thành Công.',function(){
		    			System.reload();
		    		});
		    	};
		    	ajax.connect("POST","main/define/add",formData);
		    	
			}
    	);

		//stop form submission
		e.preventDefault();
	});
	
	
	
	$(document).on('submit', '#frm_setting_product,#frm_setting_product_dialog', function(e) {
		//ajax call here
		var frm_id = this.id;
		var formData = System.get_form_data(frm_id, true);
		if(frm_id == 'frm_setting_product'){
			if( $('#select_image')[0].files.length > 0 ){
	            for (i = 0; i < $('#select_image')[0].files.length; i++) {
	                formData.append('upload[]',$('#select_image')[0].files[i] );
	            }
			}
		}
		else{
			if( $('#select_image_popup')[0].files.length > 0 ){
	            for (i = 0; i < $('#select_image_popup')[0].files.length; i++) {
	                formData.append('upload[]',$('#select_image_popup')[0].files[i] );
	            }
			}
		}
		
		
    	var ajax = new SystemUpload();
    		
    	System.message_confirm('Xác Nhận Lưu ?',
    		function(){
				ajax.done_func = function(data) {
					System.message_success('Lưu San Pham Thành Công.',function(){
		    			System.reload();
		    		});
		    	};
		    	
		    	if(frm_id == 'frm_setting_product'){
					ajax.connect("POST","main/product/add",formData);
				}
				else{
					ajax.connect("POST","main/product/update",formData);
				}
		    	
			}
    	);

		//stop form submission
		e.preventDefault();
	});
	
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
    
    $(document).on('click', '.btn_edit_page', function() {
    	var ajax = new System();
    	var id = this.value;
    	ajax.done_func = function(html) {
    		System.show_dialog(html,'Cập Nhật Trang',function(){
    			$('.selectpicker').selectpicker();
			});
    	};
    	ajax.connect("POST","main/page/edit",{
            		"m_site_page_id": id  
	    });
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
    
    $(document).on('click', '.btn_edit_product', function() {
    	var ajax = new System();
    	var m_product_id = this.value;
    	ajax.done_func = function(html) {
    		System.show_dialog(html,'Cập Nhật Sản Phẩm',function(){
    			//Chạy sau khi dialog đã được open
    			$('#txt_product_info_edit').summernote({
					lang: 'vi-VN' ,
					dialogsInBody: true,
					dialogsFade: true,
					callbacks: {
						onImageUpload: function(files) {
				            summernote_uploadimage(files[0], this);
				        }	
					}
				});
				$('.selectpicker').selectpicker();
    			document.getElementById('select_image_popup').addEventListener('change', function(){
				    handleFileSelect('img_review_popup','select_image_popup');
				}, false);
				//-----
    		});
    	};
    	ajax.connect("POST","main/product/edit",{
            		"m_product_id": m_product_id  
	    });
    });
    
    $(document).on('click', '.btn_delete_product', function() {
    	var m_product_id = this.value ;
    	System.message_confirm('Xóa Sản Phẩm Đã Chọn ?',
    		function(){
    			var ajax = new System();
				ajax.done_func = function(html) {
		    		System.message_success('Xóa Sản Phẩm Thành Công.',function(){
		    			System.reload();
		    		});
		    	};
		    	ajax.connect("POST","main/product/delete",{
		            		"m_product_id": m_product_id  
			    });
			}
    	);
    });
    
    $(document).on('click', '#img_review .thumbnail_item', function() {
    	var index = $( "#img_review .thumbnail_item" ).index( this );
    	$('#image_default').val(index);
    });
    
    $(document).on('click', '#img_review_popup .thumbnail_item', function() {
    	var index = $( "#img_review_popup .thumbnail_item" ).index( this );
    	$('#image_default_popup').val(index);
    });

	document.getElementById('select_image').addEventListener('change', function(){
	    handleFileSelect('img_review','select_image');
	}, false);
	
	function handleFileSelect(idReview,tagSelect) {
		$('#'+idReview).html('');
		
	   	//Check File API support
	    if (window.File && window.FileList && window.FileReader) {

	        var files = document.getElementById(tagSelect).files; //FileList object
	        var output = document.getElementById(idReview);

	        for (var i = 0; i < files.length; i++) {
	            var file = files[i];
	            //Only pics
	            if (!file.type.match('image')) continue;

	            addEventLoadImage(file, i, output);
	            
	        }
	    } else {
	        console.log("Your browser does not support File API");
	    }
	}

	function addEventLoadImage(file, index, output){
		var picReader = new FileReader();
	    picReader.addEventListener("load", function (event) {
	        var picFile = event.target;
	        var div = document.createElement("div");
	        div.className = 'thumbnail_item';
	        div.setAttribute('tabindex',index);
	        div.innerHTML = "<img class='thumbnail' src='" + picFile.result + "'/>";
	        output.insertBefore(div, null);
	    });
	    
	    //Read the image
	    picReader.readAsDataURL(file);
	}
	
});