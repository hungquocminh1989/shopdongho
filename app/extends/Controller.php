<?php

class Controller {
	
	public static function action_cleansite(){
		
		//Delete all table
		$del_1 = new CategoryModel();
		$del_2 = new HtmlDataModel();
		$del_3 = new ImageModel();
		$del_4 = new ProductModel();
		$del_5 = new SiteHeaderModel();
		$del_6 = new SitePageModel();
		$del_7 = new SitePageSectionModel();
		$del_8 = new SiteSettingModel();
		$del_9 = new CategorySectionModel();
		$del_10 = new ProductSectionModel();
		$del_11 = new HtmlSectionModel();
		$del_12 = new ImageManagerModel();
		
		$del_1->truncateTable();
		$del_2->truncateTable();
		$del_3->truncateTable();
		$del_4->truncateTable();
		$del_5->truncateTable();
		$del_6->truncateTable();
		$del_7->truncateTable();
		$del_8->truncateTable();
		$del_9->truncateTable();
		$del_10->truncateTable();
		$del_11->truncateTable();
		$del_12->truncateTable();
		
		//Delete all data files upload
		if(Support_File::FolderExists(SYSTEM_PUBLIC_UPLOAD) == TRUE){
			Support_File::DeleteFolder(SYSTEM_PUBLIC_UPLOAD);
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
