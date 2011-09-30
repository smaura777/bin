<?php
  class RowModel {
    private $cellCollection = array();
    private $cellConstraintCollection;
    private $query;
    
    
    function setQuery($query){
    	$this->query = $query;
    }
    
    function setConstraint($key,$val="",$constraint = "="){
    	$cell = new CellModel();
    	$cell->label = $key;
    	$cell->value = ''.$val.'';    
    	$this->cellConstraintCollection[$cell->label] = array("constraint" => $constraint,"cell" => $cell);
    }
    
    function set($key,$val="") {
      $cell = new CellModel();
      $cell->label = $key;
      $cell->value = ''.$val.'';
      $this->cellCollection[$cell->label] = $cell;
    }

    function get($key){
      return $this->cellCollection[$key];
    }
    
    function toColumns(){
      $count = 0; 	
      $toColumn = "";
      foreach ($this->cellCollection as $cell){
      	if ($count > 0){
      		$toColumn .= ", ";
      	}
      	$toColumn .= "{$cell->label} = {$cell->value} ";	
      	++$count;
      } 
      return $toColumn;
    }
    
    
    function toValues(){
    	$count = 0;
    	$toValues = "";
    	foreach ($this->cellCollection as $cell){
    	  if ($count > 0){
    		  $toValues .= ", ";
    	  }
    	  $toValues .= "{$cell->value}";
    	  ++$count;
    	}
    	return $toValues;
    }
    
    
    function toColumnList(){
      $count = 0; 	
      $columnList = "";
      foreach ($this->cellCollection as $cell){
      	if ($count > 0){
      	 $columnList .= ", ";	
      	}
      	$columnList .= $cell->label;
      	++$count;
      }
      return $columnList;
    }
    
    function toConstraints(){
    	if (count($this->cellConstraintCollection) <= 0) {
    	  return "";	
    	}
    	
    	$count = 0;
    	$constraintList = "WHERE ";
    	foreach ($this->cellConstraintCollection as $cell){
    		if ($count > 0){
    			$constraintList .= ", ";
    		}
    		$constraintList .= $cell['cell']->label ." ".$cell['constraint'] ." ".$cell['cell']->value." ";
    		++$count;
    	}
    	return $constraintList;    	      	
    }
    
    function toQuery(){
      return $this->query;	
    }
    
  }
?>