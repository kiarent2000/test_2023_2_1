<?php

class ArrayClass
{
	 private $data;
	   
	 public function __construct($data)
	 {
			$this->data=$data;
	 }
	 
	 public function sort():array
	 {
		  ksort($this->data);
		  return $this->data;
	 }
	 

	
	
	
}