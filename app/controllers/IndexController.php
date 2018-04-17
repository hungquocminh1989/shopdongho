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
		
		$pageModel = new SitePageModel();
		$pageDetailModel = new SitePageDetailModel();
		
		$arr_site_page = $pageModel->selectRowsByConditions([
			'page_link' => $page_link
		]);
		
		$oData = new ObjectData();
		
		if($arr_site_page != NULL && count($arr_site_page) == 1){
			$m_site_page_id = $arr_site_page[0]['m_site_page_id'];
			$listMetaTypeDetail = $pageDetailModel->selectAllMetaType($m_site_page_id);
			
			if($listMetaTypeDetail != NULL && count($listMetaTypeDetail) > 0){
				
				
				
				foreach($listMetaTypeDetail as $value){
					
					$meta_type = $value['meta_type'];
					
					$listDetail = $pageDetailModel->selectRowsByConditions([
						'm_site_page_id' => $m_site_page_id,
						'meta_type' => $meta_type
					]);
					
					if($listDetail != NULL && count($listDetail) > 0){
						
						foreach($listDetail as $item){
							
							$meta_id = $item['meta_id'];
							
							$title = '';
							$data = NULL;
							
							if($meta_type ==  $pageModel->getMetaType(SYSTEM_META_CATEGORY)){
								$data = $CategoryModel->getDataCtg($meta_id);
								$oData->appendData($data);
							}
							else if($meta_type ==  $pageModel->getMetaType(SYSTEM_META_PRODUCT)){
								$data = $ProductModel->selectRowById($meta_id);
								$oData->appendData($data);
							}
							else if($meta_type ==  $pageModel->getMetaType(SYSTEM_META_FREE_SECTION)){
								$data = $ProductModel->selectRowById($meta_id);
								$oData->appendData($data);
							}
						}
						
					}
					
				}
				
			}
		}
		$arr_return['listData'] = $oData->export();
		//================
		
	    Flight::renderSmarty('index.html',$arr_return);
	}
    
}
