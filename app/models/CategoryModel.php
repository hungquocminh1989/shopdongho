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
	
	public function update_ctg($m_category_id = NULL, $category_name){
		$this->begin_transaction();
		$this->upsertRow(['category_name'=>$category_name], $m_category_id);
		$this->generateSortNo('m_category');
		$this->commit();
	}
    
}
