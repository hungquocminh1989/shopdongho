<?php 
class Model extends MasterDB {
	
    /**■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
	* Các Hàm Cơ Bản Truy Xuất DB
	* ■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
	*/
	//■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
	
	public function selectRowById($id){
    	
    	$data = $this->select($this->table_name,'*',
    		[
				$this->pk_id => $id
			]
		);
		
		if($data != NULL && count($data) > 0 ){
			return $data;
		}
    	
		return NULL;
		
	}
	
	public function selectAllRows($arrOrderBy = array()){
    	
    	if($arrOrderBy != NULL && count($arrOrderBy) > 0){
			$data = $this->select($this->table_name,'*',
	    			[
		    			"ORDER" => $arrOrderBy
		    		]
	    	);
		}
		else{
			$data = $this->select($this->table_name,'*',
	    			[
		    			"ORDER" => [$this->pk_id => 'ASC']
		    		]
	    	);
		}
		
		if($data != NULL && count($data) > 0 ){
			return $data;
		}
    	
		return NULL;
		
	}
	
	public function selectRowsByConditions($param = array()){
    	
    	$data = $this->select($this->table_name,'*',$param);
		
		if($data != NULL && count($data) > 0 ){
			return $data;
		}

		return NULL;
		
	}
	
	public function insertRow($sql_param){
		
		$this->insert($this->table_name,$sql_param);
		$lastInsertId = $this->id();
		return $lastInsertId;
    	
	}
	
	public function insertRows($sql_params){		
		
		$arr_ids = array();
		foreach($sql_params as $key => $sql_param){
			$this->insert($this->table_name,$sql_param);
			$lastInsertId = $this->id();
			$arr_ids[] = $lastInsertId;
		}
		
		return $arr_ids;
    	
	}
	
	public function updateRowById($sql_param, $id){
		
		$this->update($this->table_name,$sql_param,
			[
				$this->pk_id => $id
			]
		);
		
		return TRUE;
    	
	}
	
	public function updateRowsByConditions($sql_param, $where_param){
		
		$this->update($this->table_name,$sql_param,$where_param);
		
		return TRUE;
    	
	}
	
	public function deleteRowById($id){
		
		$this->delete($this->table_name,
			[
				$this->pk_id => $id
			]
		);
		
		return TRUE;
		
	}
	
	public function deleteRowsByConditions($param){
		
		$this->delete($this->table_name,$param);
		
		return TRUE;
		
	}
	
	public function truncateTable(){
		
		$tablename = $this->table_name;
		$sql = "
			TRUNCATE $tablename RESTART IDENTITY;
		";
		$this->execute($sql);
		return TRUE;
		
	}
	
	public function generateSortNo($tablename){
		
		$pkey = $tablename . '_id';
		$sql_upd = "
			UPDATE $tablename org
			SET sort_no = tmp.rnum
			FROM (
				SELECT ROW_NUMBER () OVER (ORDER BY COALESCE(sort_no,0)) as rnum,* 
				FROM $tablename
				ORDER BY COALESCE(sort_no,0), $pkey
			) AS tmp
			WHERE org.$pkey = tmp.$pkey
		";
		$this->execute($sql_upd);
		
		return TRUE;
		
	}
	
	public function updateSortNo($tablename, $arr_sort_list){
		
		if($arr_sort_list != NULL && count($arr_sort_list) > 0){
			$pkey = $tablename . '_id';
			$str_data = "";
			$arr_data = array();
			foreach($arr_sort_list as $key => $value){
				$arr_data[] = "(" . $value['sort_id'] . ',' . $value['sort_no'] . ")";
			}
			if($arr_data != NULL && count($arr_data) > 0){
				$str_data = implode(',',$arr_data);
				$sql_upd = "
					UPDATE $tablename AS t 
					SET
					    sort_no = c.sort_no
					FROM (
						VALUES
						    $str_data  
					) AS c($pkey, sort_no) 
					WHERE c.$pkey = t.$pkey;
				";
				$this->execute($sql_upd);
			}
		}
		
	}
	
}
