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
		
		//================
		$requestData = Flight::request()->data->getData();
		
		$pageModel = new SitePageModel();
		$pageDetailModel = new SitePageDetailModel();
		
		$arr_site_page = $pageModel->selectRowsByConditions([
			'page_link' => $page_link
		]);
		
		$arr_data_sections = array();
		
		if($arr_site_page != NULL && count($arr_site_page) == 1){
			
			$listPageDetail = $pageDetailModel->selectRowsByConditions([
				'm_site_page_id' => $arr_site_page[0]['m_site_page_id']
			]);
			
			if($listPageDetail != NULL && count($listPageDetail) > 0){
				
				foreach($listPageDetail as $key => $value){
					$arr_section = array();
					
					$meta_type = $value['meta_type'];
					if(true){
						
					}
					
					
					$arr_section['title'] = '';
					$arr_section['data'] = '';
					
					$arr_data_sections[] = $arr_section;
				}
				
			}
		}
		//================
		
	    Flight::renderSmarty('index.html',$arr_return);
	}
	
	public static function action_admin()
	{
		if(parent::checklogin() == TRUE){
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
		if(parent::checklogin() == TRUE){
			$CategoryModel = new CategoryModel();
			$ProductModel = new ProductModel();
			$SiteSettingModel = new SiteSettingModel();
			$MetaModel = new MetaModel();
			$SitePageModel = new SitePageModel();
			
			$arr_return = array();
			$arr_return['listCategory'] = $CategoryModel->listCategory();
			$arr_return['listProduct'] = $ProductModel->listProductImage();
			$arr_return['listDefine'] = $SiteSettingModel->get_define();
			$arr_return['listPageType'] = $MetaModel->selectSectionType();
			$arr_return['listPage'] = $SitePageModel->selectAllRows();
			$arr_return['javascript_src'] = Flight::javascript_obfuscator('js/main.js',$arr_return);
		    Flight::renderSmarty('main.html',$arr_return);
		}
		else{
			Flight::redirect('/admin');
		}
	}
	
	
	public static function action_add_define()
	{
		$modelPage = new SiteSettingModel();
		$modelImage = new ImageModel();
		
		$arrPost = Flight::request()->data->getData();
		
		//Copy file
		$image_path = parent::copy_file_uploaded('upload_logo_site', 'site_images');
		
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
			$section_type = $_POST['section_type'];
			$MetaModel = new MetaModel();
			$CategoryModel = new CategoryModel();
			$ProductModel = new ProductModel();
			
			$arr_return = array();
			$arr_return = $MetaModel->selectRowById($section_type)[0];
			$arr_return['section_index'] =  microtime(TRUE);
			
			if($section_type == 4){
				$arr_return['listCategory'] = $CategoryModel->listCategory();	
				Flight::renderSmarty('main/category_section.html',$arr_return);
			}
			else if($section_type == NULL){
				Flight::renderSmarty('main/slider_section.html',$arr_return);
			}
			else if($section_type == 6){
				Flight::renderSmarty('main/free_section.html',$arr_return);
			}
			else if($section_type == 1){
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
		$model = new SitePageModel();
		$model->update_page($postData);
		
		Flight::redirect('/main');
	}
	
	public static function action_delete_page()
	{
		
		$postData = Flight::request()->data->getData();
		$model = new SitePageModel();
		$modelDetail = new SitePageDetailModel();
		$model->deleteRowById($postData['m_site_page_id']);
		$modelDetail->deleteRowsByConditions(['m_site_page_id'=>$postData['m_site_page_id']]);
		
		Flight::redirect('/main');
	}
	
	public static function action_edit_page()
	{
		$model = new CategoryModel();
		$arr_return = $model->selectRowById($_POST['m_site_page_id']);
		Flight::renderSmarty('dialog/page_edit.html',$arr_return[0]);
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
		
		$arr_images = parent::copy_multi_file_uploaded('upload', $folderRoot, TRUE);
		
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
