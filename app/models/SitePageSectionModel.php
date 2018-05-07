<?php 

class SitePageSectionModel extends BasicModel {
	
	public function __construct() {
    	
        parent::__construct('m_site_page_section');

    }
    
    public function selectAllSectionType($m_site_page_id){
		return $this->query(
		"
			SELECT section_type 
			FROM m_site_page_section
			WHERE m_site_page_id = :m_site_page_id
			GROUP BY section_type 
		"
		,['m_site_page_id' => $m_site_page_id]);
	}
	
	public function selectSectionData($m_site_page_id, $section_type){
		return $this->query(
			"
				SELECT * 
				FROM m_site_page_section ps
				INNER JOIN m_site_page_section_data psd ON ps.m_site_page_section_id = psd.m_site_page_section_id
				WHERE ps.m_site_page_id = :m_site_page_id AND ps.section_type = :section_type
			"
			,
			[
				'm_site_page_id' => $m_site_page_id,
				'section_type' => $section_type
			]
		);
	}
    
}
