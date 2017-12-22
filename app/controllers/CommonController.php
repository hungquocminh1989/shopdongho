<?php
namespace app\controllers;

use Flight; 

class CommonController extends BasicController {

	public static function index()
	{
		$model = new \app\models\SampleModel();
		$tmp = $model->getTable();
		
		$arr_return = array();
		$arr_return['test'] = $tmp;
	    parent::flight(__FUNCTION__,$arr_return);
	    return;
	}

   	public static function main()
	{
		$model = new \app\models\CategoryModel();
		$arr_return['listCategory'] = $model->listCategory();
		
		$arr_return = array();
		$arr_return['test'] = '';
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
	
	public static function addproduct()
	{
		$arr_images = array();
		
		//Get file upload
		$countFile = count($_FILES['upload']['type']);
		
		if($countFile > 0){
			for($i = 0; $i < $countFile; $i++){
				$file_src = $_FILES['upload']['tmp_name'][$i];
				$filename = uniqid().'_'.$_FILES['upload']['name'][$i];
				$file_dest = SYSTEM_PUBLIC_UPLOAD.'/'.$filename;
				copy($file_src,$file_dest);
				$arr_images[] = '/public/upload/'.$filename;
			}
		}
		
		$ProductModel = new \app\models\ProductModel();
		$m_product_id = $ProductModel->insertProduct($_POST['product_name']);
		
		if($m_product_id != -1){
			$ImageModel = new \app\models\ImageModel();
			if(count($arr_images) > 0){
				foreach($arr_images as $image){
					$ImageModel->insertImage($m_product_id, $image);
				}
			}
		}
		
		
		Flight::redirect('/main');
	    return;
	}
    
}
