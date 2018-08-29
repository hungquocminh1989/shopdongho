<?php

class HtmlController extends Controller {
    
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
		
		
		/*if(isset($postData['m_html_data_id']) == TRUE && $postData['m_html_data_id'] != ''){
			$model->updateRowById($arr_return,$postData['m_html_data_id']);
		}
		else{
			$model->insertRow($arr_return);
		}*/
		$model->upsertRow($arr_return,$postData['m_html_data_id']);
		$model->generateSortNo('m_html_data');
		
		
		Flight::redirect('/main');
		return FALSE;#Stop Route
	}
	
	public static function action_delete_html()
	{
		$model = new HtmlDataModel();
		$model->deleteRowById($_POST['m_html_data_id']);
		Flight::json(array('status' => 'OK'));
	}
	
	public static function action_dragsort(){
		
		parent::update_sort_no('m_html_data');
		Flight::json(array('status' => 'OK'));
		return FALSE;#Stop Route
		
	}
	
}
