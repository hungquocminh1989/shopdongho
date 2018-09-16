<?php 

class SiteHeaderModel extends Model {
	
	public function __construct() {
    	
        parent::__construct('m_site_header');

    }
    
    public function selectAllRows_JoinPage(){
		return $this->query(
			"
				SELECT sh.*, sp.page_link FROM m_site_header sh
				INNER JOIN m_site_page sp 
					ON sp.m_site_page_id = sh.m_site_page_id
				WHERE sp.page_type != ".SYSTEM_META_PAGE_DETAIL."
				ORDER BY sh.sort_no, sh.m_site_header_id
			"
		);
	}
    
    public function update_header($postData){
    	
    	$this->begin_transaction();
    	
		/*$db = $this->MedooDb();
		
		$db->begin_transaction();*/
		
		try{
			/*if(isset($postData['m_site_header_id']) == TRUE){
				$db->update('m_site_header',
					[
						'header_name' => $postData['header_name'],
						'display_flg' => 1,
						'm_site_page_id' => $postData['m_site_page_id']
					],
					[
						'm_site_header_id' => $postData['m_site_header_id']
					]
				);
			}
			else{
				$db->insert('m_site_header',
					[
						'header_name' => $postData['header_name'],
						'display_flg' => 1,
						'm_site_page_id' => $postData['m_site_page_id']
					]
				);
			}*/
			
			$this->upsertRow(
	    		[
					'header_name' => $postData['header_name'],
					'display_flg' => 1,
					'm_site_page_id' => $postData['m_site_page_id']
				],
				$postData['m_site_header_id']
	    	);
	    	$this->generateSortNo('m_site_header');
    	
			$this->commit();
			
		} catch (Exception $ex) {
			
			$this->rollback();
			Support_Common::RequestError($ex);
			
		}
		
	}
    
}
