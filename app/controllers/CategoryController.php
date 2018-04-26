<?php

class CategoryController extends BasicController {
	public static function action_addcategory()
	{
		$model = new CategoryModel();
		$model->insertRow(['category_name' => $_POST['category_name']]);
		Flight::redirect('/main');
	}
	
	public static function action_deletecategory()
	{
		$model = new CategoryModel();
		$model->deleteRowById($_POST['m_category_id']);
		Flight::json(array('status' => 'OK'));
	}
	
	public static function action_editcategory()
	{
		$model = new CategoryModel();
		$arr_return = $model->selectRowById($_POST['m_category_id']);
		Flight::renderSmarty('dialog/category_edit.html',$arr_return[0]);
		return FALSE;//Stop Route
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
    
}
