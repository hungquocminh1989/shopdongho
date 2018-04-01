<?php

class CommonController extends BasicController {
	
	public static function action_index()
	{
		$arr_return = array();
		$CategoryModel = new CategoryModel();
		$ProductModel = new ProductModel();
		$SiteSettingModel = new SiteSettingModel();
		$arr_return['listCategory'] = $CategoryModel->listCategory();
		$arr_return['listProduct'] = $ProductModel->listProductImage();
		$arr_return['listDefine'] = $SiteSettingModel->get_define();
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
		$SiteSettingModel = new SiteSettingModel();
		$arr_return = array();
		$arr_return['listCategory'] = $CategoryModel->listCategory();
		$arr_return['productInfo'] = $ProductModel->listProductDetailById($id, $product_link);
		$arr_return['productInfoImage'] = $ProductModel->listProductImageDetailById($id);
		$arr_return['listDefine'] = $SiteSettingModel->get_define();
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
			$SiteSettingModel = new SiteSettingModel();
			$PageSectionTypeModel = new PageSectionTypeModel();
			
			$arr_return = array();
			$arr_return['listCategory'] = $CategoryModel->listCategory();
			$arr_return['listProduct'] = $ProductModel->listProductImage();
			$arr_return['listDefine'] = $SiteSettingModel->get_define();
			$arr_return['listPageType'] = $PageSectionTypeModel->selectAllRows();
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
	
	public function copy_multi_file_uploaded($name, $folderRoot, $compress = FALSE){
		$arr_images = array();
		$countFile = count($_FILES[$name]['type']);
		if($countFile > 0 && $_FILES[$name]['type'][0] != ''){
			for($i = 0; $i < $countFile; $i++){
				$file_src = $_FILES[$name]['tmp_name'][$i];
				$filename = uniqid().'_'.$_FILES[$name]['name'][$i];
				$folder_dest = SYSTEM_PUBLIC_UPLOAD.'/'.$folderRoot;
				$file_dest = $folder_dest.'/'.$filename;
				
				Support_File::CopyFile($file_src,$file_dest);
				
				//Nén hình
				if($compress == TRUE){
					Support_Image::imageCompress($file_dest,$file_dest);
				}
				
				$arr_images[] = 'public/upload/'.$folderRoot.'/'.$filename;
			}
			return $arr_images;
		}
		return NULL;
	}
	
	public static function action_add_define()
	{
		$modelPage = new SiteSettingModel();
		$modelImage = new ImageModel();
		
		$arrPost = Flight::request()->data->getData();
		
		//Copy file
		$image_path = self::copy_file_uploaded('upload_logo_site', 'site_images');
		
		//Insert or Update m_site_setting
		$param = Support_Array::filter($arrPost,array('site_name','phone','address'));
		$m_site_setting_id = $modelPage->create_define($param);
		
		$arr_sql = array();
		$arr_sql['meta_type'] = $modelImage->getMetaType(SYSTEM_META_SITE_SETTING);
		$arr_sql['meta_id'] = $m_site_setting_id;
		if($image_path != NULL){
			$arr_sql['image_path'] = $image_path;
		}
		
		//Insert or Update m_image
		$rows = $modelImage->selectRowsByMetaData($modelImage->getMetaType(SYSTEM_META_SITE_SETTING), $m_site_setting_id);
		if($rows != NULL && count($rows) > 0 ){
			$modelImage->updateRowById($arr_sql, $rows[0]['m_image_id']);
		}
		else{
			$modelImage->insertRow($arr_sql);
		}
		
		Flight::redirect('/main');
	}
	
	public static function action_addcategory()
	{
		$model = new CategoryModel();
		$model->insertRow(['category_name' => $_POST['category_name']]);
		Flight::redirect('/main');
	}
	
	public static function action_editcategory()
	{
		$model = new CategoryModel();
		$arr_return = $model->selectRowById($_POST['m_category_id']);
		Flight::renderSmarty('dialog/category_edit.html',$arr_return[0]);
	}
	
	public static function action_updatecategory()
	{
		$model = new CategoryModel();
		if($_POST['m_category_id'] != ''){
			$m_category_id = $_POST['m_category_id'];
			$category_name = $_POST['category_name'];
			$model->updateRowById(['category_name'=>$category_name], $m_category_id);
		}
		
		Flight::redirect('/main');
	}
	
	public static function action_deletecategory()
	{
		$model = new CategoryModel();
		$model->deleteRowById($_POST['m_category_id']);
		Flight::json(array('status' => 'OK'));
	}
	
	public static function action_add_section()
	{
		if(isset($_POST['section_type'])){
			$m_page_section_type_id = $_POST['section_type'];
			$PageSectionTypeModel = new PageSectionTypeModel();
			$CategoryModel = new CategoryModel();
			$ProductModel = new ProductModel();
			
			$arr_return = array();
			$arr_return = $PageSectionTypeModel->selectRowById($m_page_section_type_id)[0];
			$arr_return['section_index'] =  microtime(TRUE);
			
			if($m_page_section_type_id == 1){
				$arr_return['listCategory'] = $CategoryModel->listCategory();	
				Flight::renderSmarty('main/category_section.html',$arr_return);
			}
			else if($m_page_section_type_id == 2){
				Flight::renderSmarty('main/slider_section.html',$arr_return);
			}
			else if($m_page_section_type_id == 3){
				Flight::renderSmarty('main/free_section.html',$arr_return);
			}
			else if($m_page_section_type_id == 4){
				$arr_return['listProduct'] = $ProductModel->listProductImage();
				Flight::renderSmarty('main/product_section.html',$arr_return);
			}
		}
	}
	
	public static function action_image_upload()
	{
		//Copy file
		$image_path = self::copy_file_uploaded('file_upload', 'free_images');
		$imgModel = new ImageModel();
		$meta_type = $imgModel->getMetaType(SYSTEM_META_FREE_IMAGE);
		$imgModel->insertRow(
			[
				'meta_type'=>$meta_type,
				'image_path'=>$image_path
			]
		);
		
		Flight::json(array('url' => SYSTEM_BASE_URL.$image_path));
	}
	
	public static function action_update_page()
	{
		
		$postData = Flight::request()->data->getData();
		$model = new PageModel();
		$model->update_page($postData);
		
		Flight::redirect('/main');
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
			$arr_product['product_price_sale'] = $_POST['product_price_sale'];
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
		$m_product_id = $ProductModel->insertRow($arr_product);
		
		if($m_product_id !== FALSE){
			self::insertImagesUpload($m_product_id);
		}
		
		
		Flight::redirect('/main');
	}
	
	public static function action_editproduct()
	{
		$model = new ProductModel();
		$CategoryModel = new CategoryModel();
		$arr_return = array();
		$arr_return = $model->selectRowById($_POST['m_product_id'])[0];
		$arr_return['listCategory'] = $CategoryModel->listCategory();
		Flight::renderSmarty('dialog/product_edit.html',$arr_return);
	}
	
	public function insertImagesUpload($m_product_id){
		
		$folderRoot = "product_images/$m_product_id";
		
		$arr_images = self::copy_multi_file_uploaded('upload', $folderRoot, TRUE);
		
		$ImageModel = new ImageModel();
		if(count($arr_images) > 0){
			$meta_type = $ImageModel->getMetaType(SYSTEM_META_PRODUCT);
			
			//Xóa Hình Cũ
			$listImage = $ImageModel->selectRowsByMetaData($meta_type,$m_product_id);
			if($listImage != NULL && count($listImage)>0){
				foreach($listImage as $imageDelete){
					Support_File::DeleteFile(SYSTEM_ROOT_DIR.'/'.$imageDelete['image_path']);
				}
				$ImageModel->deleteRowsByMetaData($meta_type,$m_product_id);
				
			}
			
			
			foreach($arr_images as $k => $image){
				if($k == $_POST['image_default']){
					$ImageModel->insertRow(
						[
							'meta_type' => $meta_type,
							'meta_id' => $m_product_id,
							'image_path' => $image,
							'default_flg' => 1
						]					
					);
				}
				else{
					$ImageModel->insertRow(
						[
							'meta_type' => $meta_type,
							'meta_id' => $m_product_id,
							'image_path' => $image,
							'default_flg' => 0
						]					
					);
				}
			}
		}
	}
	
	public static function action_deleteproduct()
	{
		$model = new ProductModel();
		$model->deleteProduct($_POST['m_product_id']);
		Flight::json(array('status' => 'OK'));
	}
    
}
