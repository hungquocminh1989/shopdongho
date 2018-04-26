<?php

class PageController extends BasicController {
	
	public static function action_delete_page()
	{
		
		$postData = Flight::request()->data->getData();
		$model = new SitePageModel();
		$modelDetail = new SitePageDetailModel();
		$model->deleteRowById($postData['m_site_page_id']);
		$modelDetail->deleteRowsByConditions(['m_site_page_id'=>$postData['m_site_page_id']]);
		
		Flight::redirect('/main');
		return FALSE;//Stop Route
	}
	
	public static function action_edit_page()
	{
		$model = new CategoryModel();
		$arr_return = $model->selectRowById($_POST['m_site_page_id']);
		Flight::renderSmarty('dialog/page_edit.html',$arr_return[0]);
	}
	
	public static function action_update_page()
	{
		
		$postData = Flight::request()->data->getData();
		$model = new SitePageModel();
		$model->update_page($postData);
		
		Flight::redirect('/main');
	}
    
}
