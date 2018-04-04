<?php 

class MetaModel extends BasicModel {
	
	public function __construct() {
    	
        parent::__construct('m_metadata');

    }
    
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
    
}
