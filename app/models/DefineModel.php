<?php 

class DefineModel extends Model {
	
	public function __construct() {
    	
        parent::__construct('m_define');

    }
    
    public function selectSectionType(){
    	
    	$data = $this->select("m_define",'*',
    		[
    			'define_key' => [1,4,6,9,10]
    		]
    	);
		
		if($data != NULL && count($data) > 0 ){
			return $data;
		}
    	
		return NULL;
		
	}
	
	public function selectPageType(){
    	
    	$data = $this->select("m_define",'*',
    		[
    			'define_key' => [7,8]
    		]
    	);
		
		if($data != NULL && count($data) > 0 ){
			return $data;
		}
    	
		return NULL;
		
	}
    
}
