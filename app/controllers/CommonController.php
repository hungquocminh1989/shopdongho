<?php

class CommonController extends BasicController {
	
	public static function action_admin()
	{
		if(parent::checklogin() == TRUE){
			Flight::redirect('/main');
		}
		else{
			Flight::renderSmarty('adminlogin.html');
			return FALSE;//Stop Route
		}
	}
	
	public static function action_login()
	{
		if(parent::checklogin() == TRUE){
			Flight::redirect('/main');
		}
		else{
			if(isset($_POST['passcode'])==TRUE && md5($_POST['passcode']) == SYSTEM_PASSCODE)
			{
				$_SESSION["login_token"] = md5(SYSTEM_PASSCODE);
				Flight::redirect('/main');
			}
			else{
				Flight::redirect('/admin');
			}
		}
	}
	
	public static function action_detail($id, $product_link)
	{
		$CategoryModel = new CategoryModel();
		$ProductModel = new ProductModel();
		$SiteSettingModel = new SiteSettingModel();
		$SitePageModel = new SitePageModel();
		
		$arr_return = array();
		$arr_return['listCategory'] = $CategoryModel->listCategory();
		$arr_return['productInfo'] = $ProductModel->listProductDetailById($id, $product_link);
		$arr_return['productInfoImage'] = $ProductModel->listProductImageDetailById($id);
		$arr_return['listDefine'] = $SiteSettingModel->get_define();
		$arr_return['listPage'] = $SitePageModel->selectAllRows();
		
		if($arr_return['productInfo'] == NULL){
			Flight::redirect('/');
		}
	    Flight::renderSmarty('detail.html',$arr_return);
	    return FALSE;//Stop Route
	}

   	public static function action_main()
	{
		if(parent::checklogin() == TRUE){
			$CategoryModel = new CategoryModel();
			$ProductModel = new ProductModel();
			$SiteSettingModel = new SiteSettingModel();
			$MetaModel = new MetaModel();
			$SitePageModel = new SitePageModel();
			$SiteHeader = new SiteHeaderModel();
			
			$arr_return = array();
			$arr_return['listCategory'] = $CategoryModel->listCategory();
			$arr_return['listProduct'] = $ProductModel->listProductImage();
			$arr_return['listDefine'] = $SiteSettingModel->get_define();
			$arr_return['listPageType'] = $MetaModel->selectSectionType();
			$arr_return['listPage'] = $SitePageModel->selectAllRows();
			$arr_return['listHeader'] = $SiteHeader->selectAllRows_JoinPage();
			$arr_return['javascript_src'] = Flight::javascript_obfuscator('js/main.js',$arr_return);
		    Flight::renderSmarty('main.html',$arr_return);
		    return FALSE;//Stop Route
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
		$arr_sql['meta_type'] = SYSTEM_META_SITE_SETTING;
		$arr_sql['meta_id'] = $m_site_setting_id;
		if($image_path != NULL){
			$arr_sql['image_path'] = $image_path;
		}
		
		//Insert or Update m_image
		$rows = $modelImage->selectRowsByMetaData(SYSTEM_META_SITE_SETTING, $m_site_setting_id);
		if($rows != NULL && count($rows) > 0 ){
			$modelImage->updateRowById($arr_sql, $rows[0]['m_image_id']);
		}
		else{
			$modelImage->insertRow($arr_sql);
		}
		
		Flight::redirect('/main');
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
			$arr_return['meta_type'] =  $section_type;
			
			if($section_type == SYSTEM_META_CATEGORY){
				$arr_return['listCategory'] = $CategoryModel->listCategory();	
				Flight::renderSmarty('main/category_section.html',$arr_return);
			}
			else if($section_type == NULL){
				Flight::renderSmarty('main/slider_section.html',$arr_return);
			}
			else if($section_type == SYSTEM_META_FREE_SECTION){
				Flight::renderSmarty('main/free_section.html',$arr_return);
			}
			else if($section_type == SYSTEM_META_PRODUCT){
				$arr_return['listProduct'] = $ProductModel->listProductImage();
				Flight::renderSmarty('main/product_section.html',$arr_return);
			}
		}
		return FALSE;//Stop Route
	}
	
	public static function action_image_upload()
	{
		//Copy file
		$image_path = self::copy_file_uploaded('file_upload', 'free_images');
		$imgModel = new ImageModel();
		
		$imgModel->insertRow(
			[
				'meta_type'=>SYSTEM_META_FREE_IMAGE,
				'image_path'=>$image_path
			]
		);
		
		Flight::json(array('url' => SYSTEM_BASE_URL.$image_path));
	}
    
}
