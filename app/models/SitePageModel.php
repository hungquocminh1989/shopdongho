<?php 

class SitePageModel extends Model {
	
	public function __construct() {
    	
        parent::__construct('m_site_page');

    }
    
    public function get_list_product_selected($m_site_page_id){
		
		$sql = "
			SELECT * 
			FROM m_site_page p
			INNER JOIN m_site_page_section ps 
				ON p.m_site_page_id = ps.m_site_page_id
			INNER JOIN t_product_section tps 
				ON tps.m_site_page_id = ps.m_site_page_id AND tps.m_site_page_section_id = ps.m_site_page_section_id
			WHERE p.m_site_page_id = :m_site_page_id 
				AND ps.section_type = ".SYSTEM_META_SECTION_PRODUCT."
			ORDER BY ps.sort_no
		";
		
		return $this->query($sql
			,
			[
				'm_site_page_id' => $m_site_page_id
			]
		);
		
	}
	
	public function get_list_image_section($m_site_page_id){
		$sql = "
			SELECT * 
			FROM m_site_page p
			INNER JOIN m_site_page_section ps 
				ON p.m_site_page_id = ps.m_site_page_id
			INNER JOIN m_site_page_section_data psd 
				ON ps.m_site_page_section_id = psd.m_site_page_section_id
			INNER JOIN m_group_data gd 
				ON gd.m_group_data_id = psd.m_group_data_id
			INNER JOIN m_group_data_detail gdd 
				ON gd.m_group_data_id = gdd.m_group_data_id
			INNER JOIN m_image im 
				ON im.m_image_id = gdd.m_image_id
			WHERE p.m_site_page_id = :m_site_page_id 
				AND ps.section_type = ".SYSTEM_META_SECTION_IMAGE."
				AND psd.m_group_data_id IS NOT NULL
			ORDER BY gdd.m_group_data_detail_id
		";
		
		return $this->query($sql
			,
			[
				'm_site_page_id' => $m_site_page_id
			]
		);
	}
    
