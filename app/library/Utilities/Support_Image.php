<?php
class Support_Image
{	

	//In Windows, you'll include the GD2 DLL php_gd2.dll as an extension in php.ini.
	//http://php.net/manual/en/image.installation.php
	public static function imageCompress($source, $destination, $quality = 90)
	{
		$info = getimagesize($source);

		if ($info['mime'] == 'image/jpeg'){
			$image = imagecreatefromjpeg($source);
		}
		elseif ($info['mime'] == 'image/gif'){
			$image = imagecreatefromgif($source);
		}
		elseif ($info['mime'] == 'image/png'){
			$image = imagecreatefrompng($source);
		}	

		imagejpeg($image, $destination, $quality);

		return $destination;
	}
	
}
