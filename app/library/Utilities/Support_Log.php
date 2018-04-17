<?php
class Support_Log
{	

	//In Windows, you'll include the GD2 DLL php_gd2.dll as an extension in php.ini.
	//http://php.net/manual/en/image.installation.php
	public static function Log($refix, $contents)
	{
		Support_File::CreateFolder(SYSTEM_TMP_DIR.'/log');
		
		$filename = SYSTEM_TMP_DIR.'/log/'.Date('Y-m-d').'_'.$refix.'.log';
		$ip = Support_Common::get_client_ip();
		$url = Support_Common::get_current_url();
		
		$contents = "\r\n【".Date('Y-m-d H:i:s')."】 Access from $ip - $url"."\r\n".var_export($contents,TRUE);
		file_put_contents($filename, $contents, FILE_APPEND);
		return;
	}
	
}
