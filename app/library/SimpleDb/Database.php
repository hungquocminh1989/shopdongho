<?php

class Database
{
	private $dbh;
	private $in_transaction;
	private $_last_param;
	private $_last_sql;
	private $db_medoo;
	protected $table_name;
	protected $pk_id;
	
	public function __construct($tablename = NULL)
	{
		/*
		$dns = 'mysql:dbname=mail;host=127.0.0.1';
		$username = 'mail_admin';
		$password = 'abcd123456';
		*/
		$driver_options = array(PDO::ATTR_PERSISTENT => false);
		
		try {
			
			$this->dbh = new PDO(DATABASE_DNS, DATABASE_USER, DATABASE_PASS, $driver_options);
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			//Connect Medoo
			$this->db_medoo = new Medoo(
				[
				    'database_type' => DATABASE_TYPE,
				    'database_name' => DATABASE_NAME,
				    'server' 		=> DATABASE_HOST,
				    'username' 		=> DATABASE_USER,
				    'password' 		=> DATABASE_PASS,
				    'port' 			=> DATABASE_PORT
				]
			);
			
			//Active debug sql log
			if(SYSTEM_DEVELOPMENT_MODE == TRUE){
				$this->db_medoo->debug();
			}
			
			$this->table_name = $tablename;
        	$this->pk_id = $tablename.'_id';
			
		} 
		catch (PDOException $e) {
			
			$this->_db_error($e);
			
		}
		
		$this->in_transaction = false;
	}
	
	public function MedooDb() {
		
		return $this->db_medoo;
		
	}
	
	protected function begin_transaction() {
		
		try {
			$this->dbh->beginTransaction();
		} catch (PDOException $e) {
			$this->_db_error($e);
		}
		
		$this->in_transaction = true;
		
	}
	protected function commit() {
		
		try {
			$this->dbh->commit();
		} catch (PDOException $e) {
			$this->_db_error($e);
		}
		
		$this->in_transaction = false;
		
	}
	protected function rollback() {
		
		if ($this->in_transaction == false) {
			return;
		}
		
		$this->in_transaction = false;
		
		try {
			$this->dbh->rollBack();
		} catch (PDOException $e) {
			$this->_db_error($e);
		}
		
	}
	protected function query($sql, $param=null) {
		
		//Active debug sql log
		if(SYSTEM_DEVELOPMENT_MODE == TRUE){
		$sql_log = $sql;
		if($param != NULL ){
			$sql_log .= "\r\n".var_export($param,TRUE);
		}
		Support_Log::Log('SYSTEM_DEBUG_SQL',$sql_log);
		}
		
		
		// PREPARE
		$stmt = $this->_internal_prepare($sql);
		
		$this->_internal_execute($stmt, $param);
		// FETCH
		return $this->_internal_fetch($stmt);
		
	}
	protected function execute($sql, $param=null) {
		
		//Active debug sql log
		if(SYSTEM_DEVELOPMENT_MODE == TRUE){
		$sql_log = $sql;
		if($param != NULL ){
			$sql_log .= "\r\n".var_export($param,TRUE);
		}
		Support_Log::Log('SYSTEM_DEBUG_SQL',$sql_log);
		}
		
		// PREPARE
		$stmt = $this->_internal_prepare($sql);
		
		$this->_internal_execute($stmt, $param);
		
	}
	
