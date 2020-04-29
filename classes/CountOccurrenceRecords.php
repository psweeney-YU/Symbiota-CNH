<?php
include_once($SERVER_ROOT.'/config/dbconnection.php');

class CountOccurrenceRecords {

	private $conn;

	function __construct(){
		$this->conn = MySQLiConnectionFactory::getCon("readonly");
	}

	function __destruct(){
		if(!($this->conn === null)) $this->conn->close();
	}

	public function theCount(){
		$numRows = 0;
		$sql = 'SELECT count(*) AS cnt FROM omoccurrences';
		$result = $this->conn->query($sql);
		if($row = $result->fetch_object()){
			$numRows = $row->cnt;
		}
		$result->free();
		return $numRows;
	}
}
?>