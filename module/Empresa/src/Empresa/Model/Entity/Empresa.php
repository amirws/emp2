<?php

namespace Empresa\Model\Entity; 

class Empresa {
	
	private $nombre;
	private $fotos;
	private $desdeafuera;
	
	public function __construct($valor){
		$this->nombre="Bio-Aqua Agua Purificada de Manantial";
		$this->fotos=array();
		$this->desdeafuera=$valor;
	}
	public function getNombre(){
		return $this->nombre;
	}
	
	public function cargaFotos(){
		$a=array("Garrafon.png","Clientes.jpg","Presentación 19 LTS.png");
		$coma_separar=implode(",",$a);
		array_push($this->fotos, $coma_separar);
	}
	public function getFotos(){
		self::cargaFotos();
		return $this->fotos;
	}
	
	public function desdeController(){
		return $this->desdeafuera;
	}
}

