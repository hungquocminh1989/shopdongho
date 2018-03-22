<?php
class FileManager
{
	
	public static function CopyFile($source, $destination)
	{
		try{
			$source = FileManager::RepairPath($source);
			$destination = FileManager::RepairPath($destination);
			
			if(file_exists($source) == TRUE){
				FileManager::CreateFolder($destination);
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
			
			$source = FileManager::RepairPath($source);
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
			
			if(FileManager::CopyFile($source, $destination) == TRUE){
				if(FileManager::DeleteFile($source) == TRUE){
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
			
			$source = FileManager::RepairPath($source);
			
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
		$source = FileManager::RepairPath($source);
	}
	
	public static function CopyFolder($source, $destination)
	{
		$source = FileManager::RepairPath($source);
		$destination = FileManager::RepairPath($destination);
	}
	
	public static function DeleteFolder($source)
	{
		$source = FileManager::RepairPath($source);
	}
	
	public static function MoveFolder($source, $destination)
	{
		$source = FileManager::RepairPath($source);
		$destination = FileManager::RepairPath($destination);
	}
	
	public static function FolderExists($source)
	{
		$source = FileManager::RepairPath($source);
	}
	
	public static function FolderList($source)
	{
		$source = FileManager::RepairPath($source);
	}
	
	public static function CreateFolder($source)
	{
		try{
			$source = FileManager::RepairPath($source);
			
			$arr_path = explode("/",$source);
			
			if($arr_path != NULL && count($arr_path) >0 ){
				$path = $arr_path[0];
				foreach($arr_path as $key => $value){
					if($key != 0 && basename($source) != $value){
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
