<?php

class IndexController extends BasicController {
	
	public static function action_index($page_link)
	{
		
		$arr_return = array();
		$CategoryModel = new CategoryModel();
		$ProductModel = new ProductModel();
		$SiteSettingModel = new SiteSettingModel();
		$SitePageModel = new SitePageModel();
		
		
		$row = $SitePageModel->selectRowsByConditions(
			[
				'page_link' => $page_link
			]
		);
		
		if($row != NULL && count($row) > 0){
			$arr_return['listCategory'] = $CategoryModel->listCategory();
			$arr_return['listProduct'] = $ProductModel->listProductImage();
			$arr_return['listDefine'] = $SiteSettingModel->get_define();
			$arr_return['listPage'] = $SitePageModel->selectAllRows();
			
			
			$oData = new ObjectData();
			
			$oData->getPageData($page_link);
			
			$arr_return['listData'] = $oData->exportPageData();
			
		    Flight::renderSmarty('page.html',$arr_return);
		    return FALSE;//Stop Route
		}
		return TRUE;// Chạy tiếp qua các Route khác
	}
    
}
