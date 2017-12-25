<?php
namespace app\controllers;

use Flight; 

class CommonController extends BasicController {

	public static function index()
	{
		$arr_return = array();
		$ProductModel = new \app\models\ProductModel();
		$arr_return['listProduct'] = $ProductModel->listProductImage();
	    parent::flight(__FUNCTION__,$arr_return);
	    return;
	}
	
	public static function detail()
	{
	    parent::flight(__FUNCTION__,$arr_return);
	    return;
	}

   	public static function main()
	{
		$CategoryModel = new \app\models\CategoryModel();
		$ProductModel = new \app\models\ProductModel();
		
		$arr_return = array();
		$arr_return['listCategory'] = $CategoryModel->listCategory();
		$arr_return['listProduct'] = $ProductModel->listProduct();
	    parent::flight(__FUNCTION__,$arr_return);
	    return;
	}
	
	public static function addcategory()
	{
		$model = new \app\models\CategoryModel();
		$model->insertCategory($_POST['category_name']);
		Flight::redirect('/main');
	    return;
	}
	
	public static function editcategory()
	{
		$CategoryModel = new \app\models\CategoryModel();
		$ProductModel = new \app\models\ProductModel();
		
		$arr_return = array();
		$arr_return['rowCategory'] = $CategoryModel->listCategoryById($_POST['m_category_id']);
		$arr_return['listCategory'] = $CategoryModel->listCategory();
		$arr_return['listProduct'] = $ProductModel->listProduct();
		parent::flight('main',$arr_return);
	    return;
	}
	
	public static function deletecategory()
	{
		$model = new \app\models\CategoryModel();
		$model->deleteCategory($_POST['m_category_id']);
		Flight::redirect('/main');
	    return;
	}
	
	public static function addproduct()
	{
		$ProductModel = new \app\models\ProductModel();
		$arr_product = array();
		$arr_product['m_category_id'] = $_POST['m_category_id'];
		$arr_product['product_name'] = $_POST['product_name'];
		$arr_product['product_no'] = $_POST['product_no'];
		$arr_product['product_price'] = $_POST['product_price'];
		$arr_product['product_info'] = $_POST['product_info'];
		$m_product_id = $ProductModel->insertProduct($arr_product);
		
		if($m_product_id != -1){
			if (!is_dir('public/upload')) {
			    mkdir('public/upload', 0777, true);
			}
			
			if (!is_dir('public/upload/'.$m_product_id)) {
			    mkdir('public/upload/'.$m_product_id, 0777, true);
			}
			
			$arr_images = array();
		
			//Get file upload
			$countFile = count($_FILES['upload']['type']);
			
			if($countFile > 0){
				for($i = 0; $i < $countFile; $i++){
					$file_src = $_FILES['upload']['tmp_name'][$i];
					$filename = uniqid().'_'.$_FILES['upload']['name'][$i];
					$file_dest = SYSTEM_PUBLIC_UPLOAD.'/'.$m_product_id.'/'.$filename;
					copy($file_src,$file_dest);
					$arr_images[] = 'public/upload/'.$m_product_id.'/'.$filename;
				}
			}
			
			$ImageModel = new \app\models\ImageModel();
			if(count($arr_images) > 0){
				foreach($arr_images as $k => $image){
					if($k == 0){
						$ImageModel->insertImage($m_product_id, $image,1);
					}
					else{
						$ImageModel->insertImage($m_product_id, $image);
					}
				}
			}
		}
		
		
		Flight::redirect('/main');
	    return;
	}
	
	public static function deleteproduct()
	{
		$model = new \app\models\ProductModel();
		$model->deleteProduct($_POST['m_product_id']);
		Flight::redirect('/main');
	    return;
	}
    
}
