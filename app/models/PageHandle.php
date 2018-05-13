<?php 

class PageHandle extends BasicModel {
    
    public function selectPage_CategoryData($m_site_page_id, $m_category_id, $page_type){
    	
		return $this->query(
			"
				SELECT 
					spd.*,
					mp.m_product_id,
		    		mc.category_name,
		    		mc.m_category_id,
		    		mp.product_name,
		    		mp.product_no,
		    		mp.product_price,
		    		mp.product_price_sale,
		    		mp.flg_notify,
		    		mp.msg_notify,
		    		mp.product_info,
		    		mp.product_link,
		    		im.image_path
				FROM m_site_page p
				INNER JOIN m_site_page_section spd ON p.m_site_page_id = spd.m_site_page_id
				INNER JOIN m_site_page_section_data spdd ON spd.m_site_page_section_id = spdd.m_site_page_section_id
				INNER JOIN m_category mc ON mc.m_category_id = spdd.m_category_id
				INNER JOIN m_product mp ON mp.m_category_id = mc.m_category_id
				LEFT JOIN m_image im ON im.m_product_id = mp.m_product_id AND im.default_flg =1 AND im.image_type = ".SYSTEM_META_SECTION_PRODUCT."
				WHERE mc.m_category_id = :m_category_id AND p.page_type = ".$page_type." AND p.m_site_page_id = :m_site_page_id
			"
			,
			[
				'm_category_id' => $m_category_id,
				'm_site_page_id' => $m_site_page_id
			]
		);
		
	}
	
	public function selectPage_FreeHtmlData($m_site_page_id, $m_html_data_id){
    	
		return $this->query(
			"
				SELECT 
					*
				FROM m_site_page p
				INNER JOIN m_site_page_section spd ON p.m_site_page_id = spd.m_site_page_id
				INNER JOIN m_site_page_section_data spdd ON spd.m_site_page_section_id = spdd.m_site_page_section_id AND spd.section_type = ".SYSTEM_META_SECTION_FREE."
				INNER JOIN m_html_data hd ON hd.m_html_data_id = spdd.m_html_data_id 
				WHERE hd.m_html_data_id = :m_html_data_id AND p.m_site_page_id = :m_site_page_id
			"
			,
			[
				'm_html_data_id' => $m_html_data_id,
				'm_site_page_id' => $m_site_page_id
			]
		);
		
	}
    
}
