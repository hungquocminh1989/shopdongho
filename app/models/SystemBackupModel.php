<?php 

class SystemBackupModel extends Model {
	
	function __construct() {
		
        parent::__construct ('m_system_backup');

    }
    
    public function delete_backup($m_system_backup_id){
    	$this->begin_transaction();
		$sql_del ="
			DELETE FROM m_system_backup
			WHERE m_system_backup_id = $m_system_backup_id
			RETURNING database_path, datafiles_path
		";
		$result = $this->query($sql_del);
		if($result != NULL && count($result) > 0){
			foreach($result as $key => $value){
				Support_File::DeleteFile($value['database_path']);
				Support_File::DeleteFolder($value['datafiles_path']);
			}
		}
		$this->commit();
	}
	
	public function create_system_backup($arr_row){
		$this->begin_transaction();
		$this->upsertRow($arr_row);
		$this->commit();
	}
    
}
