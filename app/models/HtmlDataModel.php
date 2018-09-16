<?php 

class HtmlDataModel extends Model {
	
	public function __construct() {
    	
        parent::__construct('m_html_data');

    }
    
    public function update_html($arr_row, $m_html_data_id){
    	$this->begin_transaction();
		$this->upsertRow($arr_row,$m_html_data_id);
		$this->generateSortNo('m_html_data');
		$this->commit();
	}
    
}
