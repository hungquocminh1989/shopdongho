<?php 

class SiteSettingModel extends BasicModel {
	
	function __construct() {
		
        parent::__construct ('m_site_setting');

    }
    
    public function delete_before_update(){
		
		$sql = "
			DELETE FROM m_site_setting
			RETURNING m_site_setting_id
			;
		";
		$result = $this->query($sql);
		
		if($result != NULL && count($result) > 0){
			$m_site_setting_id = $result[0]['m_site_setting_id'];
			$sql = "
				DELETE FROM t_image_manager
				WHERE m_site_setting_id = $m_site_setting_id
				RETURNING m_image_id
				;
			";
			$result1 = $this->query($sql);
			
			if($result1 != NULL && count($result1) > 0){
				$m_image_id = $result1[0]['m_image_id'];
				$sql = "
					DELETE FROM m_image
					WHERE m_image_id = $m_image_id
					RETURNING image_path
					;
				";
				$result2 = $this->query($sql);
				if($result2 != NULL && count($result2) > 0){
					$image_path = $result2[0]['image_path'];
					
					return $image_path;
				}
			}
		
		}
		
		return NULL;
		
	}
	
	public function create_define($sql_param, $image_path){
		
		$this->begin_transaction();
		
		$image_path_delete = $this->delete_before_update();
			
		//Insert m_site_setting
		$rowSiteSetting = $this->upsertRow($sql_param,NULL,'m_site_setting');
		
		if($rowSiteSetting != NULL && count($rowSiteSetting) == 1){
			
			$m_site_setting_id = $rowSiteSetting[0]['m_site_setting_id'];
			
			
			if($image_path != NULL){
				$arr_img = array();
				$arr_img['image_path'] = $image_path;
				
				//Insert m_image
				$rowImage = $this->upsertRow($arr_img,NULL,'m_image');
				
				if($rowImage != NULL && count($rowImage) == 1){
					
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
