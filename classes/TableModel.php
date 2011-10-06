<?php
class TableModel {
	private $_connection;
	private $queryOp;
	private  $resultCount = 0;
	private $resultSet = array();
	
	public $tableName;
	
	function __construct(){
		$this->_connection = DatabaseConnection::Connect();
		if ($this->_connection->error){
			die("Connect error" . $this->_connection->error);
		}
	}
	
	function saveResultSet($result){
	  while ($resultRow = $result->fetch_assoc()){
		$rowObject = new RowModel();
		foreach ($resultRow as $key => $val){
		  $rowObject->set("{$key}","{$val}");
		}
		$this->resultSet[] = $rowObject;
	  }
	}
	
	function add(RowModel $row){
	  if (empty($this->tableName)){
	  	throw new Exception("Empty table name");	
	  }
	  
	  $this->queryOp = "INSERT INTO {$this->tableName} ({$row->toColumnList()}) VALUES ({$row->toValues()}) ";
	 // echo "<p> query == ".$this->queryOp."</p>";
	  
	  $this->_connection->query($this->queryOp);
	  if ($this->_connection->error){
	     throw new Exception("Insert error " . $this->_connection->error,$this->_connection->errno);
	  }      
	}
	
	
	function remove(RowModel $row){
	  if (empty($this->tableName)){
		 throw new Exception("Empty table name");
	  }
	  $this->queryOp = "DELETE FROM {$this->tableName} WHERE {$row->toConstraints()}";
	  $result =  $this->_connection->query($this->queryOp);
	  if ($this->_connection->error){
	  	throw new Exception("Select error ");
	  }
	}
	
	
	function update(RowModel $row){
	  if (empty($this->tableName)){
			throw new Exception("Empty table name");
	  }
	  $this->queryOp = "UPDATE {$this->tableName} SET  {$row->toColumns()}  WHERE {$row->toConstraints()}";
	  $result =  $this->_connection->query($this->queryOp);
	  if ($this->_connection->error){
	  	throw new Exception("Select error ");
	  }	   	
	}
	
	function fetch(RowModel $row,$limit=0,$options=""){
	  if (empty($this->tableName)){
	    throw new Exception("Empty table name");
	  } 
      
	  if (!is_int($limit)){
	  	throw new Exception("Limit is not an integer");
	  }
	  
	  $this->queryOp = "SELECT  {$row->toColumnList()} FROM {$this->tableName}  {$row->toConstraints()}";
	  
	  
	  if ($limit > 0){
	  	$this->queryOp .= " LIMIT {$limit} ";
	  }
	  
	  if (!empty($options)){
	  	$this->queryOp .= " {$options} ";
	  }
	  //echo "<p>".$this->queryOp."</p>";
	  $result =  $this->_connection->query($this->queryOp);
	  if ($this->_connection->error){
	  	throw new Exception("Select error ");
	  }
	
	  $this->resultCount = $result->num_rows;
	  $this->saveResultSet($result);
    
	  return $this->resultSet;
	}
	
	
	function fetchCount(RowModel $row){
	  if (empty($this->tableName)){
		throw new Exception("Empty table name");
	  }
		
	  $this->queryOp = "SELECT count(*) as total FROM {$this->tableName}  {$row->toConstraints()}";
	  
	 // echo "<div>".$this->queryOp." </div>";
	  
	  $result =  $this->_connection->query($this->queryOp);
	  if ($this->_connection->error){
		throw new Exception("Select count error ");
	  }
      
	  $resultRow = $result->fetch_assoc();
	  return intval($resultRow['total']);
	}
	
	
	
	
	
	function count(){
	  if (is_int($this->resultCount)){
	  	return $this->resultCount;
	  }
	  else {
	    throw new Exception("Invalid count");
	  }	
	}
	
}

?>