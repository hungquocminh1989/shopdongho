<?php

class CommonController extends BasicController {
	
	public static function index()
	{
		$arr_return = array();
		$ProductModel = Flight::ProductModel();
		$arr_return['listProductNam'] = $ProductModel->listProductImage('Đồng Hồ Nam');
		$arr_return['listProductNu'] = $ProductModel->listProductImage('Đồng Hồ Nữ');
	    Flight::render(__FUNCTION__,$arr_return);
	    return;
	}
	
	public static function adminlogin()
	{
		if(self::checklogin() == TRUE){
			Flight::redirect('/main');
		}
		else{
			Flight::renderSmarty(__FUNCTION__);
		}
	    return;
	}
	
	public static function login()
	{
		if(isset($_POST['passcode'])==TRUE && md5($_POST['passcode']) == md5(SYSTEM_PASSCODE))
		{
			$_SESSION["login_token"] = md5(SYSTEM_PASSCODE);
			Flight::redirect('/main');
		}
		else{
			Flight::redirect('/admin');
		}
	    return;
	}
	
	public function checklogin(){
		if(isset($_SESSION["login_token"]) == TRUE && $_SESSION["login_token"] == md5(SYSTEM_PASSCODE)){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public static function detail($id, $product_link)
	{
		$ProductModel = Flight::ProductModel();
		$arr_return = array();
		$arr_return['productInfo'] = $ProductModel->listProductDetailById($id, $product_link);
		$arr_return['productInfoImage'] = $ProductModel->listProductImageDetailById($id);
		if($arr_return['productInfo'] == NULL){
			Flight::redirect('/');
		}
	    Flight::render(__FUNCTION__,$arr_return);
	    return;
	}

   	public static function main()
	{
		if(self::checklogin() == TRUE){
			$CategoryModel = Flight::CategoryModel();
			$ProductModel = Flight::ProductModel();
			
			$arr_return = array();
			$arr_return['listCategory'] = $CategoryModel->listCategory();
			$arr_return['listProduct'] = $ProductModel->listProduct();
		    Flight::renderSmarty(__FUNCTION__,$arr_return);
		    return;
		}
		else{
			Flight::redirect('/admin');
			return;
		}
	}
	
	public static function addcategory()
	{
		$model = Flight::CategoryModel();
		$model->insertCategory($_POST['category_name']);
		Flight::redirect('/main');
	    return;
	}
	
	public static function updatecategory()
	{
		$model = Flight::CategoryModel();
		if($_POST['m_category_id'] != ''){
			$model->updateCategory($_POST['m_category_id'], $_POST['category_name']);
		}
		
		Flight::redirect('/main');
	    return;
	}
	
	public static function deletecategory()
	{
		$model = Flight::CategoryModel();
		$model->deleteCategory($_POST['m_category_id']);
		Flight::redirect('/main');
	    return;
	}
	
	public static function updateproduct()
	{
		if($_POST['m_product_id'] != ''){
			$ProductModel = Flight::ProductModel();
			$arr_product = array();
			$arr_product['m_product_id'] = $_POST['m_product_id'];
			$arr_product['m_category_id'] = $_POST['m_category_id'];
			$arr_product['product_name'] = $_POST['product_name'];
			$arr_product['product_no'] = $_POST['product_no'];
			$arr_product['product_price'] = $_POST['product_price'];
			$arr_product['product_info'] = $_POST['product_info'];
			$arr_product['product_link'] = $_POST['product_link'];
			$m_product_id = $ProductModel->updateProduct($arr_product);
			
			if($m_product_id != -1){
				if (!is_dir('public/upload')) {
				    mkdir('public/upload', 0777, true);
				}
				
				if (!is_dir('public/upload/'.$m_product_id)) {
				    mkdir('public/upload/'.$m_product_id, 0777, true);
				}
				
				self::insertImagesUpload($m_product_id);
				
			}
		}
		
		Flight::redirect('/main');
	    return;
	}
	
	public static function addproduct()
	{
		$ProductModel = Flight::ProductModel();
		$arr_product = array();
		$arr_product['m_category_id'] = $_POST['m_category_id'];
		$arr_product['product_name'] = $_POST['product_name'];
		$arr_product['product_no'] = $_POST['product_no'];
		$arr_product['product_price'] = $_POST['product_price'];
		$arr_product['product_info'] = $_POST['product_info'];
		$arr_product['product_link'] = $_POST['product_link'];
		$m_product_id = $ProductModel->insertProduct($arr_product);
		
		if($m_product_id != -1){
			if (!is_dir('public/upload')) {
			    mkdir('public/upload', 0777, true);
			}
			
			if (!is_dir('public/upload/'.$m_product_id)) {
			    mkdir('public/upload/'.$m_product_id, 0777, true);
			}
			
			self::insertImagesUpload($m_product_id);
			
		}
		
		
		Flight::redirect('/main');
	    return;
	}
	
	public function insertImagesUpload($m_product_id){
		$arr_images = array();
		//Get file upload
		$countFile = count($_FILES['upload']['type']);
		
		if($countFile > 0&& $_FILES['upload']['type'][0] != ''){
			for($i = 0; $i < $countFile; $i++){
				$file_src = $_FILES['upload']['tmp_name'][$i];
				$filename = uniqid().'_'.$_FILES['upload']['name'][$i];
				$file_dest = SYSTEM_PUBLIC_UPLOAD.'/'.$m_product_id.'/'.$filename;
				copy($file_src,$file_dest);
				$arr_images[] = 'public/upload/'.$m_product_id.'/'.$filename;
			}
		}
		
		$ImageModel = Flight::ImageModel();
		if(count($arr_images) > 0){
			
			//Xóa Hình Cũ
			$listImage = $ImageModel->listImage($m_product_id);
			if($listImage != NULL && count($listImage)>0){
				foreach($listImage as $imageDelete){
					if(file_exists(SYSTEM_ROOT_DIR.'/'.$imageDelete['image_path'])==TRUE){
						unlink(SYSTEM_ROOT_DIR.'/'.$imageDelete['image_path']);
					}
				}
				$ImageModel->deleteImage($m_product_id);
			}
			
			
			foreach($arr_images as $k => $image){
				if($k == 0){
					$ImageModel->insertImage($m_product_id, $image,1);
				}
				else{
					$ImageModel->insertImage($m_product_id, $image);
				}
			}
		}
	}
	
	public static function deleteproduct()
	{
		$model = Flight::ProductModel();
		$model->deleteProduct($_POST['m_product_id']);
		Flight::redirect('/main');
	    return;
	}
    
}
