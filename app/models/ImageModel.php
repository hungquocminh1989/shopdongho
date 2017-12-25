<?php 
namespace app\models;

class ImageModel extends BasicModel {
    
    
    public function listImage(){
    	
	}
	
	public function insertImage($m_product_id, $image_path ,$isDefault = 0){
		$arr_sql = array();
		$arr_sql['m_product_id'] = $m_product_id;
		$arr_sql['image_path'] = $image_path;
		$arr_sql['default_flg'] = $isDefault;
    	$result = $this->execute("
    		INSERT INTO m_image(m_product_id, image_path, default_flg)
		    VALUES (:m_product_id, :image_path, :default_flg);
    	",$arr_sql);
	}
	
	public function deleteImage($m_category_id){
		
	}
    
}
