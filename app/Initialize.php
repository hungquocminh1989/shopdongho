<?php
session_start();

//Set timezone
date_default_timezone_set(SYSTEM_DEFAULT_TIMEZONE);

//Set path folder template
Flight::set('flight.views.path', 'app/views/');

//Create autoLoad method
Flight::map('autoLoad', function($folderPath){
	$pathModels = getcwd().$folderPath;
    Flight::path($pathModels);
	if ($handle = opendir($pathModels)) {
	    while (false !== ($entry = readdir($handle))) {
	        if ($entry != "." && $entry != "..") {
	            $filename = basename($entry,".php");
	            Flight::register($filename, $filename);
	        }
	    }
	    closedir($handle);
	}
});

//Register class autoload
Flight::autoLoad('/app/models');
Flight::autoLoad('/app/controllers');

//Register Utilities PHP 
//(http://brandonwamboldt.github.io/utilphp/)
Flight::autoLoad('/app/library/Utilities');

//Register Smarty
Smarty_Autoloader::register();

//Register to Flight
Flight::register('viewSmarty', 'SmartyBC', array(), function($smarty){
	$smarty->left_delimiter = SMARTY_LEFT_DELIMITER;
	$smarty->right_delimiter = SMARTY_RIGHT_DELIMITER;
	$smarty->cache_lifetime = SMARTY_CACHE_LIFETIME; 
    $smarty->template_dir = './app/views/';
    $smarty->compile_dir = SYSTEM_TMP_DIR.'/cache/';
    $smarty->cache_dir = SYSTEM_TMP_DIR.'/cache/';
    $smarty->php_handling = $smarty::PHP_ALLOW;//Allow php at template
    //$smarty->config_dir = './config/';
    $smarty->escape_html = TRUE;
});