	protected function prepare($sql) {
		
		return $this->_internal_prepare($sql);
		
	}
	protected function prepared_execute($stmt, $param=null) {
		
		$this->_internal_execute($stmt, $param);
		
	}
	protected function prepared_query($stmt, $param=null) {
		
		$this->_internal_execute($stmt, $param);
		// FETCH
		return $this->_internal_fetch($stmt);
		
	}
	private function _internal_prepare($sql) {
		
		try {
			$this->_last_sql = $sql;
			$this->_last_param = null;
			$stmt = $this->dbh->prepare($sql);
		} catch (PDOException $e) {
			$this->_db_error($e);
		}
		
		return $stmt;
		
	}
	private function _internal_execute($stmt, $param) {
		
		try {
			if (is_null($param) == false) {
				$this->_last_param = $param;
				foreach ($param as $key => $val) {
					if ($this->_is_db_null($val) == true) {
						$stmt->bindValue(':' . $key, null, PDO::PARAM_NULL);
					} else {
						$stmt->bindValue(':' . $key, $val);
					}
				}
			}
			$stmt->execute();
		} catch (PDOException $e) {
			$this->_db_error($e);
		}
		
	}
	private function _internal_fetch($stmt) {
		
		$all = array();
		
		try {
			for (;;) {
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				if ($result === false) {
					break;
				}
				$all[] = $result;
			}
		} catch (PDOException $e) {
			$this->_db_error($e);
		}
		
		return $all;
		
	}
	
	private function _is_db_null($value) {
		
		if (is_null($value)) {
			return true;
		}
		
		if (is_string($value) == false) {
			settype($value, "string");
		}
		
		if ($value == '') {
			return true;
		}
		
		return false;
		
	}
	
	private function _db_error($e) {
		
		if ($this->in_transaction == true) {
			$this->in_transaction = false;
			$this->dbh->rollBack();
		}
		
		$line = $e->getMessage();
		$line .= $this->_last_sql . "\r\n";
		if (is_null($this->_last_param) == false) {
			$line .= var_export($this->_last_param, true) . "\r\n";
		}
		Support_Log::Log('SYSTEM_ERROR_EXCEPTION_SQL',$line);
		
		throw $e;
		
	}
	
	//Auto INSERT or UPDATE ( Avaliable >= Postgres 9.5)
	public function upsertRow($sql_param, $id = 'null', $table_name = NULL){
		
		$primary_key = "";
		
		if($table_name == NULL ){
		$table_name = $this->table_name;
		$primary_key = $this->pk_id;
		}
		else{
			$primary_key = $table_name . "_id";
		}
		
		
		if($id == '' || $id == NULL || empty($id) == TRUE){
			$id = 'null';
		}
		
		$arr_cols = array();
		$arr_vals = array();
		$arr_field_update = array();
		foreach($sql_param as $col=> $value){
			$arr_cols[] = $col;
			$arr_vals[] = ":".$col;
			$arr_field_update[] = $col.'=excluded.'.$col;
		}
		
		$sql_column = implode(",",$arr_cols);
		$sql_value = implode(",",$arr_vals);
		$sql_update = implode(",",$arr_field_update);
		
		$sql = "
			INSERT INTO $table_name (
					$primary_key , $sql_column
				)
			VALUES ( 
					--Nếu không truyền id thì tăng tự động để INSERT , có id thì tự động INSERT/UPDATE
					COALESCE($id,NEXTVAL(
						(
							SELECT               
								pg_class.relname || '_' || pg_attribute.attname || '_seq' AS pk_constraint
								--,format_type(pg_attribute.atttypid, pg_attribute.atttypmod) 
							FROM pg_index, pg_class, pg_attribute, pg_namespace 
							WHERE 
								pg_class.oid = '$table_name'::regclass 
								AND indrelid = pg_class.oid 
								AND nspname = 'public' 
								AND pg_class.relnamespace = pg_namespace.oid 
								AND pg_attribute.attrelid = pg_class.oid 
								AND pg_attribute.attnum = any(pg_index.indkey)
								AND indisprimary
						)
					)),
					$sql_value
				)
			ON CONFLICT (
					$primary_key
				) DO UPDATE
			SET 
				$sql_update 
			RETURNING $primary_key , $sql_column
		";
		
		$result = $this->query($sql, $sql_param);
		
		if($result != NULL && count($result) > 0){
			
		return $result;
		
	}
		
		return FALSE;
		
	}
	
}	
?>