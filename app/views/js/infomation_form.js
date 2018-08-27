$(function() {
	
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
	
});