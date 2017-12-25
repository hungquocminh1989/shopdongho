<?php 
namespace app\models;

class ProductModel extends BasicModel {
    
    
    public function listProduct(){
    	$result = $this->query(
    	"
    	SELECT * FROM m_product mp
    	INNER JOIN m_category mc ON mp.m_category_id = mc.m_category_id
    	WHERE mp.del_flg = 0 AND mc.del_flg = 0
    	"
    	);
		return $result;
	}
	
	public function insertProduct($arr_product){
    	$this->execute("
    		INSERT INTO m_product(m_category_id,product_name,product_no,product_price,product_info)
		    VALUES (:m_category_id,:product_name,:product_no,:product_price,:product_info);
    	",$arr_product);
    	$result = $this->query("SELECT MAX(m_product_id) AS id FROM m_product");
		if($result != NULL && count($result) > 0){
			return $result[0]['id'];
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
