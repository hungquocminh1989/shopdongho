<?php
//Create renderSmarty method
Flight::map('renderSmarty', function($template, $data = NULL){
    if (is_null($data) == false) {
		Flight::viewSmarty()->assign($data);
	}
    Flight::viewSmarty()->display($template.'.html');
});

//Create smartyVars method (get smarty variable)
Flight::map('smartyVars', function($keyName = NULL){
    if (is_null($keyName) == false) {
		return Flight::viewSmarty()->get_template_vars($keyName);
	}
	else{
		return Flight::viewSmarty()->get_template_vars();
	}
});

//Create compress method (compress image)
//In Windows, you'll include the GD2 DLL php_gd2.dll as an extension in php.ini.
//http://php.net/manual/en/image.installation.php
Flight::map('imageCompress', function($source, $destination, $quality = 90){
	
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
});

//Override Flight's default error method
/*Flight::map('error', function(Exception $ex){
    // Handle error
    $request = Flight::request();
    echo '<pre>';
    var_dump($ex->getTraceAsString());
    var_dump($request);
});*/