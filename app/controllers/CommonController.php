<?php

class CommonController extends BasicController {
	
	public static function action_index()
	{
		$arr_return = array();
		$CategoryModel = new CategoryModel();
		$ProductModel = new ProductModel();
		$DefineModel = new DefineModel();
		$arr_return['listCategory'] = $CategoryModel->listCategory();
		$arr_return['listProduct'] = $ProductModel->listProductImage();
		$arr_return['listDefine'] = $DefineModel->get_define();
	    Flight::renderSmarty('index.html',$arr_return);
	}
	
	public static function action_admin()
	{
		if(self::checklogin() == TRUE){
			Flight::redirect('/main');
		}
		else{
			Flight::renderSmarty('adminlogin.html');
		}
	}
	
	public static function action_login()
	{
		if(isset($_POST['passcode'])==TRUE && md5($_POST['passcode']) == SYSTEM_PASSCODE)
		{
			$_SESSION["login_token"] = md5(SYSTEM_PASSCODE);
			Flight::redirect('/main');
		}
		else{
			Flight::redirect('/admin');
		}
	}
	
	public function checklogin(){
		if(isset($_SESSION["login_token"]) == TRUE && $_SESSION["login_token"] == md5(SYSTEM_PASSCODE)){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public static function action_detail($id, $product_link)
	{
		$CategoryModel = new CategoryModel();
		$ProductModel = new ProductModel();
		$arr_return = array();
		$arr_return['listCategory'] = $CategoryModel->listCategory();
		$arr_return['productInfo'] = $ProductModel->listProductDetailById($id, $product_link);
		$arr_return['productInfoImage'] = $ProductModel->listProductImageDetailById($id);
		if($arr_return['productInfo'] == NULL){
			Flight::redirect('/');
		}
	    Flight::renderSmarty('detail.html',$arr_return);
	}

   	public static function action_main()
	{
		if(self::checklogin() == TRUE){
			$CategoryModel = new CategoryModel();
			$ProductModel = new ProductModel();
			$DefineModel = new DefineModel();
			
			$arr_return = array();
			$arr_return['listCategory'] = $CategoryModel->listCategory();
			$arr_return['listProduct'] = $ProductModel->listProductImage();
			$arr_return['listDefine'] = $DefineModel->get_define();
			$arr_return['javascript_src'] = Flight::javascript_obfuscator('js/main.js',$arr_return);
		    Flight::renderSmarty('main.html',$arr_return);
		}
		else{
			Flight::redirect('/admin');
		}
	}
	
	public function copy_file_uploaded($name, $folderRoot, $compress = FALSE){
		
		$countFile = count($_FILES[$name]['type']);
		if($countFile > 0 && $_FILES[$name]['type'][0] != ''){
			$file_src = $_FILES[$name]['tmp_name'];
			$filename = uniqid().'_'.$_FILES[$name]['name'];
			$folder_dest = SYSTEM_PUBLIC_UPLOAD.'/'.$folderRoot;
			$file_dest = $folder_dest.'/'.$filename;
			
			Support_File::CopyFile($file_src,$file_dest);
			
			//Nén hình
			if($compress == TRUE){
				Support_Image::imageCompress($file_dest,$file_dest);
			}
			return 'public/upload/'.$folderRoot.'/'.$filename;
		}
		return NULL;
	}
	
	public static function action_add_define()
	{
		$model = new DefineModel();
		$arrPost = Flight::request()->data->getData();
		$arrPost['path_logo'] = self::copy_file_uploaded('upload_logo_site', 'site_define');
		$param = Support_Array::filter($arrPost,array('site_name','phone','path_logo'));
		$model->create_define($param);
		Flight::redirect('/main');
	}
	
	public static function action_addcategory()
	{
		$model = new CategoryModel();
		$model->insertCategory($_POST['category_name']);
		Flight::redirect('/main');
	}
	
	public static function action_updatecategory()
	{
		$model = new CategoryModel();
		if($_POST['m_category_id'] != ''){
			$model->updateCategory($_POST['m_category_id'], $_POST['category_name']);
		}
		
		Flight::redirect('/main');
	}
	
	public static function action_deletecategory()
	{
		$model = new CategoryModel();
		$model->deleteCategory($_POST['m_category_id']);
		Flight::redirect('/main');
	}
	
	public static function action_updateproduct()
	{
		if($_POST['m_product_id'] != ''){
			$ProductModel = new ProductModel();
			$arr_product = array();
			$arr_product['m_product_id'] = $_POST['m_product_id'];
			$arr_product['m_category_id'] = $_POST['m_category_id'];
			$arr_product['product_name'] = $_POST['product_name'];
			$arr_product['product_no'] = $_POST['product_no'];
			$arr_product['product_price'] = $_POST['product_price'];
			$arr_product['product_price_sale'] = $_POST['product_price_sale'];
			$arr_product['flg_notify'] = 0;
			if(isset($_POST['flg_notify']) == TRUE){
				$arr_product['flg_notify'] = $_POST['flg_notify'];
			}
			$arr_product['msg_notify'] = $_POST['msg_notify'];
			$arr_product['product_info'] = $_POST['product_info'];
			$arr_product['product_link'] = $_POST['product_link'];
			$m_product_id = $ProductModel->updateProduct($arr_product);
			
			if($m_product_id != -1){
				self::insertImagesUpload($m_product_id);
				
			}
		}
		
		Flight::redirect('/main');
	}
	
	public static function action_addproduct()
	{
		$ProductModel = new ProductModel();
		$arr_product = array();
		$arr_product['m_category_id'] = $_POST['m_category_id'];
		$arr_product['product_name'] = $_POST['product_name'];
		$arr_product['product_no'] = $_POST['product_no'];
		$arr_product['product_price'] = $_POST['product_price'];
		$arr_product['product_price_sale'] = $_POST['product_price_sale'];
		$arr_product['flg_notify'] = 0;
		if(isset($_POST['flg_notify']) == TRUE){
			$arr_product['flg_notify'] = $_POST['flg_notify'];
		}
		$arr_product['msg_notify'] = $_POST['msg_notify'];
		$arr_product['product_info'] = $_POST['product_info'];
		$arr_product['product_link'] = $_POST['product_link'];
		$m_product_id = $ProductModel->insertProduct($arr_product);
		
		if($m_product_id != -1){
			self::insertImagesUpload($m_product_id);
		}
		
		
		Flight::redirect('/main');
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
				Support_File::CopyFile($file_src,$file_dest);
				
				//Nén hình
				Support_Image::imageCompress($file_dest,$file_dest);
				$arr_images[] = 'public/upload/'.$m_product_id.'/'.$filename;
			}
		}
		
		$ImageModel = new ImageModel();
		if(count($arr_images) > 0){
			
			//Xóa Hình Cũ
			$listImage = $ImageModel->listImage($m_product_id);
			if($listImage != NULL && count($listImage)>0){
				foreach($listImage as $imageDelete){
					Support_File::DeleteFile(SYSTEM_ROOT_DIR.'/'.$imageDelete['image_path']);
				}
				$ImageModel->deleteImage($m_product_id);
				
			}
			
			
			foreach($arr_images as $k => $image){
				if($k == $_POST['image_default']){
					$ImageModel->insertImage($m_product_id, $image,1);
				}
				else{
					$ImageModel->insertImage($m_product_id, $image);
				}
			}
		}
	}
	
	public static function action_deleteproduct()
	{
		$model = new ProductModel();
		$model->deleteProduct($_POST['m_product_id']);
		Flight::redirect('/main');
	}
    
}
