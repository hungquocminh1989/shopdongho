<?php 
namespace app\models;

class SampleModel extends BasicModel {
    
    
    public function getTable(){
    	$result = $this->query("SELECT * FROM m_friends");
		return $result;
	}
    
}
