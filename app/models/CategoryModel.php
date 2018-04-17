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
    	$meta_type_product = $this->getMetaType(SYSTEM_META_PRODUCT);
    	$meta_type_category = $this->getMetaType(SYSTEM_META_CATEGORY);
		return $this->query(
			"
				SELECT * FROM m_site_page_detail spd
				INNER JOIN m_category mc ON mc.m_category_id = spd.meta_id AND spd.meta_type = :meta_type_category
				INNER JOIN m_product mp ON mp.m_category_id = mc.m_category_id
				INNER JOIN m_image mi ON mi.meta_id = mp.m_product_id AND mi.meta_type = :meta_type_product
				WHERE mc.m_category_id = :m_category_id
			"
			,
			[
				'm_category_id' => $m_category_id,
				'meta_type_product' => $meta_type_product,
				'meta_type_category' => $meta_type_category
			]
		);
	}
    
}
