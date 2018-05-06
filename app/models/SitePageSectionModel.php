<?php 

class SitePageSectionModel extends BasicModel {
	
	public function __construct() {
    	
        parent::__construct('m_site_page_section');

    }
    
    public function selectAllMetaType($m_site_page_id){
		return $this->query(
		"
			SELECT meta_type 
			FROM m_site_page_section
			WHERE m_site_page_id = :m_site_page_id
			GROUP BY meta_type 
		"
		,['m_site_page_id' => $m_site_page_id]);
	}
    
}
