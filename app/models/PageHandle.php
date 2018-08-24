<?php 

class PageHandle extends Model {
	
    public function selectPage_CategoryData($m_site_page_section_id, $page_type){
    	
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
				INNER JOIN m_site_page_section spd 
					ON p.m_site_page_id = spd.m_site_page_id
				INNER JOIN t_category_section cs 
					ON cs.m_site_page_id = spd.m_site_page_id AND cs.m_site_page_section_id = spd.m_site_page_section_id
				INNER JOIN m_category mc 
					ON mc.m_category_id = cs.m_category_id
				INNER JOIN m_product mp 
					ON mp.m_category_id = mc.m_category_id
				LEFT JOIN t_image_manager ig 
					ON ig.m_product_id = mp.m_product_id AND ig.default_flg =1
				LEFT JOIN m_image im 
					ON im.m_image_id = ig.m_image_id
				WHERE p.page_type = :page_type AND cs.m_site_page_section_id = :m_site_page_section_id
			"
			,
			[
				'm_site_page_section_id' => $m_site_page_section_id,
				'page_type'=> $page_type
			]
		);
		
	}
	
	public function selectPage_ProductData($m_site_page_section_id, $page_type){
    	
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
				INNER JOIN m_site_page_section spd 
					ON p.m_site_page_id = spd.m_site_page_id
				INNER JOIN t_product_section ps 
					ON ps.m_site_page_id = spd.m_site_page_id AND ps.m_site_page_section_id = spd.m_site_page_section_id
				INNER JOIN m_product mp 
					ON mp.m_product_id = ps.m_product_id
				INNER JOIN m_category mc 
					ON mc.m_category_id = mp.m_category_id
				LEFT JOIN t_image_manager ig 
					ON ig.m_product_id = mp.m_product_id AND ig.default_flg =1
				LEFT JOIN m_image im 
					ON im.m_image_id = ig.m_image_id
				WHERE p.page_type = :page_type AND ps.m_site_page_section_id = :m_site_page_section_id
			"
			,
			[
				'm_site_page_section_id' => $m_site_page_section_id,
				'page_type'=> $page_type
			]
		);
		
	}
	
	public function selectPage_FreeHtmlData($m_site_page_section_id, $page_type){
    	
		return $this->query(
			"
				SELECT 
					*
				FROM m_site_page p
				INNER JOIN m_site_page_section spd 
					ON p.m_site_page_id = spd.m_site_page_id
				INNER JOIN t_html_section hs 
					ON hs.m_site_page_id = spd.m_site_page_id AND hs.m_site_page_section_id = spd.m_site_page_section_id
				INNER JOIN m_html_data hd 
					ON hd.m_html_data_id = hs.m_html_data_id 
				WHERE spd.section_type = ".SYSTEM_META_SECTION_FREE."
					AND spd.m_site_page_section_id = :m_site_page_section_id
			"
			,
			[
				'm_site_page_section_id' => $m_site_page_section_id,
				'page_type'=> $page_type
			]
		);
		
	}
	
	public function selectPage_ImageSectionData($m_site_page_section_id, $m_group_data_id){
    	
		return $this->query(
			"
				SELECT 
					*
				FROM m_site_page p
				INNER JOIN m_site_page_section spd 
					ON p.m_site_page_id = spd.m_site_page_id
				INNER JOIN m_site_page_section_data spdd 
					ON spd.m_site_page_section_id = spdd.m_site_page_section_id AND spd.section_type = ".SYSTEM_META_SECTION_IMAGE."
				INNER JOIN m_group_data g 
					ON g.m_group_data_id = spdd.m_group_data_id 
				INNER JOIN m_group_data_detail gd 
					ON g.m_group_data_id = gd.m_group_data_id
				INNER JOIN m_image im 
					ON im.m_image_id = gd.m_image_id
				WHERE g.m_group_data_id = :m_group_data_id 
					AND spdd.m_site_page_section_id = :m_site_page_section_id
					AND g.group_type = ".SYSTEM_META_SECTION_IMAGE."
			"
			,
			[
				'm_group_data_id' => $m_group_data_id,
				'm_site_page_section_id' => $m_site_page_section_id
			]
		);
		
	}
    
}
