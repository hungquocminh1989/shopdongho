<?php 

class CategoryModel extends BasicModel {
    
    public function __construct() {
    	
        parent::__construct('m_category');

    }
    
    public function listCategory(){
    	$result = $this->query("SELECT * FROM m_category ");
		return $result;
	}
    
    public function getDataCtg($m_category_id){
		return $this->query(
			"
				SELECT * FROM m_category mc
				INNER JOIN m_product mp ON mp.m_category_id = mc.m_category_id
				INNER JOIN m_image mi ON mi.meta_id = mp.m_product_id AND mi.meta_type = :meta_type
				WHERE mc.m_category_id = :m_category_id
			"
			,
			[
				'm_category_id' => $m_category_id,
				'meta_type' => $this->getMetaKey(SYSTEM_META_PRODUCT)
			]
		);
	}
    
}
