<?php 

class PageSectionTypeModel extends BasicModel {
    
    public function selectAllRows(){
		
    	$db = $this->MedooDb();
    	
    	$data = $db->select("m_page_section_type",'*');
		
		if($data != NULL && count($data) > 0 ){
			return $data;
		}
    	
		return NULL;
		
	}
	
	public function selectRowById($id){
		
    	$db = $this->MedooDb();
    	
    	$data = $db->select("m_page_section_type",'*',
    		[
				"m_page_section_type_id" => $id
			]
		);
		
		if($data != NULL && count($data) > 0 ){
			return $data;
		}
    	
		return NULL;
		
	}
    
}
