<?php 

class PageHandle extends BasicModel {
    
    public function selectPage_CategoryData($m_category_id){
    	
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
				FROM m_site_page_detail spd
				INNER JOIN m_category mc ON mc.m_category_id = spd.meta_id AND spd.meta_type = ".SYSTEM_META_SECTION_CATEGORY."
				INNER JOIN m_product mp ON mp.m_category_id = mc.m_category_id
				LEFT JOIN m_image im ON im.meta_id = mp.m_product_id AND im.default_flg =1 AND im.meta_type = ".SYSTEM_META_SECTION_PRODUCT."
				WHERE mc.m_category_id = :m_category_id
			"
			,
			[
				'm_category_id' => $m_category_id
			]
		);
		
	}
	
	public function selectPage_FreeHtmlData($m_site_page_detail_id){
    	
		return $this->query(
			"
				SELECT 
					*
				FROM m_site_page_detail spd
				INNER JOIN m_site_page_content c ON c.m_site_page_content_id = spd.meta_id AND spd.meta_type = ".SYSTEM_META_SECTION_FREE."
				WHERE spd.m_site_page_detail_id = :m_site_page_detail_id
			"
			,
			[
				'm_site_page_detail_id' => $m_site_page_detail_id
			]
		);
		
	}
    
}
