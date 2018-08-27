<?php

class CommonController extends Controller {
	
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
			$arr_return['javascript_src'] = Flight::javascript_obfuscator('js/category_form.js');
			$arr_return['javascript_src'] .= Flight::javascript_obfuscator('js/header_form.js');
			$arr_return['javascript_src'] .= Flight::javascript_obfuscator('js/html_form.js');
			$arr_return['javascript_src'] .= Flight::javascript_obfuscator('js/infomation_form.js');
			$arr_return['javascript_src'] .= Flight::javascript_obfuscator('js/page_form.js');
			$arr_return['javascript_src'] .= Flight::javascript_obfuscator('js/product_form.js');
			$arr_return['javascript_src'] .= Flight::javascript_obfuscator('js/main.js');
			$arr_return['javascript_src'] .= Flight::javascript_obfuscator('js/table_fulltextsearch.js');
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
		$image_path = Support_Common::copy_file_uploaded('upload_logo_site', 'site_images');
		
		$param = Support_Array::filter($arrPost,array('site_name','phone','address'));
		$image_path_delete = $modelPage->create_define($param, $image_path);
		
		Support_File::DeleteFile(SYSTEM_ROOT_DIR.'/'.$image_path_delete);
		
		Flight::redirect('/main');
		return FALSE;#Stop Route
	}
	
	public static function action_image_upload()
	{
		//Copy file
		$image_path = Support_Common::copy_file_uploaded('file_upload', 'free_images');
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
