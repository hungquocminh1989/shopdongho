<?php 

class ImageModel extends BasicModel {
	
	/**■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
	* Các Hàm Cơ Bản Truy Xuất DB
	* ■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
	*/
	//■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
	
	public function selectRowById($m_image_id){
		
    	$db = $this->MedooDb();
    	
    	$data = $db->select("m_image",'*',
    		[
				"m_image_id" => $m_image_id
			]
		);
		
		if($data != NULL && count($data) > 0 ){
			return $data;
		}
    	
		return NULL;
		
	}
	
	public function selectRowsByMetaData($meta_type, $meta_id){
		
    	$db = $this->MedooDb();
    	
    	$data = $db->select("m_image",'*',
    		[
				"meta_type" => $meta_type,
				"meta_id" => $meta_id
			]
		);
    	
		return $data;
		
	}
	
	public function insertRow($sql_param){
    	
    	$db = $this->MedooDb();
		$db->begin_transaction();
		
		try{
			$db->insert('m_image',$sql_param);
			$lastInsertId = $db->id();
			$db->commit();
			return $lastInsertId;
			
		} catch (Exception $ex) {
			$db->rollback();
			return FALSE;
		}
    	
	}
	
	public function updateRowById($sql_param, $m_image_id){
    	
    	$db = $this->MedooDb();
		$db->begin_transaction();
		
		try{
			$db->update('m_image',$sql_param,
				[
					'm_image_id'=>$m_image_id
				]
			);
			$db->commit();
			return TRUE;
			
		} catch (Exception $ex) {
			$db->rollback();
			return FALSE;
		}
    	
	}
	
	public function updateRowsByMetaData($sql_param, $meta_type, $meta_id){
    	
    	$db = $this->MedooDb();
		$db->begin_transaction();
		
		try{
			$db->update('m_image',$sql_param,
				[
					'meta_type'=>$meta_type,
					'meta_id'=>$meta_id
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
			$db->delete("m_image",
				[
					'm_image_id' => $m_image_id
				]
			);
			$db->commit();
			return TRUE;
			
		} catch (Exception $ex) {
			$db->rollback();
			return FALSE;
		}
		
	}
	
	public function deleteRowsByMetaData($meta_type, $meta_id){
    	
    	$db = $this->MedooDb();
		$db->begin_transaction();
		
		try{
			$db->delete("m_image",
				[
					'meta_type'=>$meta_type,
					'meta_id'=>$meta_id
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
