<?php

class HeaderController extends BasicController {
	
	public static function action_delete_header()
	{
		$model = new SiteHeaderModel();
		$model->deleteRowById($_POST['m_site_header_id']);
		Flight::json(array('status' => 'OK'));
	}
	
	public static function action_edit_header()
	{
		$model = new SiteHeaderModel();
		$SitePageModel = new SitePageModel();
		$arr_return = $model->selectRowById($_POST['m_site_header_id'])[0];
		$arr_return['listPage'] = $SitePageModel->selectAllRows();
		//Support_Common::var_dump($arr_return);
		Flight::renderSmarty('admin/dialog/header_edit.html',$arr_return);
		return FALSE;//Stop Route
	}
	
	public static function action_update_header()
	{
		
		$postData = Flight::request()->data->getData();
		$model = new SiteHeaderModel();
		$model->update_header($postData);
		
		//Flight::redirect('/main');
		return FALSE;#Stop Route
	}
    
	public static function action_edit_html()
	{
		$model = new HtmlDataModel();
		$arr_return = $model->selectRowById($_POST['m_html_data_id'])[0];
		
		Flight::renderSmarty('admin/dialog/html_edit.html',$arr_return);
		return FALSE;//Stop Route
	}
	
	public static function action_update_html()
	{
		
		$postData = Flight::request()->data->getData();
		$model = new HtmlDataModel();
		
		$arr_return = array();
		$arr_return['html_name'] = $postData['html_name'];
		$arr_return['html_data'] = $postData['html_data'];
		
		
		if(isset($postData['m_html_data_id']) == TRUE && $postData['m_html_data_id'] != ''){
			$model->updateRowById($arr_return,$postData['m_html_data_id']);
		}
		else{
			$model->insertRow($arr_return);
		}
		
		
		Flight::redirect('/main');
		return FALSE;#Stop Route
	}
	
	public static function action_delete_html()
	{
		$model = new HtmlDataModel();
		$model->deleteRowById($_POST['m_html_data_id']);
		Flight::json(array('status' => 'OK'));
	}
	
}
