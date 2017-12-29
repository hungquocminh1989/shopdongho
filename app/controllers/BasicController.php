<?php
namespace app\controllers;

use Flight; 

class BasicController {

    public static function flight($page, $array = null)
    {
        Flight::render($page, $array);
        return;
    }
    
    public function getDataDefault(){
		$CategoryModel = new \app\models\CategoryModel();
		$ProductModel = new \app\models\ProductModel();
		
		$arr_return = array();
		$arr_return['listCategory'] = $CategoryModel->listCategory();
		$arr_return['listProduct'] = $ProductModel->listProduct();
		
		return $arr_return;
	}
    
}
