<?php

class ProductController extends BasicController {
	
	public static function action_addproduct()
	{
		$ProductModel = new ProductModel();
		$arr_product = array();
		$arr_product['m_category_id'] = $_POST['m_category_id'];
		$arr_product['product_name'] = $_POST['product_name'];
		$arr_product['product_no'] = $_POST['product_no'];
		$arr_product['product_price'] = $_POST['product_price'];
		if(isset($_POST['product_price_sale']) && $_POST['product_price_sale'] != ''){
			$arr_product['product_price_sale'] = $_POST['product_price_sale'];
		}
		$arr_product['flg_notify'] = 0;
		if(isset($_POST['flg_notify']) == TRUE){
			$arr_product['flg_notify'] = $_POST['flg_notify'];
		}
		$arr_product['msg_notify'] = $_POST['msg_notify'];
		$arr_product['product_info'] = $_POST['product_info'];
		$arr_product['product_link'] = $_POST['product_link'];
		$m_product_id = $ProductModel->insertRow($arr_product);
		
		if($m_product_id !== FALSE){
			self::insertImagesUpload($m_product_id);
		}
		
		
		Flight::redirect('/main');
		return FALSE;#Stop Route
	}
	
	public static function action_deleteproduct()
	{
		$model = new ProductModel();
		$model->deleteProduct($_POST['m_product_id']);
		Flight::json(array('status' => 'OK'));
	}
	
	public static function action_editproduct()
	{
		$model = new ProductModel();
		$CategoryModel = new CategoryModel();
		$arr_return = array();
		$arr_return = $model->selectRowById($_POST['m_product_id'])[0];
		$arr_return['listCategory'] = $CategoryModel->listCategory();
		Flight::renderSmarty('admin/dialog/product_edit.html',$arr_return);
		return FALSE;//Stop Route
	}
	
	public static function action_updateproduct()
	{
		if($_POST['m_product_id'] != ''){
			$ProductModel = new ProductModel();
			$arr_product = array();
			$m_product_id = $_POST['m_product_id'];
			$arr_product['m_category_id'] = $_POST['m_category_id'];
			$arr_product['product_name'] = $_POST['product_name'];
			$arr_product['product_no'] = $_POST['product_no'];
			$arr_product['product_price'] = $_POST['product_price'];
			if(isset($_POST['product_price_sale']) && $_POST['product_price_sale'] != ''){
				$arr_product['product_price_sale'] = $_POST['product_price_sale'];
			}
			$arr_product['flg_notify'] = 0;
			if(isset($_POST['flg_notify']) == TRUE){
				$arr_product['flg_notify'] = $_POST['flg_notify'];
			}
			$arr_product['msg_notify'] = $_POST['msg_notify'];
			$arr_product['product_info'] = $_POST['product_info'];
			$arr_product['product_link'] = $_POST['product_link'];
			$ProductModel->updateRowById($arr_product, $m_product_id);
			
			if($m_product_id != -1){
				self::insertImagesUpload($m_product_id);
			}
		}
		
		Flight::redirect('/main');
		return FALSE;#Stop Route
	}
	
	public function insertImagesUpload($m_product_id){
		
		$folderRoot = "product_images/$m_product_id";
		
		$arr_images = parent::copy_multi_file_uploaded('upload', $folderRoot, TRUE);
		
		$ImageModel = new ImageModel();
		if(count($arr_images) > 0){
			
			$image_type = SYSTEM_META_SECTION_PRODUCT;
			
			//Xóa Hình Cũ
			$listImage = $ImageModel->selectRowsByConditions(
				[
					'image_type' => $image_type,
					'm_product_id' => $m_product_id
				]
			);
			if($listImage != NULL && count($listImage)>0){
				foreach($listImage as $imageDelete){
					Support_File::DeleteFile(SYSTEM_ROOT_DIR.'/'.$imageDelete['image_path']);
				}
				$ImageModel->deleteRowsByConditions(
					[
						'image_type' => $image_type,
						'm_product_id' => $m_product_id
					]
				);
				
			}
			
			foreach($arr_images as $k => $image){
				if($k == $_POST['image_default']){
					$ImageModel->insertRow(
						[
							'image_type' => $image_type,
							'm_product_id' => $m_product_id,
							'image_path' => $image,
							'default_flg' => 1
						]					
					);
				}
				else{
					$ImageModel->insertRow(
						[
							'image_type' => $image_type,
							'm_product_id' => $m_product_id,
							'image_path' => $image,
							'default_flg' => 0
						]					
					);
				}
			}
			
		}
	}
    
}
