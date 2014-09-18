<?php

namespace Empresa\Model\Entity;

class NewPyme {
	
	private $nombre;
	private $servicios;
	private $email;
	
	
	
	public function __construct($datos=array()){
		$this->nombre=$datos["nombre"];
		$this->email=$datos["email"];
		$this->servicios=$datos["servicios"];
	}
	
	public function getData(){
		$array=array($this->nombre,$this->servicios,$this->email);
		return $array;
	}
	
	public function seleccionarCiudad(){
		$ciudad=array('Xalapa', 'Actopan', 'Veracruz');
		return $ciudad;
		
	}
	
}

?>