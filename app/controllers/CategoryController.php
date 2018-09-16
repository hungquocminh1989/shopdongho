<?php

class CategoryController extends Controller {
	
	public static function action_deletecategory()
	{
		$model = new CategoryModel();
		$model->deleteRowById($_POST['m_category_id']);
		Flight::json(array('status' => 'OK'));
		return FALSE;#Stop Route
	}
	
	public static function action_editcategory()
	{
		$model = new CategoryModel();
		$arr_return = $model->selectRowById($_POST['m_category_id']);
		Flight::renderSmarty('admin/dialog/category_edit.html',$arr_return[0]);
		return FALSE;//Stop Route
	}
	
	public static function action_updatecategory()
	{
		$model = new CategoryModel();
		$m_category_id = $_POST['m_category_id'];
		$category_name = $_POST['category_name'];
		$model->update_ctg($m_category_id, $category_name);
		
		Flight::redirect('/main');
		return FALSE;#Stop Route
	}
	
	public static function action_dragsort(){
		
		parent::update_sort_no('m_category');
		Flight::json(array('status' => 'OK'));
		return FALSE;#Stop Route
		
	}
    
}
