$(function() {
	
	$("#frm_list_product table tbody").sortable( {
		stop: function(event, ui){
			selected_row_sort = ui;
			ajax_sort.connect("POST","main/product/dragsort",
				$('#frm_list_product').serializeArray()
			);
		}
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
		    	
		    	ajax.connect("POST","main/product/update",formData);
		    	
			}
    	);

		//stop form submission
		e.preventDefault();
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