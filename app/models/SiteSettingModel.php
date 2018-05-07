<?php 

class SiteSettingModel extends BasicModel {
	
	function __construct() {
        parent::__construct ('m_site_setting');

    }
	
	public function create_define($sql_param){
		
		$db = $this->MedooDb();
		$db->begin_transaction();
		
		try{
			$data = $db->query("
				SELECT * FROM m_site_setting LIMIT 1;
			")->fetchAll();
			
			$lastInsertId = NULL;
			
			if($data != NULL && count($data) > 0 ){
				$db->update('m_site_setting',$sql_param,['m_site_setting_id'=>$data[0]['m_site_setting_id']]);
				$lastInsertId = $data[0]['m_site_setting_id'];
			}
			else{
				$db->insert('m_site_setting',$sql_param);
				$lastInsertId = $db->id();
			}
			$db->commit();
			return $lastInsertId;
			
			
		} catch (Exception $ex) {
			$db->rollback();
			return FALSE;
		}
	}
	
	
	
	public function get_define(){
		return $this->query("
			SELECT * FROM m_site_setting ss
			LEFT JOIN m_image im ON im.m_site_setting_id = ss.m_site_setting_id AND im.image_type = ".SYSTEM_META_SITE_SETTING."
		");
	}
    
}
