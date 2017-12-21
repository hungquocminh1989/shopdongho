<?php
namespace app\models;

use PDO;

class Model
{
	private $dbh;
	private $in_transaction;
	private $_last_param;
	private $_last_sql;
	
	public function __construct()
	{
		/*
		$dns = 'mysql:dbname=mail;host=127.0.0.1';
		$username = 'mail_admin';
		$password = 'abcd123456';
		*/
		$driver_options = array(PDO::ATTR_PERSISTENT => false);
		try {
			$this->dbh = new \PDO(DATABASE_DNS, DATABASE_USER, DATABASE_PASS, $driver_options);
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			$this->_db_error($e);
		}
		$this->in_transaction = false;
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
		// PREPARE
		$stmt = $this->_internal_prepare($sql);
		
		$this->_internal_execute($stmt, $param);
		// FETCH
		return $this->_internal_fetch($stmt);
	}
	protected function execute($sql, $param=null) {
		// PREPARE
		$stmt = $this->_internal_prepare($sql);
		
		$this->_internal_execute($stmt, $param);
	}
	
	protected function prepare($sql) {
		//ACWLog::sql_statement($sql);
		return $this->_internal_prepare($sql);
	}
	protected function prepared_execute($stmt, $param=null) {
		$this->_internal_execute($stmt, $param);
	}
	protected function prepared_query($stmt, $param=null) {
		ACWLog::sql('prepared_query', $param);
		
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
		
		throw $e;
	}
}	
?>