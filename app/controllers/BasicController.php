<?php

class BasicController {
	
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
	
	public function copy_file_uploaded($name, $folderRoot, $compress = FALSE){
		
		if(isset($_FILES[$name]) == TRUE){
			
			$countFile = count($_FILES[$name]['type']);
			
			if($countFile > 0 && $_FILES[$name]['type'][0] != ''){
				$file_src = $_FILES[$name]['tmp_name'];
				$filename = uniqid().'_'.$_FILES[$name]['name'];
				$folder_dest = SYSTEM_PUBLIC_UPLOAD.'/'.$folderRoot;
				$file_dest = $folder_dest.'/'.$filename;
				
				Support_File::CopyFile($file_src,$file_dest);
				
				//Nén hình
				if($compress == TRUE){
					Support_Image::imageCompress($file_dest,$file_dest);
				}
				return 'public/upload/'.$folderRoot.'/'.$filename;
			}
			
		}
		
		return NULL;
	}
	
	public function copy_multi_file_uploaded($name, $folderRoot, $compress = FALSE){
		
		if(isset($_FILES[$name]) == TRUE){
		
			$arr_images = array();
			$countFile = count($_FILES[$name]['type']);
			if($countFile > 0 && $_FILES[$name]['type'][0] != ''){
				for($i = 0; $i < $countFile; $i++){
					$file_src = $_FILES[$name]['tmp_name'][$i];
					$filename = uniqid().'_'.$_FILES[$name]['name'][$i];
					$folder_dest = SYSTEM_PUBLIC_UPLOAD.'/'.$folderRoot;
					$file_dest = $folder_dest.'/'.$filename;
					
					Support_File::CopyFile($file_src,$file_dest);
					
					//Nén hình
					if($compress == TRUE){
						Support_Image::imageCompress($file_dest,$file_dest);
					}
					
					$arr_images[] = 'public/upload/'.$folderRoot.'/'.$filename;
				}
				return $arr_images;
			}
		
		}
		
		return NULL;
	}
	
}
