<?php 

class ProductModel extends BasicModel {
	
	public function __construct() {
    	
        parent::__construct('m_product');

    }
    
    public function listProduct(){
    	$result = $this->query(
    	"
    	SELECT * FROM m_product mp
    	INNER JOIN m_category mc ON mp.m_category_id = mc.m_category_id
    	ORDER BY m_product_id
    	"
    	);
		return $result;
	}
	
	public function listProductDetailById($m_product_id, $product_link){
		$arr_sql = array();
		$arr_sql['m_product_id'] = $m_product_id;
		$arr_sql['product_link'] = $product_link;
		$arr_sql['meta_type'] = SYSTEM_META_SECTION_PRODUCT;
    	$result = $this->query(
    	"
    	SELECT 
    		mp.m_product_id,
    		mc.category_name,
    		mc.m_category_id,
    		mp.product_name,
    		mp.product_no,
    		mp.product_price,
    		mp.product_price_sale,
    		mp.flg_notify,
    		mp.msg_notify,
    		mp.product_info,
    		mp.product_link,
    		im.image_path 
    	FROM m_product mp
    	INNER JOIN m_category mc ON mp.m_category_id = mc.m_category_id
    	INNER JOIN m_image im ON im.meta_type = :meta_type AND im.meta_id = mp.m_product_id AND im.default_flg =1
    	WHERE mp.m_product_id = :m_product_id
    		AND mp.product_link = :product_link
    	"
    	,$arr_sql);
		return $result;
	}
	
	public function listProductImageDetailById($m_product_id){
		$arr_sql = array();
		$arr_sql['m_product_id'] = $m_product_id;
		$arr_sql['meta_type'] = SYSTEM_META_SECTION_PRODUCT;
		
    	$result = $this->query(
    	"
    	SELECT im.image_path 
    	FROM m_product mp
    	INNER JOIN m_category mc ON mp.m_category_id = mc.m_category_id
    	INNER JOIN m_image im ON im.meta_type = :meta_type AND im.meta_id = mp.m_product_id
    	WHERE mp.m_product_id = :m_product_id
    	"
    	,$arr_sql);
		return $result;
	}
	
	public function listProductImage($category_name = '%'){
    	$result = $this->query(
    	"
    	SELECT 
    		mp.m_product_id,
    		mc.category_name,
    		mc.m_category_id,
    		mp.product_name,
    		mp.product_no,
    		mp.product_price,
    		mp.product_price_sale,
    		mp.flg_notify,
    		mp.msg_notify,
    		mp.product_info,
    		mp.product_link,
    		im.image_path,
    		(
    			SELECT page_link FROM m_site_page
    			WHERE meta_page_type = ".SYSTEM_META_PAGE_DETAIL."
    		) as base_link
    		
    	FROM m_product mp
    	INNER JOIN m_category mc ON mp.m_category_id = mc.m_category_id
    	LEFT JOIN m_image im ON im.meta_id = mp.m_product_id  AND im.default_flg =1 AND im.meta_type = '".SYSTEM_META_SECTION_PRODUCT."'
    	WHERE mc.category_name LIKE '$category_name'
    	"
    	);
		return $result;
	}
	
	public function deleteProduct($m_product_id){
		$arr_sql = array();
		$arr_sql['m_product_id'] = $m_product_id;
		
		$status = $this->deleteRowById($m_product_id);
		if($status == TRUE){
			$modelImage = new ImageModel();
			$modelImage->deleteRowsByMetaData($this->getMetaType(SYSTEM_META_SECTION_PRODUCT),$m_product_id);
		}
	} 
    
}
