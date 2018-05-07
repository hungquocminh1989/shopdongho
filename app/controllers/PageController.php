<?php

class PageController extends BasicController {
	
	public static function action_delete_page()
	{
		
		$postData = Flight::request()->data->getData();
		$model = new SitePageModel();
		$model->delete_page_data($postData['m_site_page_id']);
		
		Flight::redirect('/main');
		return FALSE;//Stop Route
	}
	
	public static function action_edit_page()
	{
		$model = new SitePageModel();
		$arr_return = $model->selectRowById($_POST['m_site_page_id']);
		Flight::renderSmarty('admin/dialog/page_edit.html',$arr_return[0]);
		return FALSE;//Stop Route
	}
	
	public static function action_add_section()
	{
		if(isset($_POST['section_type'])){
			$section_type = $_POST['section_type'];
			$DefineModel = new DefineModel();
			$CategoryModel = new CategoryModel();
			$ProductModel = new ProductModel();
			
			$arr_return = array();
			$arr_return = $DefineModel->selectRowById($section_type)[0];
			$arr_return['section_index'] =  microtime(TRUE);
			$arr_return['define_key'] =  $section_type;
			
			if($section_type == SYSTEM_META_SECTION_CATEGORY){
				$arr_return['listCategory'] = $CategoryModel->listCategory();	
				Flight::renderSmarty('admin/section/category_section.html',$arr_return);
			}
			else if($section_type == NULL){
				Flight::renderSmarty('admin/section/slider_section.html',$arr_return);
			}
			else if($section_type == SYSTEM_META_SECTION_FREE){
				Flight::renderSmarty('admin/section/free_section.html',$arr_return);
			}
			else if($section_type == SYSTEM_META_SECTION_PRODUCT){
				$arr_return['listCategory'] = $CategoryModel->listCategory();
				$arr_return['listProduct'] = $ProductModel->listProductImage();
				Flight::renderSmarty('admin/section/product_section.html',$arr_return);
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
		$model = new SitePageModel();
		$model->update_page($postData);
		
		Flight::redirect('/main');
		return FALSE;#Stop Route
	}
    
}
