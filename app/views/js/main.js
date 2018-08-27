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
	
});