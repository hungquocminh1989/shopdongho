<?php 

class CategoryModel extends BasicModel {
    
    public function __construct() {
    	
        parent::__construct('m_category');

    }
    
    public function listCategory(){
    	$result = $this->query("SELECT * FROM m_category ");
		return $result;
	}
    
}
