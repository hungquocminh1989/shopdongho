<?php

class IndexController extends BasicController {
	
	public static function action_index($page_link)
	{
		/*$arr = array();
		$item1 = 
			[
				'a'=>'A',
				'b'=>2,
				'c'=>3,
				'xx'=> ['Z'=>1,'Y'=>2]
			];
		$item2 = 
			[
				'a'=>'B',
				'b'=>2,
				'c'=>2,
				'd'=>2,
				'xx'=> ['Z'=>2,'Y'=>2],
				'e'=>3
			];
		$item3 = 
			[
				'a'=>'C',
				'b'=>2,
				'xx'=> ['Z'=>3,'Y'=>2],
				'c'=>1
			];
		$arr[] = $item1;
		$arr[] = $item2;
		$arr[] = $item3;
		$arr = Support_Array::filter($arr[0],['a','b']);
		echo "<pre>";
		var_dump($arr);
		die();*/
		
		$arr_return = array();
		$CategoryModel = new CategoryModel();
		$ProductModel = new ProductModel();
		$SiteSettingModel = new SiteSettingModel();
		/*$arr_return['listCategory'] = $CategoryModel->listCategory();
		$arr_return['listProduct'] = $ProductModel->listProductImage();
		$arr_return['listDefine'] = $SiteSettingModel->get_define();*/
		
		//================
		$requestData = Flight::request()->data->getData();
		
		$oData = new ObjectData();
		
		$oData->getPageData($page_link);
		
		$arr_return['listData'] = $oData->exportPageData();
		//================
		
	    Flight::renderSmarty('index.html',$arr_return);
	}
    
}
