<?php 

class SiteContentModel extends BasicModel {
	
	/**■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
	* Các Hàm Cơ Bản Truy Xuất DB
	* ■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
	*/
	//■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
	
	public function selectAllRows(){
		
    	$db = $this->MedooDb();
    	
    	$data = $db->select("m_site_content",'*');
		
		if($data != NULL && count($data) > 0 ){
			return $data;
		}
    	
		return NULL;
		
	}
	
	public function selectRowById($id){
		
    	$db = $this->MedooDb();
    	
    	$data = $db->select("m_site_content",'*',
    		[
				"m_site_content_id" => $id
			]
		);
		
		if($data != NULL && count($data) > 0 ){
			return $data;
		}
    	
		return NULL;
		
	}
	
	public function insertRow($sql_param){
    	
    	$db = $this->MedooDb();
		$db->begin_transaction();
		
		try{
			$db->insert('m_site_content',$sql_param);
			$lastInsertId = $db->id();
			$db->commit();
			return $lastInsertId;
			
		} catch (Exception $ex) {
			$db->rollback();
			return FALSE;
		}
    	
	}
	
	public function updateRowById($sql_param, $m_category_id){
    	
    	$db = $this->MedooDb();
		$db->begin_transaction();
		
		try{
			$db->update('m_site_content',$sql_param,
				[
					'm_site_content_id'=>$m_category_id
				]
			);
			$db->commit();
			return TRUE;
			
		} catch (Exception $ex) {
			$db->rollback();
			return FALSE;
		}
    	
	}
	
	public function deleteRowById($m_image_id){
		
		$db = $this->MedooDb();
		$db->begin_transaction();
		
		try{
			$db->delete("m_site_content",
				[
					'm_site_content_id' => $m_image_id
				]
			);
			$db->commit();
			return TRUE;
			
		} catch (Exception $ex) {
			$db->rollback();
			return FALSE;
		}
		
	}
	
	//■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■ 
    
}
