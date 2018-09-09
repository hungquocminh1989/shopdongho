<?php

class SystemBackupController extends Controller {
	
	public static function action_deletebackup()
	{
		$model = new SystemBackupModel();
		$model->delete_backup($_POST['m_system_backup_id']);
		Flight::json(array('status' => 'OK'));
	}
	
	public static function action_backupsite(){
		//Create folder backup
		$time = date("YmdHis");
		$folderBackup = SYSTEM_TMP_DIR."/site_backup_$time";
		$folderImagesUpload = "$folderBackup/public/upload";
		if(Support_File::CreateFolder($folderImagesUpload) == TRUE){
			//Copy data file uploaded
			Support_File::CopyFolder(SYSTEM_PUBLIC_UPLOAD, $folderImagesUpload);
			
			//Backup database
			$file_backup = Flight::postgresSqlBackup();
			$file_backup_copy = $folderBackup . "/db_$time.backup";
			if(Support_File::FileExists($file_backup) == TRUE){
				if(Support_File::CopyFile($file_backup, $file_backup_copy) == TRUE){
					Support_File::DeleteFile($file_backup);
				}
			}
			
			//Insert m_system_backup
			$system_backup_name = $time;
			if(isset($_POST['system_backup_name'])== TRUE && $_POST['system_backup_name'] != ''){
				$system_backup_name = $_POST['system_backup_name'] . '_' . $time;
			}
			$model = new SystemBackupModel();
			$model->upsertRow(
				[
					'system_backup_name'=> $system_backup_name,
					'database_path'=> $file_backup_copy,
					'datafiles_path'=> $folderImagesUpload
				]
			);
			
		}
		
		Flight::json(array('status' => 'OK'));
		return FALSE;#Stop Route
	}
	
}
