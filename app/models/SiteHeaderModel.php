<?php 

class SiteHeaderModel extends BasicModel {
	
	public function __construct() {
    	
        parent::__construct('m_site_header');

    }
    
    public function selectAllRows_JoinPage(){
		return $this->query(
			"
				SELECT * FROM m_site_header sh
				INNER JOIN m_site_page sp ON sp.m_site_page_id = sh.m_site_page_id
				ORDER BY sort_no, m_site_header_id
			"
		);
	}
    
    public function update_header($postData){
    	
		$db = $this->MedooDb();
		
		$db->begin_transaction();
		
		try{
			if(isset($postData['m_site_header_id']) == TRUE){
				$db->update('m_site_header',
					[
						'menu_name' => $postData['menu_name'],
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
						'menu_name' => $postData['menu_name'],
						'display_flg' => 1,
						'm_site_page_id' => $postData['m_site_page_id']
					]
				);
			}
			
			$db->commit();
			
		} catch (Exception $ex) {
			
			$db->rollback();
			return FALSE;
			
		}
		
	}
    
}
