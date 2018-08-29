<?php

class Controller {
	
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
			if(Support_File::FileExists($file_backup) == TRUE){
				Support_File::CopyFile($file_backup, $folderBackup . "/db_$time.backup");
			}
		}
		Flight::json(array('status' => 'OK'));
		return FALSE;#Stop Route
	}
	
	public static function action_obfuscator()
	{
		$arr_return = array();
		$arr_return = Flight::request()->data->getData();
		Flight::renderSmarty('obfuscator.html',$arr_return);
		return FALSE;//Stop Route
	}
	
	public function checklogin(){
		if(isset($_SESSION["login_token"]) == TRUE && $_SESSION["login_token"] == md5(SYSTEM_PASSCODE)){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function update_sort_no($tablename){
		$model = new Model();
		$post = Flight::request()->data;
		$arr_data = array();
		if($post != NULL && isset($post['arr_sort_id']) == TRUE && isset($post['arr_sort_no']) == TRUE){
			foreach($post['arr_sort_id'] as $key => $value){
				$arr_data[] = [
					'sort_id' => $post['arr_sort_id'][$key], 
					'sort_no' => $post['arr_sort_no'][$key]
				];
			}
			$model->updateSortNo($tablename, $arr_data);
		}
	}
	
}
