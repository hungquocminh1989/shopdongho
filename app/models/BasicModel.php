<?php 
class BasicModel extends Model {
	
    /**■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
	* Các Hàm Cơ Bản Truy Xuất DB
	* ■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
	*/
	//■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
	
	public function selectRowById($id){
		
    	$db = $this->MedooDb();
    	
    	$data = $db->select($this->table_name,'*',
    		[
				$this->pk_id => $id
			]
		);
		
		if($data != NULL && count($data) > 0 ){
			return $data;
		}
    	
		return NULL;
		
	}
	
	public function selectAllRows(){
		
    	$db = $this->MedooDb();
    	
    	$data = $db->select($this->table_name,'*');
		
		if($data != NULL && count($data) > 0 ){
			return $data;
		}
    	
		return NULL;
		
	}
	
	public function selectRowByConditions($param = array()){
		
    	$db = $this->MedooDb();
    	
    	$data = $db->select($this->table_name,'*',$param);
		
		if($data != NULL && count($data) > 0 ){
			return $data;
		}
    	
		return NULL;
		
	}
	
	public function selectRowsByMetaData($meta_type, $meta_id){
		
    	$db = $this->MedooDb();
    	
    	$data = $db->select($this->table_name,'*',
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
			$db->insert($this->table_name,$sql_param);
			$lastInsertId = $db->id();
			$db->commit();
			return $lastInsertId;
			
		} catch (Exception $ex) {
			$db->rollback();
			return FALSE;
		}
    	
	}
	
	public function updateRowById($sql_param, $id){
    	
    	$db = $this->MedooDb();
		$db->begin_transaction();
		
		try{
			$db->update($this->table_name,$sql_param,
				[
					$this->pk_id => $id
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
			$db->update($this->table_name,$sql_param,
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
	
	public function deleteRowById($id){
		
		$db = $this->MedooDb();
		$db->begin_transaction();
		
		try{
			$db->delete($this->table_name,
				[
					$this->pk_id => $id
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
			$db->delete($this->table_name,
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
	
	public function getMetaType($meta_name){
		$result = $this->query("SELECT meta_type FROM m_metadata WHERE meta_name = '$meta_name' LIMIT 1");
		if($result != NULL && count($result) > 0){
			return $result[0]['meta_type'];
		}
		else{
			return NULL;
		}
	}
	
	public function getMetaKey($meta_name){
		$result = $this->query("SELECT meta_key FROM m_metadata WHERE meta_name = '$meta_name' LIMIT 1");
		if($result != NULL && count($result) > 0){
			return $result[0]['meta_key'];
		}
		else{
			return NULL;
		}
	}
}
