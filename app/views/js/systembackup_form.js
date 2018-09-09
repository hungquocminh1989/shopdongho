$(function() {
    
    $(document).on('click', '.btn_delete_backup', function() {
    	var m_system_backup_id = this.value ;
    	System.message_confirm('Xóa Phiên Bản Đã Chọn ?',
    		function(){
    			var ajax = new System();
				ajax.done_func = function(html) {
		    		System.message_success('Xóa Thành Công.',function(){
		    			System.reload();
		    		});
		    	};
		    	ajax.connect("POST","main/systembackup/deletebackup",{
		            		"m_system_backup_id": m_system_backup_id  
			    });
			}
    	);
    });
    
    $(document).on('click', '.btn_create_backup', function() {
    	System.message_confirm('Tạo Bản Sao ?',
    		function(){
    			var ajax = new System();
				ajax.done_func = function(html) {
		    		System.message_success('Tạo Thành Công.',function(){
		    			System.reload();
		    		});
		    	};
		    	ajax.connect("POST","main/systembackup/createbackup",
		    		{
		    			"system_backup_name":$("#txt_BackupName").val()
		    		}
		    	);
			}
    	);
    });
	
});