    public function get_edit_page($m_site_page_id){
		
		$sql = "
			SELECT DISTINCT p.*, ps.*, cs.*, hs.*, df.define_key, df.display_value, hd.html_data
			FROM m_site_page p
			INNER JOIN m_site_page_section ps 
				ON p.m_site_page_id = ps.m_site_page_id
			LEFT JOIN t_category_section cs 
				ON cs.m_site_page_id = ps.m_site_page_id AND cs.m_site_page_section_id = ps.m_site_page_section_id
			LEFT JOIN t_product_section tps 
				ON tps.m_site_page_id = ps.m_site_page_id AND tps.m_site_page_section_id = ps.m_site_page_section_id
			LEFT JOIN t_html_section hs 
				ON hs.m_site_page_id = ps.m_site_page_id AND hs.m_site_page_section_id = ps.m_site_page_section_id
			INNER JOIN m_define df 
				ON df.define_key = ps.section_type
			LEFT JOIN m_html_data hd 
				ON hd.m_html_data_id = hs.m_html_data_id
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
	
	public function delete_page($m_site_page_id){
		
		$sql_del = "
			WITH d1 AS (
				DELETE FROM m_site_page
				WHERE m_site_page_id = $m_site_page_id
			)
			,d2 AS (
				DELETE FROM m_site_page_section
				WHERE m_site_page_id = $m_site_page_id
			)
			,d3 AS (
				DELETE FROM t_category_section
				WHERE m_site_page_id = $m_site_page_id
			)
			,d4 AS (
				DELETE FROM t_product_section
				WHERE m_site_page_id = $m_site_page_id
			)
			SELECT 1
		";
		
		$this->execute($sql_del);
		
	}
	
	public function delete_before_update($m_site_page_id){
		
		$sql_del = "
			WITH d1 AS (
				DELETE FROM m_site_page_section
				WHERE m_site_page_id = $m_site_page_id
			)
			,d2 AS (
				DELETE FROM t_category_section
				WHERE m_site_page_id = $m_site_page_id
			)
			,d3 AS (
				DELETE FROM t_product_section
				WHERE m_site_page_id = $m_site_page_id
			)
			SELECT 1
		";
		$this->execute($sql_del);
		
	}
	
	public function update_page($postData){
		
		$this->begin_transaction();
		
		if(isset($postData['old_id']) == TRUE && $postData['page_type'] == SYSTEM_META_PAGE_DETAIL){#Xu ly ghi de
			
			$m_site_page_id_old = $postData['old_id'];
			
			$this->delete_page($m_site_page_id_old);
			
		}
		
		//Start create page
		$m_site_page_id = NULL;
		if(isset($postData['m_site_page_id']) == TRUE && $postData['m_site_page_id'] != ''){
			$m_site_page_id = $postData['m_site_page_id'];
		}
		
		$arr_page['page_link'] = $postData['page_link'];
		$arr_page['page_name'] = $postData['page_name'];
		$arr_page['page_type'] = $postData['page_type'];
		
		//Update m_site_page
		$rowSitePage = $this->upsertRow($arr_page,$m_site_page_id,'m_site_page');	
		$this->generateSortNo('m_site_page');		
		
		if($rowSitePage != FALSE){
			
			$m_site_page_id = $rowSitePage[0]['m_site_page_id'];
			
			if(isset($postData['section_type']) == TRUE){
				
				//Delete all at m_site_page_section, t_category_section, t_product_section
				$this->delete_before_update($m_site_page_id);
			
				$dataMeta = array_values($postData['section_type']);
				
				foreach($dataMeta as $index => $data){
					
					foreach($data as $section_type => $value){
						
						$arr_section = array();
						$arr_section['m_site_page_id'] = $m_site_page_id;
						$arr_section['sort_no'] = $index;
						$arr_section['section_title'] = $value['section_title'];
						$arr_section['section_type'] = $section_type;
						
						//Insert m_site_page_section
						$rowSitePageSection = $this->upsertRow($arr_section,NULL,'m_site_page_section');
						$this->generateSortNo('m_site_page_section');
						
						if($rowSitePageSection != NULL && count($rowSitePageSection) == 1){
							
							$m_site_page_section_id = $rowSitePageSection[0]['m_site_page_section_id'];
							
							if($section_type == SYSTEM_META_SECTION_FREE){//Free Data
								
								$arr_html = array();
								$arr_html['html_name'] = $value['section_title'];
								$arr_html['html_data'] = $value['html_data'];
								$m_html_data_id = NULL;
								
								if(isset($postData['m_html_data_id']) == TRUE && $postData['m_html_data_id'] != ''){
									
									$m_html_data_id = $postData['m_html_data_id'];
									
								}
								
								//Update or Insert t_category_section
								$rowHtml = $this->upsertRow($arr_html,$m_html_data_id,'m_html_data');
								
								if($rowHtml != FALSE){
									$m_html_data_id = $rowHtml[0]['m_html_data_id'];
									
									$arr_html_section['m_site_page_id'] = $m_site_page_id;
									$arr_html_section['m_site_page_section_id'] = $m_site_page_section_id;
									$arr_html_section['m_html_data_id'] = $m_html_data_id;
									
									//Insert t_category_section
									$this->upsertRow($arr_html_section,NULL,'t_html_section');
								
								}
								
							}
							else if($section_type == SYSTEM_META_SECTION_PRODUCT){//Product Data
								
								$arr_ids = $value['m_product_id'];
								
								if($arr_ids != NULL && count($arr_ids) > 0){
									
									foreach($arr_ids as $m_product_id){
										
										$arr_product_section['m_site_page_id'] = $m_site_page_id;
										$arr_product_section['m_site_page_section_id'] = $m_site_page_section_id;
										$arr_product_section['m_product_id'] = $m_product_id;
										
										//Insert t_product_section
										$this->upsertRow($arr_product_section,NULL,'t_product_section');
										
									}
									
								}
								
							}
							else if($section_type == SYSTEM_META_SECTION_CATEGORY){//Category Data
								
								$arr_category_section['m_site_page_id'] = $m_site_page_id;
								$arr_category_section['m_site_page_section_id'] = $m_site_page_section_id;
								$arr_category_section['m_category_id'] = $value['m_category_id'];
								
								//Insert t_category_section
								$this->upsertRow($arr_category_section,NULL,'t_category_section');
								
							}
							else if($section_type == SYSTEM_META_SECTION_IMAGE){//Section Image
								
								/*$arr_image_ids = array();
								
								//Copy image
								$arr_images = Support_Common::copy_multi_file_uploaded('section_image_upload', 'section_images');
								
								//Insert image db
								if($arr_images != NULL && count($arr_images) > 0){
									
									foreach($arr_images as $k => $image){
										$db->insert('m_image'
											,
											[
												'image_type' => SYSTEM_META_SECTION_IMAGE,
												'image_path' => $image,
												'default_flg' => 0
											]
										);
										$arr_image_ids[] = $db->id();
									}
									
								}
								
								if($arr_image_ids != NULL && count($arr_image_ids) > 0){
									
									$db->insert('m_group_data'
										,
										[
											'group_type' => SYSTEM_META_SECTION_IMAGE
										]
									);
									$m_group_data_id = $db->id();
									
									foreach($arr_image_ids as $key => $m_image_id){
										
										$m_site_page_id_select = $value['m_site_page_id'][$key];
										
										$db->insert('m_group_data_detail'
											,
											[
												'm_group_data_id' => $m_group_data_id,
												'm_image_id' => $m_image_id,
												'm_site_page_id' => $m_site_page_id_select
											]
										);
										
									}
									
								}
								$arr_section_data['m_group_data_id'] = $m_group_data_id;
								//Support_Common::RequestError($arr_image_ids);*/
								
							}
							
						}
						
					}
					
				}
				
			}
			
		}			
		
		$this->commit();
		
	}
	
}
