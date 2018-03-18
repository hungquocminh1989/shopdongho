<?php 

class DefineModel extends BasicModel {
    
    
	
	public function create_define($sql_param){
		$this->begin_transaction();
		try{
			$this->execute("
	    		DELETE FROM m_define
	    	");
	    	
	    	$result = $this->execute("
	    		INSERT INTO m_define (site_name, phone)
			    VALUES (:site_name, :phone);
	    	",$sql_param);
	    	$this->commit();
	    	
		} catch (Exception $ex) {
			$this->rollback();
		}
	}
	
	public function get_define(){
		return $this->query("SELECT * FROM m_define");
	}
    
}
