<?php 

class SiteSettingModel extends Model {
	
	function __construct() {
		
        parent::__construct ('m_site_setting');

    }
    
    public function delete_before_update(){
    	
    	$sql = "
	    	WITH d2 AS (
	    		WITH d1 AS (
	    			DELETE FROM m_site_setting
					RETURNING m_site_setting_id
	    		)
	    		DELETE FROM t_image_manager
				WHERE m_site_setting_id IN (SELECT * FROM d1)
				RETURNING m_image_id
	    	)
    		DELETE FROM m_image
			WHERE m_image_id IN (SELECT * FROM d2)
			RETURNING image_path
    	";
    	
		$result = $this->query($sql);
		
		if($result != NULL && count($result) > 0){
			$image_path = $result[0]['image_path'];
					
			return $image_path;
		
		}
		
		return NULL;
		
	}
	
	public function create_define($sql_param, $image_path){
		
		$this->begin_transaction();
		
		$image_path_delete = $this->delete_before_update();
			
		//Insert m_site_setting
		$rowSiteSetting = $this->upsertRow($sql_param,NULL,'m_site_setting');
		
		if($rowSiteSetting != FALSE){
			
			$m_site_setting_id = $rowSiteSetting[0]['m_site_setting_id'];
			
			
			if($image_path != NULL){
				$arr_img = array();
				$arr_img['image_path'] = $image_path;
				
				//Insert m_image
				$rowImage = $this->upsertRow($arr_img,NULL,'m_image');
				
				if($rowImage != FALSE){
					
					$m_image_id = $rowImage[0]['m_image_id'];
					
					$arr_img_mn = array();
					$arr_img_mn['m_image_id'] = $m_image_id;
					$arr_img_mn['m_site_setting_id'] = $m_site_setting_id;
					
					//Insert t_image_manager
					$rowImage = $this->upsertRow($arr_img_mn,NULL,'t_image_manager');
				
				}
				
			}
			
			$this->commit();
					
			return $image_path_delete;
			
		}
		
		return NULL;
		
	}
	
	
	
	public function get_define(){
		return $this->query("
			SELECT * 
			FROM m_site_setting ss
			LEFT JOIN t_image_manager ig 
				ON ig.m_site_setting_id = ss.m_site_setting_id
			LEFT JOIN m_image im 
				ON im.m_image_id = ig.m_image_id
		");
	}
    
}
