$(function() {
	
	$('#txt_product_info').summernote({
		lang: 'vi-VN',
		dialogsInBody: true,
		dialogsFade: false,
		callbacks: {
			onImageUpload: function(files) {
	            summernote_uploadimage(files[0], $('#txt_product_info'));
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
				            summernote_uploadimage(files[0], $('#txt_product_info_edit'));
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