<?php
namespace app\controllers;

use Flight; 

class CommonController extends BasicController {

	public static function index()
	{
		$model = new \app\models\SampleModel();
		$tmp = $model->getTable();
		
		$arr_return = array();
		$arr_return['test'] = $tmp;
	    parent::flight(__FUNCTION__,$arr_return);
	    return;
	}

   	public static function product()
	{
		$arr_return = array();
		$arr_return['test'] = $tmp;
	    parent::flight(__FUNCTION__,$arr_return);
	    return;
	}
	
	public static function category()
	{
		$arr_return = array();
		$arr_return['test'] = $tmp;
	    parent::flight(__FUNCTION__,$arr_return);
	    return;
	}
    
}
