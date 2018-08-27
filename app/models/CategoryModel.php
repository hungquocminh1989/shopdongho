<?php 

class CategoryModel extends Model {
    
    public function __construct() {
    	
        parent::__construct('m_category');

    }
    
    public function listCategory(){
    	$result = $this->query(
    		"
    			SELECT * 
    			FROM m_category 
    			ORDER BY sort_no
    	"
    	);
		return $result;
	}
    
}
