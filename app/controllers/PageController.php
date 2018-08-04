<?php

class PageController extends BasicController {
	
	public static function action_delete_page()
	{
		
		$postData = Flight::request()->data->getData();
		$model = new SitePageModel();
		$model->delete_page($postData['m_site_page_id']);
		
		Flight::redirect('/main');
		return FALSE;//Stop Route
	}
	
	public static function action_edit_page()
	{
		$model = new SitePageModel();
		$DefineModel = new DefineModel();
		$CategoryModel = new CategoryModel();
		$ProductModel = new ProductModel();
		$HtmlModel = new HtmlDataModel();
		
		$arr_return = $model->selectRowById($_POST['m_site_page_id'])[0];
		$arr_return['listSectionType'] = $DefineModel->selectSectionType();
		$arr_return['listPageType'] = $DefineModel->selectPageType();
		$arr_return['listPage'] = $model->get_edit_page($_POST['m_site_page_id']);
		$arr_return['listPageCombo'] = $model->selectRowsByConditions(
			[
				'page_type[!]'=>SYSTEM_META_PAGE_DETAIL,
				'm_site_page_id[!]'=>$_POST['m_site_page_id']
			]
		);
		$arr_return['listProductSelected'] = $model->get_list_product_selected($_POST['m_site_page_id']);
		$arr_return['listImageSection'] = $model->get_list_image_section($_POST['m_site_page_id']);
		$arr_return['listCategory'] = $CategoryModel->listCategory();
		$arr_return['listProduct'] = $ProductModel->listProductImage();
		$arr_return['listHtml'] = $HtmlModel->selectAllRows();
		
		//Support_Common::RequestError($arr_return['listProductSelected']);
		
		Flight::renderSmarty('admin/dialog/page_edit.html',$arr_return);
		return FALSE;//Stop Route
	}
	
	public static function action_add_section()
	{
		if(isset($_POST['section_type'])){
			$section_type = $_POST['section_type'];
			$DefineModel = new DefineModel();
			$CategoryModel = new CategoryModel();
			$ProductModel = new ProductModel();
			$HtmlModel = new HtmlDataModel();
			$SitePageModel = new SitePageModel();
			
			$arr_return = array();
			$arr_return = $DefineModel->selectRowById($section_type)[0];
			$arr_return['sort_no'] =  str_replace('.','',microtime(TRUE));
			$arr_return['section_type'] =  $section_type;
			
			if($section_type == SYSTEM_META_SECTION_CATEGORY){
				$arr_return['listCategory'] = $CategoryModel->listCategory();	
				Flight::renderSmarty('admin/section/category_section.html',$arr_return);
			}
			else if($section_type == NULL){
				Flight::renderSmarty('admin/section/slider_section.html',$arr_return);
			}
			else if($section_type == SYSTEM_META_SECTION_FREE){
				$arr_return['listHtml'] = $HtmlModel->selectAllRows();
				Flight::renderSmarty('admin/section/free_section.html',$arr_return);
			}
			else if($section_type == SYSTEM_META_SECTION_PRODUCT){
				$arr_return['listCategory'] = $CategoryModel->listCategory();
				$arr_return['listProduct'] = $ProductModel->listProductImage();
				Flight::renderSmarty('admin/section/product_section.html',$arr_return);
			}
			else if ($section_type == SYSTEM_META_SECTION_SLIDER){
				Flight::renderSmarty('admin/section/slider_section.html',$arr_return);
			}
			else if ($section_type == SYSTEM_META_SECTION_IMAGE){
				$arr_return['listPageCombo'] = $SitePageModel->selectRowsByConditions(['page_type[!]'=>SYSTEM_META_PAGE_DETAIL]);
				Flight::renderSmarty('admin/section/image_section.html',$arr_return);
			}
		}
		return FALSE;//Stop Route
	}
	
	public static function action_checkexistpagetype()
	{
		//Kiểm tra tồn tại cho loại trang chi tiết sản phẩm
		if(isset($_POST['page_type']) == TRUE && $_POST['page_type'] == SYSTEM_META_PAGE_DETAIL){
			
			$model = new SitePageModel();
			$rows = $model->selectRowsByConditions(['page_type' => $_POST['page_type']]);
			Support_Common::var_dump($rows);
			if($rows != NULL && count($rows) > 0){
				$old_id = $rows[0]['m_site_page_id'];
				Flight::json(['status' => 'NG', 'old_id' => $old_id]);
			}
			else{
				Flight::json(['status' => 'OK']);
			}
			
		}
		else{
			Flight::json(['status' => 'OK']);
		}
		return FALSE;#Stop Route
	}
	
	public static function action_update_page()
	{
		
		$postData = Flight::request()->data->getData();
		//Support_Common::RequestError($postData);
		$model = new SitePageModel();
		$model->update_page($postData);
		
		Flight::redirect('/main');
		return FALSE;#Stop Route
	}
    
}
