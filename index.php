<?php
require 'flight/Flight.php';
require 'app/config/define.php';
require 'app/config/config.php';
require_once __DIR__.'/flight/autoload.php';

new app\controllers\Initialize();

Flight::start();
?>
