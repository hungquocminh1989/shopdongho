<?php 

class PageHandle extends BasicModel {
	
	private $arr_sql = array();
	private $arr_sql_param = array();
	
	public function appendSql($sql,$arr){
		
		$sql = "
		
		".$sql."
		
		";
		
		//Generate index param
		$index = count($this->arr_sql_param) +1;
		foreach($arr as $key => $value){
			$col_org = ':'.$key;
			$col_generate = ':'.$key.'_'.$index;
			
			$this->arr_sql_param[$col_generate] = $value;
			$sql = str_replace($col_org,$col_generate,$sql);
		}		
		
		//Add sql
		$this->arr_sql[] = $sql;
	}
	
	public function getPageData(){
		$sql = implode(" UNION ", $this->arr_sql);
		return $this->query($sql,$this->arr_sql_param);
	}
	
    public function selectPage_CategoryData($m_site_page_section_id, $m_category_id, $page_type){
    	
		$this->appendSql(
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
				WHERE mc.m_category_id = :m_category_id AND p.page_type = ".$page_type." AND spdd.m_site_page_section_id = :m_site_page_section_id
			"
			,
			[
				'm_category_id' => $m_category_id,
				'm_site_page_section_id' => $m_site_page_section_id
			]
		);
		
	}
	
	public function selectPage_ProductData($m_site_page_section_id, $m_group_data_id, $page_type){
    	
		$this->appendSql(
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
				INNER JOIN m_group_data gr ON gr.m_group_data_id = spdd.m_group_data_id AND gr.group_type = ".SYSTEM_META_SECTION_PRODUCT."
				INNER JOIN m_group_data_detail grd ON grd.m_group_data_id = gr.m_group_data_id
				INNER JOIN m_product mp ON mp.m_product_id = grd.m_product_id
				INNER JOIN m_category mc ON mc.m_category_id = mp.m_category_id
				LEFT JOIN m_image im ON im.m_product_id = mp.m_product_id AND im.default_flg =1 AND im.image_type = ".SYSTEM_META_SECTION_PRODUCT."
				WHERE gr.m_group_data_id = :m_group_data_id AND p.page_type = ".$page_type." AND spdd.m_site_page_section_id = :m_site_page_section_id
			"
			,
			[
				'm_group_data_id' => $m_group_data_id,
				'm_site_page_section_id' => $m_site_page_section_id
			]
		);
		
	}
	
	public function selectPage_FreeHtmlData($m_site_page_section_id, $m_html_data_id){
    	
		$this->appendSql(
			"
				SELECT 
					*
				FROM m_site_page p
				INNER JOIN m_site_page_section spd ON p.m_site_page_id = spd.m_site_page_id
				INNER JOIN m_site_page_section_data spdd ON spd.m_site_page_section_id = spdd.m_site_page_section_id AND spd.section_type = ".SYSTEM_META_SECTION_FREE."
				INNER JOIN m_html_data hd ON hd.m_html_data_id = spdd.m_html_data_id 
				WHERE hd.m_html_data_id = :m_html_data_id AND spdd.m_site_page_section_id = :m_site_page_section_id
			"
			,
			[
				'm_html_data_id' => $m_html_data_id,
				'm_site_page_section_id' => $m_site_page_section_id
			]
		);
		
	}
	
	public function selectPage_ImageSectionData($m_site_page_section_id, $m_group_data_id){
    	
		$this->appendSql(
			"
				SELECT 
					*
				FROM m_site_page p
				INNER JOIN m_site_page_section spd ON p.m_site_page_id = spd.m_site_page_id
				INNER JOIN m_site_page_section_data spdd ON spd.m_site_page_section_id = spdd.m_site_page_section_id AND spd.section_type = ".SYSTEM_META_SECTION_IMAGE."
				INNER JOIN m_group_data g ON g.m_group_data_id = spdd.m_group_data_id 
				INNER JOIN m_group_data_detail gd ON g.m_group_data_id = gd.m_group_data_id
				INNER JOIN m_image im ON im.m_image_id = gd.m_image_id
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
