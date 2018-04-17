<?php 

class ObjectData {
    protected $arr_data;
    
    public function __construct() {
    	$this->arr_data = array();

    }
    
    public function appendData($obj_data){
    	foreach($obj_data as $key => $value){
			$this->arr_data[] = $value;
		}
	}
	
	public function export(){
		
		if($this->arr_data != NULL && count($this->arr_data) > 0){
			$arr_return = array();
			$arr_name = array();
			
			foreach($this->arr_data as $key => $value){
				
				$type = $value['meta_type'];
				$id = $value['m_site_page_detail_id'];
				$sort_no = $value['sort_no'];
				$name = "arr_".$type."_".$id."_".$sort_no;
				
				if(in_array($name,$arr_name)=== FALSE){
					$arr_name[] = $name;
				}
				
				
				if($type == 4){
					${$name}['type'] = $type;
					${$name}['title'] = $value['category_name'];
					${$name}['data'][0] = $value;
				}
				else if($type == 1){
					${$name}['type'] = $type;
					${$name}['title'] = $value['product_name'];
					${$name}['data'][0] = $value;
				}
				
			}
			
			$arr_name = sort($arr_name);
			
			foreach($arr_name as $key => $value){
				$arr_return[] = ${$value};
			}
			
			
			return $arr_return;
		}
		else{
			return NULL;
		}
		
	}
	  
}
