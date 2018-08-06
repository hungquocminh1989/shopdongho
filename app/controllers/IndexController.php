<?php

class IndexController extends BasicController {
	
	public static function action_index($page_link = '', $id = '', $product_link = '')
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
		
		$arr_return['listDefine'] = $SiteSettingModel->get_define();
		$arr_return['listHeader'] = $SiteHeader->selectAllRows_JoinPage();
		
		//Get link detail
		$row_detail = $SitePageModel->selectRowsByConditions(
			[
				'page_type' => SYSTEM_META_PAGE_DETAIL
			]
		);
		if($row_detail != NULL && count($row_detail) > 0){
			$arr_return['refix_link_detail'] = $row_detail[0]['page_link'];
		}
		
		
		if($row != NULL && count($row) > 0){
			
			//Set path folder template
			$layout_template_name = 'bushido-layout';
			$layout_template_folder = "app/views/frontend/$layout_template_name/";
			/**
			* m_layout_template
			* m_layout_template_id
			* layout_template_name
			*/
			Flight::set('flight.views.path', $layout_template_folder);
			Flight::viewSmarty()->setTemplateDir(SYSTEM_ROOT_DIR.$layout_template_folder);
			
			$oData = new ObjectData();
			
			if($row[0]['page_type'] == SYSTEM_META_PAGE_LIST){
				
				$oData->getPageData($page_link, SYSTEM_META_PAGE_LIST);
				$arr_return['listData'] = $oData->exportPageData();
				//Support_Common::var_dump($arr_return['listData']);
			    Flight::renderSmarty('index.html',$arr_return);
			    return FALSE;//Stop Route
			    
			}
			else if($row[0]['page_type'] == SYSTEM_META_PAGE_DETAIL){
				
				$arr_return['productInfo'] = $ProductModel->listProductDetailById($id, $product_link);
				$arr_return['productInfoImage'] = $ProductModel->listProductImageDetailById($id);
				$oData->getPageData($page_link, SYSTEM_META_PAGE_DETAIL);
				$arr_return['listData'] = $oData->exportPageData();
				
				if($arr_return['productInfo'] == NULL){
					Flight::redirect('/');
				}
				
			    Flight::renderSmarty('detail.html',$arr_return);
			    return FALSE;//Stop Route
			    
			}
			
		}
		if(SYSTEM_DEVELOPMENT_MODE == TRUE){
			return TRUE;// Chạy tiếp qua các Route khác
		}
		else{
			return FALSE;//Stop Route
		}
		
	}
    
}
