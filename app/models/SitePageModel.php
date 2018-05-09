<?php 

class SitePageModel extends BasicModel {
	
	public function __construct() {
    	
        parent::__construct('m_site_page');

    }
    
    public function get_edit_data($m_site_page_id){
		
		$sql = "
			SELECT * 
			FROM m_site_page p 
			INNER JOIN m_site_page_section ps ON p.m_site_page_id = ps.m_site_page_id
			INNER JOIN m_site_page_section_data psd ON ps.m_site_page_section_id = psd.m_site_page_section_id
			WHERE p.m_site_page_id = :m_site_page_id
			ORDER BY ps.sort_no
		";
		
		return $this->query($sql
			,
			[
				'm_site_page_id' => $m_site_page_id
			]
		);
		
	}
    
    public function delete_page_data($m_site_page_id, $db = NULL){
    	
    	$transaction = FALSE;
    	
    	if($db == NULL){
			$db = $this->MedooDb();
			$db->begin_transaction();
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
			
			if(isset($postData['old_id']) == TRUE && $postData['page_type'] == SYSTEM_META_PAGE_DETAIL){#Xu ly ghi de
			
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
			$arr_page['page_type'] = $postData['page_type'];
			
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
			if(isset($postData['section_type']) == TRUE){
				
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
				
				}
				
				$dataMeta = array_values($postData['section_type']);
				
				foreach($dataMeta as $index => $data){
					
					foreach($data as $section_type => $value){
						
						//Insert m_site_page_section
						$arr_section = array();
						$arr_section['m_site_page_id'] = $m_site_page_id;
						$arr_section['sort_no'] = $index;
						$arr_section['section_title'] = $value['section_title'];
						$arr_section['section_type'] = $section_type;
						
						$db->insert('m_site_page_section',$arr_section);
						$m_site_page_section_id = $db->id();
						
						//Insert m_site_page_section_data
						$arr_section_data = array();
						$arr_section_data['m_site_page_section_id'] = $m_site_page_section_id;
						
						if($section_type == SYSTEM_META_SECTION_FREE){//Free Data
							
							$arr_section_data['m_html_data_id'] = $value['m_html_data_id'];
							
						}
						else if($section_type == SYSTEM_META_SECTION_PRODUCT){//Product Data
							
							$arr_section_data['m_product_id'] = $value['m_product_id'];
							
						}
						else if($section_type == SYSTEM_META_SECTION_CATEGORY){//Category Data
							
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
	
}
