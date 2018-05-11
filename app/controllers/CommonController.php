<?php

class CommonController extends BasicController {
	
	public static function action_admin()
	{
		if(parent::checklogin() == TRUE){
			Flight::redirect('/main');
		}
		else{
			Flight::renderSmarty('admin/adminlogin.html');
		}
		return FALSE;#Stop Route
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
		return FALSE;#Stop Route
	}

   	public static function action_main()
	{
		if(parent::checklogin() == TRUE){
			$CategoryModel = new CategoryModel();
			$ProductModel = new ProductModel();
			$SiteSettingModel = new SiteSettingModel();
			$DefineModel = new DefineModel();
			$SitePageModel = new SitePageModel();
			$SiteHeader = new SiteHeaderModel();
			$HtmlModel = new HtmlDataModel();
			
			$arr_return = array();
			$arr_return['listCategory'] = $CategoryModel->listCategory();			
			$arr_return['listProduct'] = $ProductModel->listProductImage();
			$arr_return['listDefine'] = $SiteSettingModel->get_define();
			$arr_return['listSectionType'] = $DefineModel->selectSectionType();
			$arr_return['listPageType'] = $DefineModel->selectPageType();
			$arr_return['listPage'] = $SitePageModel->selectAllRows();
			$arr_return['listPageCombo'] = $SitePageModel->selectRowsByConditions(['page_type[!]'=>SYSTEM_META_PAGE_DETAIL]);
			$arr_return['listHeader'] = $SiteHeader->selectAllRows_JoinPage();
			$arr_return['listHtml'] = $HtmlModel->selectAllRows();
			$arr_return['javascript_src'] = Flight::javascript_obfuscator('js/main.js',$arr_return);
		    Flight::renderSmarty('admin/main.html',$arr_return);
		}
		else{
			Flight::redirect('/admin');
		}
		return FALSE;//Stop Route
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
		$arr_sql['image_type'] = SYSTEM_META_SITE_SETTING;
		$arr_sql['m_site_setting_id'] = $m_site_setting_id;
		if($image_path != NULL){
			$arr_sql['image_path'] = $image_path;
		}
		
		//Insert or Update m_image
		$rows = $modelImage->selectRowsByConditions(
			[
				'image_type' => SYSTEM_META_SITE_SETTING,
				'm_site_setting_id' => $m_site_setting_id
			]
		);
		if($rows != NULL && count($rows) > 0 ){
			$modelImage->updateRowById($arr_sql, $rows[0]['m_image_id']);
		}
		else{
			$modelImage->insertRow($arr_sql);
		}
		
		Flight::redirect('/main');
		return FALSE;#Stop Route
	}
	
	public static function action_image_upload()
	{
		//Copy file
		$image_path = self::copy_file_uploaded('file_upload', 'free_images');
		$imgModel = new ImageModel();
		
		$imgModel->insertRow(
			[
				'image_type'=>SYSTEM_META_FREE_IMAGE,
				'image_path'=>$image_path
			]
		);
		
		Flight::json(array('url' => SYSTEM_BASE_URL.$image_path));
	}
    
}
