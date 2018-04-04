<?php 

class MetaModel extends BasicModel {
	
	/**■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
	* Các Hàm Cơ Bản Truy Xuất DB
	* ■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
	*/
	//■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
	
	public function selectSectionType(){
		
    	$db = $this->MedooDb();
    	
    	$data = $db->select("m_metadata",'*',
    		[
    			'meta_type' => [1,4,6]
    		]
    	);
		
		if($data != NULL && count($data) > 0 ){
			return $data;
		}
    	
		return NULL;
		
	}
	
	
	public function selectRowById($id){
		
    	$db = $this->MedooDb();
    	
    	$data = $db->select("m_metadata",'*',
    		[
				"m_metadata_id" => $id
			]
		);
		
		if($data != NULL && count($data) > 0 ){
			return $data;
		}
    	
		return NULL;
		
	}
    
}
