<?php 

class SitePageModel extends BasicModel {
	
	public function __construct() {
    	
        parent::__construct('m_site_page');

    }
    
    public function update_page($postData){
		
		$arr_page = array();
		$arr_page_detail = array();
		$m_site_page_id = NULL;
		
		$SiteContentModel = new SiteContentModel();
		
    	$db = $this->MedooDb();
    	
		$db->begin_transaction();
		
		try{
		
			if(isset($postData['m_site_page_id']) == TRUE){
				$m_site_page_id = $postData['m_site_page_id'];
			}
			
			$arr_page['page_link'] = $postData['page_link'];
			$arr_page['page_name'] = $postData['page_name'];
			//Support_Common::var_dump($postData);die();
			if(isset($postData['meta_type']) == TRUE){
				$dataMeta = array_values($postData['meta_type']);
				foreach($dataMeta as $index => $data){
					foreach($data as $meta_type => $value){
						
						$arr_add = array();
						$arr_add['meta_type'] = $meta_type;
						$arr_add['sort_no'] = $index;
						
						$arr_add['section_title'] = $value['section_title'];
						if($meta_type == SYSTEM_META_FREE_SECTION){//Free Data
							//Insert m_site_content
							$db->insert('m_site_content',
								[
									'html_data' => $value['html_data']
								]
							);
							$m_site_content_id = $db->id();
							$arr_add['meta_id'] = $m_site_content_id;
						}
						else{
							$arr_add['meta_id'] = $value['meta_id'];
						}
						
						$arr_page_detail[] = $arr_add;
						
					}
				}
			}
			
			//Delete All
			$db->delete('m_site_page',
				[
					'm_site_page_id' => $m_site_page_id
				]
			);
			
			$db->delete('m_site_page_detail',
				[
					'm_site_page_id' => $m_site_page_id
				]
			);
			
			//Insert All
			$db->insert('m_site_page',$arr_page);
			$lastInsertId = $db->id();
			
			foreach($arr_page_detail as $value){
				$value['m_site_page_id'] = $lastInsertId;
				$db->insert('m_site_page_detail',$value);
			}
			$db->commit();
			
		} catch (Exception $ex) {
			$db->rollback();
			return FALSE;
		}
		
	} 
}
