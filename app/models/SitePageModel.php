<?php 

class SitePageModel extends BasicModel {
	
	public function __construct() {
    	
        parent::__construct('m_site_page');

    }
    
    public function update_page($postData){
		
		$arr_page = array();
		$arr_page_detail = array();
		$m_site_page_id = NULL;
		
		$SitePageContentModel = new SitePageContentModel();
		
    	$db = $this->MedooDb();
    	
		$db->begin_transaction();
		
		try{
			
			
			if(isset($postData['old_id']) == TRUE && $postData['meta_page_type'] == SYSTEM_META_PAGE_DETAIL){#Xu ly ghi de
			
				$m_site_page_id_old = $postData['old_id'];
				
				$db->delete('m_site_page',
					[
						'm_site_page_id' => $m_site_page_id_old
					]
				);
				
				$db->delete('m_site_page_detail',
					[
						'm_site_page_id' => $m_site_page_id_old
					]
				);
			}
		
			if(isset($postData['m_site_page_id']) == TRUE){
				$m_site_page_id = $postData['m_site_page_id'];
			}
			
			$arr_page['page_link'] = $postData['page_link'];
			$arr_page['page_name'] = $postData['page_name'];
			$arr_page['meta_page_type'] = $postData['meta_page_type'];
			//Support_Common::var_dump($postData);die();
			if(isset($postData['meta_type']) == TRUE){
				$dataMeta = array_values($postData['meta_type']);
				foreach($dataMeta as $index => $data){
					foreach($data as $meta_type => $value){
						
						$arr_add = array();
						$arr_add['meta_type'] = $meta_type;
						$arr_add['sort_no'] = $index;
						
						$arr_add['section_title'] = $value['section_title'];
						if($meta_type == SYSTEM_META_SECTION_FREE){//Free Data
							//Insert m_site_page_content
							$db->insert('m_site_page_content',
								[
									'html_data' => $value['html_data']
								]
							);
							$m_site_page_content_id = $db->id();
							$arr_add['meta_id'] = $m_site_page_content_id;
						}
						else{
							$arr_add['meta_id'] = $value['meta_id'];
						}
						
						$arr_page_detail[] = $arr_add;
						
					}
				}
			}
			
			//Check update m_site_page
			$sp_row = $db->select('m_site_page',
				[
					'm_site_page_id' => $m_site_page_id
				]
			);
			$lastInsertId = $m_site_page_id;
			if($sp_row != NULL && count($sp_row) > 0){
				$db->update('m_site_page',$arr_page);
			}
			else{
				$db->insert('m_site_page',$arr_page);
				$lastInsertId = $db->id();
			}
			
			//Delete All m_site_page_detail
			$db->delete('m_site_page_detail',
				[
					'm_site_page_id' => $m_site_page_id
				]
			);
			
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
