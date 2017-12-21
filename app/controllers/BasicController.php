<?php
namespace app\controllers;

use Flight; 

class BasicController {

    public static function flight($page, $array = null)
    {
        Flight::render($page, $array);
        return;
    }
    
}
