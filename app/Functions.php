<?php
//Create renderSmarty method
Flight::map('renderSmarty', function($template, $data = NULL){
    if (is_null($data) == false) {
		Flight::viewSmarty()->assign($data);
	}
    Flight::viewSmarty()->display($template.'.html');
});

//Override Flight's default error method
/*Flight::map('error', function(Exception $ex){
    // Handle error
    $request = Flight::request();
    echo '<pre>';
    var_dump($ex->getTraceAsString());
    var_dump($request);
});*/