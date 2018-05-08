<?php 

class ObjectData {
    protected $arr_data;
    
    public function __construct() {
    	$this->arr_data = array();
    }
    
    public function getPageData($page_link, $page_type){
		$pageModel = new SitePageModel();
		$pageSectionModel = new SitePageSectionModel();
		$PageHandle = new PageHandle();
		
		$arr_site_page = $pageModel->selectRowsByConditions([
			'page_link' => $page_link,
			'page_type' => $page_type
		]);
		
		
		//Select Trang chỉ định
		if($arr_site_page != NULL && count($arr_site_page) == 1){
			
			//Select tất cả các type có trong trang chỉ định
			$m_site_page_id = $arr_site_page[0]['m_site_page_id'];
			$listMetaTypeDetail = $pageSectionModel->selectAllSectionType($m_site_page_id);
			
			
			if($listMetaTypeDetail != NULL && count($listMetaTypeDetail) > 0){
				
				foreach($listMetaTypeDetail as $value){
					
					$section_type = $value['section_type'];
					
					//Lấy data theo từng type
					/*$listDetail = $pageSectionModel->selectRowsByConditions([
						'm_site_page_id' => $m_site_page_id,
						'section_type' => $section_type
					]);*/
					
					$listDetail = $pageSectionModel->selectSectionData($m_site_page_id, $section_type, $page_type);
					
					if($listDetail != NULL && count($listDetail) > 0){
						
						foreach($listDetail as $item){
							
							//Lưu giữ cộng dồn vào class ObjectData
							if($section_type ==  SYSTEM_META_SECTION_CATEGORY){
								$m_category_id = $item['m_category_id'];
								$data = $PageHandle->selectPage_CategoryData($m_category_id, $page_type);
								$this->appendData($data);
							}
							else if($section_type ==  SYSTEM_META_SECTION_PRODUCT){
								$m_product_id = $item['m_product_id'];
							}
							else if($section_type ==  SYSTEM_META_SECTION_FREE){
								$m_html_data_id = $item['m_html_data_id'];
								$data = $PageHandle->selectPage_FreeHtmlData($m_html_data_id);
								$this->appendData($data);
							}
							
						}
						
					}
					
				}
				
			}
		}
	}
    
    public function appendData($obj_data){
    	foreach($obj_data as $key => $value){
			$this->arr_data[] = $value;
		}
	}
	
	public function exportPageData(){
		/**
		* Structure data return
		*  array(3) 
		*	[
		*	    "type"  => int(4)
		*	    "title" => string(17) "Đồng Hồ ABC"
		*	    "data"  =>  array(1) 
		*	        [
		*	            0 =>  array(17)  //Product item
		* 					[
		* 						...
		* 					]
		*	        ]
		*	]
		* 
		*/
		
		if($this->arr_data != NULL && count($this->arr_data) > 0){
			$arr_return = array();
			$arr_name = array();
			
			//Support_Common::var_dump($this->arr_data);
			
			//Phân loại data thành từng mảng riêng biệt
			foreach($this->arr_data as $key => $value){
				
				$type = $value['section_type'];
				$id = $value['m_site_page_section_id'];
				$sort_no = $value['sort_no'];
				
				//Tạo tên mảng dùng để sắp xếp theo thứ tự data trên page
				$name = "arr_".$type."_".$id."_".$sort_no;
				
				if(in_array($name,$arr_name)=== FALSE){
					$arr_name[] = $name;
				}
				
				${$name}['type'] = $type;
				${$name}['title'] = $value['section_title'];
				
				//Bắt đầu phân loại data
				if($type == SYSTEM_META_SECTION_CATEGORY){
					
					${$name}['data'][] = $value;
					
				}
				else if($type == SYSTEM_META_SECTION_PRODUCT){
					/*${$name}['type'] = $type;
					${$name}['title'] = $value['product_name'];
					${$name}['data'][0] = $value;*/
				}
				else if($type == SYSTEM_META_SECTION_FREE){
					
					${$name}['data'][] = $value;
					
				}
				
			}
			//Support_Common::var_dump($arr_name);
			
			sort($arr_name);
			
			foreach($arr_name as $key => $value){
				$arr_return[] = ${$value};
				//Support_Common::var_dump($value);
				//Support_Common::var_dump(${$value});
			}
			//Support_Common::var_dump($this->arr_data);
			//Support_Common::var_dump($arr_return);die();
			
			return $arr_return;
		}
		else{
			return NULL;
		}
		
	}
	  
}
