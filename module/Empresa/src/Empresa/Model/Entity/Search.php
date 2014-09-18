<?php

namespace Empresa\Model\Entity;

class Search {
	
	private $keyword1;
	private $keyword2;
	
	public function __construct($datos=array()){
		$this->nombre=$datos["nombre"];
		$this->email=$datos["email"];
		$this->servicios=$datos["servicios"];
	}
	
	public function getData(){
		$array=array($this->nombre,$this->servicios,$this->email);
		return $array;
	}
}

?>