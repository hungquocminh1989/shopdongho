<?php 
namespace app\models;

class ProductModel extends BasicModel {
    
    
    public function listProduct(){
    	
	}
	
	public function insertProduct($product_name){
		$arr_sql = array();
		$arr_sql['product_name'] = $product_name;
    	$this->execute("
    		INSERT INTO m_product(product_name)
		    VALUES (:product_name);
    	",$arr_sql);
    	$result = $this->query("SELECT MAX(m_product_id) AS id FROM m_product");
		if($result != NULL && count($result) > 0){
			return $result[0]['id'];
		}
		return -1;
	}
	
	public function deleteProduct($m_category_id){
		
	}
    
}
