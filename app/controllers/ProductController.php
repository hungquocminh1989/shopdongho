<?php

class ProductController extends Controller {
	
	public static function action_deleteproduct()
	{
		$model = new ProductModel();
		$model->deleteProduct($_POST['m_product_id']);
		Flight::json(array('status' => 'OK'));
	}
	
	public static function action_editproduct()
	{
		$model = new ProductModel();
		$CategoryModel = new CategoryModel();
		$arr_return = array();
		$arr_return = $model->selectRowById($_POST['m_product_id'])[0];
		$arr_return['listCategory'] = $CategoryModel->listCategory();
		Flight::renderSmarty('admin/dialog/product_edit.html',$arr_return);
		return FALSE;//Stop Route
	}
	
	public static function action_updateproduct()
	{
		$model = new ProductModel();
		$arr_product = array();
		$m_product_id = NULL;
		$arr_product['m_category_id'] = $_POST['m_category_id'];
		$arr_product['product_name'] = $_POST['product_name'];
		$arr_product['product_no'] = $_POST['product_no'];
		$arr_product['product_price'] = $_POST['product_price'];
		if(isset($_POST['product_price_sale']) && $_POST['product_price_sale'] != ''){
			$arr_product['product_price_sale'] = $_POST['product_price_sale'];
		}
		$arr_product['flg_notify'] = 0;
		if(isset($_POST['flg_notify']) == TRUE){
			$arr_product['flg_notify'] = $_POST['flg_notify'];
		}
		$arr_product['msg_notify'] = $_POST['msg_notify'];
		$arr_product['product_info'] = $_POST['product_info'];
		$arr_product['product_link'] = $_POST['product_link'];
		
		if($_POST['m_product_id'] != ''){
			$m_product_id = $_POST['m_product_id'];
		}
		
		$model->update_product($arr_product, $m_product_id);
		
		Flight::redirect('/main');
		return FALSE;#Stop Route
	}
	
	public static function action_dragsort(){
		
		parent::update_sort_no('m_product');
		Flight::json(array('status' => 'OK'));
		return FALSE;#Stop Route
		
	}
    
}
