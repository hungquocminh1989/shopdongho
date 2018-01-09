<?php
define('SYSTEM_PUBLIC_DIR', str_replace("\\", '/', __DIR__));
require_once 'flight/Flight.php';
require_once 'app/config/define.php';
require_once 'app/config/config.php';
require_once '/flight/autoload.php';
require_once 'app/controllers/Initialize.php';

//Start Framework
Flight::start();
?>
