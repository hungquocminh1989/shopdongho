<?php 

class ObjectData {
    protected $arr_data;
    
    public function __construct() {
    	$this->arr_data = array();
    }
    
    public function getPageData($page_link){
		$pageModel = new SitePageModel();
		$pageDetailModel = new SitePageDetailModel();
		$PageHandle = new PageHandle();
		
		$arr_site_page = $pageModel->selectRowsByConditions([
			'page_link' => $page_link
		]);
		
		
		//Select Trang chỉ định
		if($arr_site_page != NULL && count($arr_site_page) == 1){
			
			//Select tất cả các type có trong trang chỉ định
			$m_site_page_id = $arr_site_page[0]['m_site_page_id'];
			$listMetaTypeDetail = $pageDetailModel->selectAllMetaType($m_site_page_id);
			
			
			if($listMetaTypeDetail != NULL && count($listMetaTypeDetail) > 0){
				
				foreach($listMetaTypeDetail as $value){
					
					$meta_type = $value['meta_type'];
					
					//Lấy data theo từng type
					$listDetail = $pageDetailModel->selectRowsByConditions([
						'm_site_page_id' => $m_site_page_id,
						'meta_type' => $meta_type
					]);
					
					if($listDetail != NULL && count($listDetail) > 0){
						
						foreach($listDetail as $item){
							
							$meta_id = $item['meta_id'];
							
							$title = '';
							$data = NULL;
							
							//Lưu giữ cộng dồn vào class ObjectData
							if($meta_type ==  SYSTEM_META_CATEGORY){
								$data = $PageHandle->selectPage_CategoryData($meta_id);
								$this->appendData($data);
							}
							else if($meta_type ==  SYSTEM_META_PRODUCT){
								
							}
							else if($meta_type ==  SYSTEM_META_FREE_SECTION){
								$data = $PageHandle->selectPage_FreeHtmlData($item['m_site_page_detail_id']);
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
		$pageModel = new SitePageModel();
		if($this->arr_data != NULL && count($this->arr_data) > 0){
			$arr_return = array();
			$arr_name = array();
			
			//Support_Common::var_dump($this->arr_data);
			
			//Phân loại data thành từng mảng riêng biệt
			foreach($this->arr_data as $key => $value){
				
				$type = $value['meta_type'];
				$id = $value['m_site_page_detail_id'];
				$sort_no = $value['sort_no'];
				
				//Tạo tên mảng dùng để sắp xếp theo thứ tự data trên page
				$name = "arr_".$type."_".$id."_".$sort_no;
				
				if(in_array($name,$arr_name)=== FALSE){
					$arr_name[] = $name;
				}
				
				${$name}['type'] = $type;
				${$name}['title'] = $value['section_title'];
				
				//Bắt đầu phân loại data
				if($type == SYSTEM_META_CATEGORY){
					
					${$name}['data'][0] = $value;
					
				}
				else if($type == SYSTEM_META_PRODUCT){
					/*${$name}['type'] = $type;
					${$name}['title'] = $value['product_name'];
					${$name}['data'][0] = $value;*/
				}
				else if($type == SYSTEM_META_FREE_SECTION){
					
					${$name}['data'][0] = $value;
					
				}
				
			}
			//Support_Common::var_dump($arr_name);
			
			sort($arr_name);
			
			foreach($arr_name as $key => $value){
				$arr_return[] = ${$value};
				//Support_Common::var_dump($value);
				//Support_Common::var_dump(${$value});
			}
			
			//Support_Common::var_dump($arr_return);die();
			
			return $arr_return;
		}
		else{
			return NULL;
		}
		
	}
	  
}
