<?php 
class BasicModel extends Model {
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
