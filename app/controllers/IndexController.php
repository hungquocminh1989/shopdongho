<?php

class IndexController extends BasicController {
	
	public static function action_index($page_link, $id = '', $product_link = '')
	{
		$arr_return = array();
		$CategoryModel = new CategoryModel();
		$ProductModel = new ProductModel();
		$SiteSettingModel = new SiteSettingModel();
		$SitePageModel = new SitePageModel();
		$SiteHeader = new SiteHeaderModel();
		
		
		$row = $SitePageModel->selectRowsByConditions(
			[
				'page_link' => $page_link
			]
		);
		
		
		if($row != NULL && count($row) > 0){
			if($row[0]['meta_page_type'] == SYSTEM_META_PAGE_LIST){
				
				/*$arr_return['listCategory'] = $CategoryModel->listCategory();
				$arr_return['listProduct'] = $ProductModel->listProductImage();*/
				$arr_return['listDefine'] = $SiteSettingModel->get_define();
				$arr_return['listHeader'] = $SiteHeader->selectAllRows_JoinPage();
				
				$oData = new ObjectData();
				$oData->getPageData($page_link, SYSTEM_META_PAGE_LIST);
				$arr_return['listData'] = $oData->exportPageData();
				
			    Flight::renderSmarty('index.html',$arr_return);
			    return FALSE;//Stop Route
			    
			}
			else if($row[0]['meta_page_type'] == SYSTEM_META_PAGE_DETAIL){
				
				$arr_return = array();
				/*$arr_return['listCategory'] = $CategoryModel->listCategory();*/
				$arr_return['productInfo'] = $ProductModel->listProductDetailById($id, $product_link);
				$arr_return['productInfoImage'] = $ProductModel->listProductImageDetailById($id);
				$arr_return['listDefine'] = $SiteSettingModel->get_define();
				$arr_return['listHeader'] = $SiteHeader->selectAllRows_JoinPage();
				
				$oData = new ObjectData();
				$oData->getPageData($page_link, SYSTEM_META_PAGE_DETAIL);
				$arr_return['listData'] = $oData->exportPageData();
				
				if($arr_return['productInfo'] == NULL){
					Flight::redirect('/');
				}
			    Flight::renderSmarty('detail.html',$arr_return);
			    return FALSE;//Stop Route
			    
			}
			
		}
		return TRUE;// Chạy tiếp qua các Route khác
	}
    
}
