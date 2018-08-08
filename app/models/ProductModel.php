<?php 

class ProductModel extends BasicModel {
	
	public function __construct() {
    	
        parent::__construct('m_product');

    }
    
    public function delete_before_update($m_product_id){
    	
    	$sql = "
    		WITH d1 AS (
    			DELETE FROM t_image_manager
				WHERE m_product_id = $m_product_id
				RETURNING m_image_id
    		)
    		DELETE FROM m_image
			WHERE m_image_id IN (SELECT * FROM d1)
			RETURNING image_path
    	";
		
		$result = $this->query($sql);
		
		if($result != NULL && count($result) > 0){
			$arr_path = array();
			foreach($result as $key => $value){
				$arr_path[] = $value['image_path'];
			}
			
			return $arr_path;
		}
		
		return NULL;
		
	}
    
    public function update_product($arr_product, $m_product_id = NULL){
		
		$this->begin_transaction();
		$listImageDelete = NULL;
		
		//Insert m_product
		$rowProduct = $this->upsertRow($arr_product,$m_product_id,'m_product');
		
		if($rowProduct != NULL && count($rowProduct) == 1){
			
			$m_product_id = $rowProduct[0]['m_product_id'];
			
			//Insert and Copy image uploaded
			$folderRoot = "product_images/$m_product_id";
		
			$arr_images = Support_Common::copy_multi_file_uploaded('upload', $folderRoot, TRUE);
			
			if(count($arr_images) > 0){
				
				//Xóa Hình Cũ
				$listImageDelete = $this->delete_before_update($m_product_id);
				
				foreach($arr_images as $k => $image){
										
					$arr_image = array(
							'image_path' => $image
					);
					
					//Insert m_image
					$rowImg = $this->upsertRow($arr_image,NULL,'m_image');
					
					if($rowImg != NULL && count($rowImg) == 1){
						
						$m_image_id = $rowImg[0]['m_image_id'];
						
						$arr_mn = array();
						$arr_mn['m_product_id'] = $m_product_id;
						$arr_mn['m_image_id'] = $m_image_id;
						$arr_mn['default_flg'] = 0;
						
						if($k == $_POST['image_default']){
							$arr_mn['default_flg'] = 1;
						}
						
						//Insert t_image_manager
						$this->upsertRow($arr_mn,NULL,'t_image_manager');
						
					}
					
				}
				
			}
			
			$this->commit();
				
			if($listImageDelete != NULL && count($listImageDelete)>0){
				
				foreach($listImageDelete as $imagePathDelete){
					Support_File::DeleteFile(SYSTEM_ROOT_DIR.'/'.$imagePathDelete);
				}
				
			}
			
		}
		
	}
    
    public function listProduct(){
    	$result = $this->query(
    	"
    	SELECT * FROM m_product mp
    	INNER JOIN m_category mc 
    		ON mp.m_category_id = mc.m_category_id
    	ORDER BY m_product_id
    	"
    	);
		return $result;
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
    	INNER JOIN m_category mc 
    		ON mp.m_category_id = mc.m_category_id
    	INNER JOIN t_image_manager imn 
    		ON imn.m_product_id = mp.m_product_id AND imn.default_flg =1
    	LEFT JOIN m_image im 
    		ON im.m_image_id = imn.m_image_id
    	WHERE mp.m_product_id = :m_product_id
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
    	INNER JOIN m_category mc 
    		ON mp.m_category_id = mc.m_category_id
    	INNER JOIN t_image_manager imn 
    		ON imn.m_product_id = mp.m_product_id
    	LEFT JOIN m_image im 
    		ON im.m_image_id = imn.m_image_id
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
    			WHERE page_type = ".SYSTEM_META_PAGE_DETAIL."
    		) as base_link
    		
    	FROM m_product mp
    	INNER JOIN m_category mc 
    		ON mp.m_category_id = mc.m_category_id
    	INNER JOIN t_image_manager imn 
    		ON imn.m_product_id = mp.m_product_id AND imn.default_flg =1
    	LEFT JOIN m_image im 
    		ON im.m_image_id = imn.m_image_id
    	WHERE mc.category_name LIKE '$category_name'
    	ORDER BY mc.m_category_id
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
			$modelImage->deleteRowsByConditions(
				[
					'image_type' => SYSTEM_META_SECTION_PRODUCT,
					'm_product_id' => $m_product_id
				]
			);
		}
	} 
    
}
