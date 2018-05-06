<?php
class Support_File
{
	
	public static function CopyFile($source, $destination)
	{
		try{
			$source = Support_File::RepairPath($source);
			$destination = Support_File::RepairPath($destination);
			
			if(file_exists($source) == TRUE){
				Support_File::CreateFolder($destination);
				copy($source,$destination);
				
				return TRUE;
			}
			
			return FALSE;
			
		} catch (Exception $ex) {
			return FALSE;
		}
	}
	
	public static function DeleteFile($source)
	{
		try{
			
			$source = Support_File::RepairPath($source);
			if(file_exists($source) == TRUE){
				unlink($source);
				return TRUE;
			}
			return FALSE;
			
		} catch (Exception $ex) {
			return FALSE;
		}
	}
	
	public static function MoveFile($source, $destination)
	{
		try{
			
			if(Support_File::CopyFile($source, $destination) == TRUE){
				if(Support_File::DeleteFile($source) == TRUE){
					return TRUE;
				}
			}
			return FALSE;
			
		} catch (Exception $ex) {
			return FALSE;
		}
	}
	
	public static function FileExists($source)
	{
		try{
			
			$source = Support_File::RepairPath($source);
			
			if(file_exists($source) == TRUE){
				return TRUE;
			}
			
			return FALSE;
			
		} catch (Exception $ex) {
			return FALSE;
		}
		
	}
	
	public static function FileList($source)
	{
		$source = Support_File::RepairPath($source);
	}
	
	public static function CopyFolder($source, $destination)
	{
		$source = Support_File::RepairPath($source);
		$destination = Support_File::RepairPath($destination);
	}
	
	public static function DeleteFolder($source)
	{
		$source = Support_File::RepairPath($source);
	}
	
	public static function MoveFolder($source, $destination)
	{
		$source = Support_File::RepairPath($source);
		$destination = Support_File::RepairPath($destination);
	}
	
	public static function FolderExists($source)
	{
		$source = Support_File::RepairPath($source);
	}
	
	public static function FolderList($source)
	{
		$source = Support_File::RepairPath($source);
	}
	
	public static function CreateFolder($source)
	{
		try{
			$source = Support_File::RepairPath($source);
			$info = pathinfo($source);
			if(isset($info["extension"]) == TRUE && $info["extension"] != ""){
				$source = $info['dirname'];
			}
			
			$arr_path = explode("/",$source);
			
			if($arr_path != NULL && count($arr_path) >0 ){
				$path = $arr_path[0];
				foreach($arr_path as $key => $value){
					if($key != 0){
						$path = $path."/".$value;
						if(file_exists($path) == FALSE){
							mkdir($path, 0777, TRUE);
						}
					}
				}
			}
			
			return TRUE;
		} catch (Exception $ex) {
			return FALSE;
		}
	}
	
	//===================
	public static function RepairPath($source)
	{
		$source = str_replace("\\", '/', $source);
		$source = str_replace("//", '/', $source);
		return $source;
	}
}
