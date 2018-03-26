<?php 

class ProductModel extends BasicModel {
    
    
    public function listProduct(){
    	$result = $this->query(
    	"
    	SELECT * FROM m_product mp
    	INNER JOIN m_category mc ON mp.m_category_id = mc.m_category_id
    	WHERE mp.del_flg = 0 AND mc.del_flg = 0
    	ORDER BY m_product_id
    	"
    	);
		return $result;
	}
	
	public function listProductById($m_product_id){
		$db = $this->MedooDb();
		$result = $db->select('m_product','*',
			[
				'del_flg' => 0,
				'm_product_id' => $m_product_id,
			]
		);
		if($result != NULL && count($result) > 0 )
		{
			return $result[0];
		}
		else{
			return NULL;
		}
	}
	
	public function listProductDetailById($m_product_id, $product_link){
		$arr_sql = array();
		$arr_sql['m_product_id'] = $m_product_id;
		$arr_sql['product_link'] = $product_link;
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
    	INNER JOIN m_image im ON im.m_product_id = mp.m_product_id AND im.default_flg =1
    	WHERE mp.del_flg = 0 AND mc.del_flg = 0 AND im.del_flg = 0 
    		AND mp.m_product_id = :m_product_id
    		AND mp.product_link = :product_link
    	"
    	,$arr_sql);
		return $result;
	}
	
	public function listProductImageDetailById($m_product_id){
		$arr_sql = array();
		$arr_sql['m_product_id'] = $m_product_id;
		
    	$result = $this->query(
    	"
    	SELECT im.image_path 
    	FROM m_product mp
    	INNER JOIN m_category mc ON mp.m_category_id = mc.m_category_id
    	INNER JOIN m_image im ON im.m_product_id = mp.m_product_id
    	WHERE mp.del_flg = 0 AND mc.del_flg = 0 AND im.del_flg = 0 AND mp.m_product_id = :m_product_id
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
    		im.image_path
    		
    	FROM m_product mp
    	INNER JOIN m_category mc ON mp.m_category_id = mc.m_category_id
    	LEFT JOIN m_image im ON im.m_product_id = mp.m_product_id  AND im.default_flg =1 AND im.del_flg = 0
    	WHERE mp.del_flg = 0 AND mc.del_flg = 0
    	AND mc.category_name LIKE '$category_name'
    	"
    	);
		return $result;
	}
	
	public function insertProduct($arr_product){
    	$this->execute("
    		INSERT INTO m_product(
    			m_category_id,
    			product_name,
    			product_no,
    			product_price,
    			product_price_sale,
		    	flg_notify,
		    	msg_notify,
    			product_info,
    			product_link
    		)
		    VALUES (
		    	:m_category_id,
		    	:product_name,
		    	:product_no,
		    	:product_price,
		    	:product_price_sale,
		    	:flg_notify,
		    	:msg_notify,
		    	:product_info,
		    	:product_link
		    );
    	",$arr_product);
    	$result = $this->query("SELECT MAX(m_product_id) AS id FROM m_product");
		if($result != NULL && count($result) > 0){
			return $result[0]['id'];
		}
		return -1;
	}
	
	public function updateProduct($arr_product){
    	$this->execute("
		    UPDATE m_product
    		SET m_category_id = :m_category_id,
	    		product_name = :product_name,
	    		product_no = :product_no,
	    		product_price = :product_price,
	    		product_price_sale = :product_price_sale,
		    	flg_notify = :flg_notify,
		    	msg_notify = :msg_notify,
	    		product_info = :product_info,
	    		product_link = :product_link
		    WHERE  m_product_id = :m_product_id;
    	",$arr_product);
    	
		if($arr_product['m_product_id']!=''){
			return $arr_product['m_product_id'];
		}
		return -1;
	}
	
	public function deleteProduct($m_product_id){
		$arr_sql = array();
		$arr_sql['m_product_id'] = $m_product_id;
    	$this->execute("
    		UPDATE m_product
    		SET del_flg = 1
		    WHERE  m_product_id = :m_product_id;
    	",$arr_sql);
    	$this->execute("
    		UPDATE m_image
    		SET del_flg = 1
		    WHERE  m_product_id = :m_product_id;
    	",$arr_sql);
	}
    
}
