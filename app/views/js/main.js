$(function() {
	
	$('.summernote').summernote({
		lang: 'vi-VN' 
	});
    
    $(document).on('click', '.editCtg', function() {
    	var ajax = new System();
    	ajax.done_func = function(html) {
    		System.show_dialog(html);
    	};
    	ajax.connect("POST","main/category/edit",{
            		"m_category_id": this.value  
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
    
    $('#editProductModel').on('show.bs.modal', function (event) {
    	
    	//Reset value control select image
    	$('#select_image_popup').val('');
    	$('#image_default_popup').val(0);
    	$('#img_review_popup').html('');

	var button = $(event.relatedTarget); // Button that triggered the modal
	//var recipient = button.data('whatever'); // Extract info from data-* attributes
	// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
	// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
	var modal = $(this)
	modal.find('[name="m_product_id"]').val(button.val());

	var category_id = $('#grid_category_id_'+button.val()).val();
	modal.find('[name="m_category_id"]').val(category_id);

	var product_name = $('#grid_product_name_'+button.val()).html();
	modal.find('[name="product_name"]').val(product_name);

	var product_no = $('#grid_product_no_'+button.val()).html();
	modal.find('[name="product_no"]').val(product_no);

	var product_price = $('#grid_product_price_'+button.val()).val();
	modal.find('[name="product_price"]').val(product_price);
	
	var product_price_sale = $('#grid_product_price_sale_'+button.val()).val();
	modal.find('[name="product_price_sale"]').val(product_price_sale);
	
	var msg_notify = $('#grid_msg_notify_'+button.val()).html();
	modal.find('[name="msg_notify"]').val(msg_notify);
	
	var msg_notify = $('#grid_flg_notify_'+button.val()).val();
	if(msg_notify == 1){
		modal.find('[name="flg_notify"]').attr('checked',true);
	}
	

	var product_info = $('#grid_product_info_'+button.val()).html();
	product_info = product_info.replace(new RegExp('<br>', 'g'), '').trim();
	modal.find('[name="product_info"]').val(product_info);

	var product_link = $('#grid_product_link_'+button.val()).html();
	modal.find('[name="product_link"]').val(product_link);
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
	document.getElementById('select_image_popup').addEventListener('change', function(){
	    handleFileSelect('img_review_popup','select_image_popup');
	}, false);
});