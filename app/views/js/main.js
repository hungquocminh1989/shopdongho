$(function() {
	
	$('.summernote').summernote({
		lang: 'vi-VN' 
	});
    
    $(document).on('click', '.edit_ctg', function() {
    	var ajax = new System();
    	ajax.done_func = function(html) {
    		System.show_dialog(html);
    	};
    	ajax.connect("POST","main/category/edit",{
            		"m_category_id": this.value  
	    });
    	
    });
    
    $(document).on('click', '.edit_product', function() {
    	var ajax = new System();
    	ajax.done_func = function(html) {
    		System.show_dialog(html,'abc',function(){
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
            		"m_product_id": this.value  
	    });
    });
    
    $(document).on('click', '#img_review .thumbnail_item', function() {
    	var index = $( "#img_review .thumbnail_item" ).index( this );
    	$('#image_default').val(index);
    });
    
    $(document).on('click', '#img_review_popup .thumbnail_item', function() {
    	var index = $( "#img_review_popup .thumbnail_item" ).index( this );
    	$('#image_default_popup').val(index);
    });

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

	document.getElementById('select_image').addEventListener('change', function(){
	    handleFileSelect('img_review','select_image');
	}, false);
	
});