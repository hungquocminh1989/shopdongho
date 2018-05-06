<?php 

class SitePageModel extends BasicModel {
	
	public function __construct() {
    	
        parent::__construct('m_site_page');

    }
    
    public function delete_page_data($m_site_page_id, $db = NULL){
    	
    	$transaction = FALSE;
    	
    	if($db == NULL){
			$db = $this->MedooDb();
			$transaction = TRUE;
		}
		
		try{
			
			$rows_section = $db->select('m_site_page_section','*',
				[
					'm_site_page_id' => $m_site_page_id
				]
			);
			
			if($rows_section != NULL && count($rows_section) > 0){
				foreach($rows_section as $value){
					$db->delete('m_site_page_section_data',
						[
							'm_site_page_section_id' => $value['m_site_page_section_id']
						]
					);
				}
			}
			
			$db->delete('m_site_page',
				[
					'm_site_page_id' => $m_site_page_id
				]
			);
			
			$db->delete('m_site_page_section',
				[
					'm_site_page_id' => $m_site_page_id
				]
			);
			
			if($transaction == TRUE){
				$db->commit();
			}
			
			return $db;
			
		} catch (Exception $ex) {
			
			if($transaction == TRUE){
				$db->rollback();
			}
			
		}
		
	}
    
    public function update_page($postData){
		
		$arr_page = array();
		$arr_page_section = array();
		$m_site_page_id = NULL;
		
		$db = $this->MedooDb();
		
		$db->begin_transaction();
		
		try{
			
			if(isset($postData['old_id']) == TRUE && $postData['meta_page_type'] == SYSTEM_META_PAGE_DETAIL){#Xu ly ghi de
			
				$m_site_page_id_old = $postData['old_id'];
				
				$db = $this->delete_page_data($m_site_page_id_old, $db);
				
			}
			
			//Start create page
			if(isset($postData['m_site_page_id']) == TRUE){
				$m_site_page_id = $postData['m_site_page_id'];
			}
			
			//m_site_page
			$arr_page['page_link'] = $postData['page_link'];
			$arr_page['page_name'] = $postData['page_name'];
			$arr_page['meta_page_type'] = $postData['meta_page_type'];
			
			if($m_site_page_id != NULL){
				
				//Update
				$db->update('m_site_page',$arr_page);
				
			}
			else{
				
				//Add new
				$db->insert('m_site_page',$arr_page);
				$m_site_page_id = $db->id();
				
			}
			
			//luon luon delete va insert lai m_site_page_section + m_site_page_section_data
			if(isset($postData['meta_type']) == TRUE){
				
				//delete 
				if($m_site_page_id != NULL){
				
					$rows_section = $db->select('m_site_page_section','*',
						[
							'm_site_page_id' => $m_site_page_id
						]
					);
					
					if($rows_section != NULL && count($rows_section) > 0){
						foreach($rows_section as $value){
							$db->delete('m_site_page_section_data',
								[
									'm_site_page_section_id' => $value['m_site_page_section_id']
								]
							);
						}
					}
					
					$db->delete('m_site_page_section',
						[
							'm_site_page_id' => $m_site_page_id
						]
					);
					$log = $db->log();
						$error = $db->error();
						$last = $db->last();
				
				}
				
				$dataMeta = array_values($postData['meta_type']);
				
				foreach($dataMeta as $index => $data){
					
					foreach($data as $meta_type => $value){
						
						//Insert m_site_page_section
						$arr_section = array();
						$arr_section['m_site_page_id'] = $m_site_page_id;
						$arr_section['sort_no'] = $index;
						$arr_section['section_title'] = $value['section_title'];
						$arr_section['section_type'] = $meta_type;
						
						$db->insert('m_site_page_section',$arr_section);
						$log = $db->log();
						$error = $db->error();
						$last = $db->last();
						$m_site_page_section_id = $db->id();
						
						//Insert m_site_page_section_data
						$arr_section_data = array();
						$arr_section_data['m_site_page_section_id'] = $m_site_page_section_id;
						
						if($meta_type == SYSTEM_META_SECTION_FREE){//Free Data
							
							$arr_section_data['m_html_data_id'] = $value['m_html_data_id'];
							
						}
						else if($meta_type == SYSTEM_META_SECTION_PRODUCT){//Product Data
							
							$arr_section_data['m_product_id'] = $value['m_product_id'];
							
						}
						else if($meta_type == SYSTEM_META_SECTION_CATEGORY){//Category Data
							
							$arr_section_data['m_category_id'] = $value['m_category_id'];
							
						}
						
						$db->insert('m_site_page_section_data',$arr_section_data);
						
					}
					
				}
				
			}
			
			$db->commit();
			
		} 
		catch (Exception $ex) {
			$db->rollback();
			return FALSE;
		}
		
	}
    
    /*public function update_page($postData){
		
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
				
				$db->delete('m_site_page_section',
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
			
			//Delete All m_site_page_section
			$db->delete('m_site_page_section',
				[
					'm_site_page_id' => $m_site_page_id
				]
			);
			
			foreach($arr_page_detail as $value){
				$value['m_site_page_id'] = $lastInsertId;
				$db->insert('m_site_page_section',$value);
			}
			$db->commit();
			
		} catch (Exception $ex) {
			$db->rollback();
			return FALSE;
		}
		
	} */
}
