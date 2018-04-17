<?php
//Create renderSmarty method
Flight::map('renderSmarty', function($template, $data = NULL){
    if (is_null($data) == false) {
		Flight::viewSmarty()->assign($data);
	}
    Flight::viewSmarty()->display($template);
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

//Create obfuscator javascript method
Flight::map('javascript_obfuscator', function($file, $param = array()){
	
	$param['file'] = $file;
	
    // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, SYSTEM_BASE_URL."javascript-obfuscator");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($param));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
	//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	
	//Pass SSL Check
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

	$headers = array();
	$headers[] = "Accept-Encoding: gzip, deflate";
	$headers[] = "Accept-Language: en,vi;q=0.9,ja;q=0.8,en-US;q=0.7";
	$headers[] = "Upgrade-Insecure-Requests: 1";
	$headers[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.167 Safari/537.36";
	$headers[] = "Content-Type: application/json";
	$headers[] = "Accept: application/json";
	$headers[] = "Cache-Control: max-age=0";
	$headers[] = "Connection: keep-alive";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
	    echo 'Error:' . curl_error($ch);
	}
	curl_close ($ch);
	
	if($result != NULL && $result != ''){
		if(SYSTEM_JS_ENCRYTION == TRUE){
    		$arr_data = json_decode('{"code":"tmp_code","options":{"compact":true,"selfDefending":true,"disableConsoleOutput":false,"debugProtection":false,"debugProtectionInterval":false,"stringArray":true,"rotateStringArray":true,"rotateStringArrayEnabled":true,"stringArrayThreshold":0.8,"stringArrayThresholdEnabled":true,"stringArrayEncoding":"false","stringArrayEncodingEnabled":true,"sourceMap":false,"sourceMapMode":"off","sourceMapBaseUrl":"","sourceMapFileName":"","sourceMapSeparate":false,"domainLock":[],"reservedNames":[],"seed":0,"controlFlowFlatteningThreshold":0.75,"controlFlowFlattening":true,"deadCodeInjectionThreshold":0.4,"deadCodeInjection":true,"unicodeEscapeSequence":true,"renameGlobals":true,"target":"browser","identifierNamesGenerator":"hexadecimal"}}',true);
    		//Reasign data
    		$arr_data['code'] = $result;
    		
    		// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL, "https://javascriptobfuscator.herokuapp.com/obfuscate");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arr_data));
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
			
			//Pass SSL Check
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

			$headers = array();
			$headers[] = "Origin: https://javascriptobfuscator.herokuapp.com";
			$headers[] = "Accept-Encoding: gzip, deflate, br";
			$headers[] = "Accept-Language: en,vi;q=0.9,ja;q=0.8,en-US;q=0.7";
			$headers[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36";
			$headers[] = "Content-Type: application/json";
			$headers[] = "Accept: application/json";
			$headers[] = "Referer: https://javascriptobfuscator.herokuapp.com/";
			$headers[] = "Cookie: _ga=GA1.3.67722951.1518159428; _gid=GA1.3.833828895.1518409623";
			$headers[] = "Connection: keep-alive";
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$result = curl_exec($ch);
			
			if (curl_errno($ch)) {
			    echo 'Error:' . curl_error($ch);
			}
			curl_close ($ch);
			
			$result = json_decode($result,true);
			
			return $result['code'];
		}
    	else{
			return $result;
		}
	}
	else{
		return $result;
	}
});

//Override Flight's default error method
Flight::map('error', function(Exception $ex){
    // Handle error
    $request = Flight::request();
    echo '<pre>';
    var_dump($ex->getTraceAsString());
    var_dump($request);
    //Support_Log::Log('aaaa',1111);
    //Flight::redirect('/main');
});