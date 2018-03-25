<?php 

class DefineModel extends BasicModel {
    
    
	
	public function create_define($sql_param){
		
		$db = $this->MedooDb();
		$db->begin_transaction();
		
		try{
			$data = $db->query("
				SELECT * FROM m_define LIMIT 1;
			")->fetchAll();
			
			if($data != NULL && count($data) > 0 ){
				$db->update('m_define',$sql_param,['m_define_id'=>$data[0]['m_define_id']]);
			}
			else{
				$db->insert('m_define',$sql_param);
			}
			$db->commit();
		} catch (Exception $ex) {
			$db->rollback();
		}
	}
	
	public function get_define(){
		return $this->query("SELECT * FROM m_define");
	}
    
}
