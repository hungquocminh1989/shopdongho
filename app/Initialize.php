<?php
session_start();

//Set timezone
date_default_timezone_set(SYSTEM_DEFAULT_TIMEZONE);

//Set path folder template
Flight::set('flight.views.path', 'app/views/');

//Register Folder Models Autoload
$pathModels = getcwd().'/app/models';
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

//Register Folder Controllers Autoload
$pathControllers = getcwd().'/app/controllers';
Flight::path($pathControllers);
if ($handle = opendir($pathControllers)) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            $filename = basename($entry,".php");
            Flight::register($filename, $filename);
        }
    }
    closedir($handle);
}

//Register Smarty
Smarty_Autoloader::register();

//Register to Flight
Flight::register('viewSmarty', 'SmartyBC', array(), function($smarty){
	$smarty->left_delimiter = SMARTY_LEFT_DELIMITER;
	$smarty->right_delimiter = SMARTY_RIGHT_DELIMITER;
	$smarty->cache_lifetime = SMARTY_CACHE_LIFETIME; 
    $smarty->template_dir = './app/views/';
    $smarty->compile_dir = './cache/';
    $smarty->cache_dir = './cache/';
    $smarty->php_handling = $smarty::PHP_ALLOW;//Allow php at template
    //$smarty->config_dir = './config/';
    $smarty->escape_html = TRUE;
});