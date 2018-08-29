<?php
class Support_File
{
	
	public static function CopyFile($source, $destination)
	{
		try{
			$source = self::RepairPath($source);
			$destination = self::RepairPath($destination);
			
			if(self::FileExists($source) == TRUE){
				self::CreateFolder($destination);
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
			
			$source = self::RepairPath($source);
			if(self::FileExists($source) == TRUE){
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
			
			if(self::CopyFile($source, $destination) == TRUE){
				if(self::DeleteFile($source) == TRUE){
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
			
			$source = self::RepairPath($source);
			
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
		$source = self::RepairPath($source);
	}
	
	public static function CopyFolder($source, $destination)
	{
		try{
			$source = self::RepairPath($source);
			$destination = self::RepairPath($destination);
			Support_Directory::copy($source,$destination);
			return TRUE;
		} catch (Exception $ex) {
			return FALSE;
		}
	}
	
	public static function DeleteFolder($source)
	{
		$source = self::RepairPath($source);
	}
	
	public static function MoveFolder($source, $destination)
	{
		try{
			$source = self::RepairPath($source);
			$destination = self::RepairPath($destination);
			$status = Support_Directory::copy($source,$destination);
			if($status != NULL && $status == TRUE){
				//self::DeleteFolder($source);
			}
		} catch (Exception $ex) {
			return FALSE;
		}
	}
	
	public static function FolderExists($source)
	{
		$source = self::RepairPath($source);
	}
	
	public static function FolderList($source)
	{
		$source = self::RepairPath($source);
	}
	
	public static function CreateFolder($source)
	{
		try{
			$source = self::RepairPath($source);
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
		if(strpos($source,'\\') !== FALSE || strpos($source,'//') !== FALSE){
			do{
		$source = str_replace("\\", '/', $source);
		$source = str_replace("//", '/', $source);
			} while(strpos($source,'\\') !== FALSE || strpos($source,'//') !== FALSE);
		}
		
		return $source;
	}
}
