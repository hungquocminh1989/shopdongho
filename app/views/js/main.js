$(function() {
	
	$('.summernote').summernote({
		lang: 'vi-VN' 
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
    			$('.summernote1').summernote({
					lang: 'vi-VN' 
				});
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