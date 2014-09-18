<?php

namespace Principal\Model\Entity;


class Busqueda  {
	
	private $ciudad;
	private $ciudad2;
	private $categoria;
	private $categoria2;
	
	public function setCategoria($categoria){
	
		$this->categoria=$categoria;
		$this->categoria2=$categoria;
		@session_destroy($_SESSION['cat']);
		@session_start();
		@$_SESSION['cat']=$this->categoria2;

		
		
	}
	public function setCiudad($ciudad){
		$this->ciudad=$ciudad;
		$this->ciudad2=$ciudad;
		@session_destroy($_SESSION['ciu']);
		@session_start();
		@$_SESSION['ciu']=$this->ciudad2;
	
		
	}

	public function buscarEmpresas($datos=array()){
		$this->ciudad=$datos['ciudad'];
		$this->categoria=$datos['categoria'];
		$datos=array('ciudad'=>$this->ciudad,'categoria'=>$this->categoria);
		return $datos;
	}
	public function getUrl($s)
	{

			$s = str_replace("Ã¡","a",$s);
			$s = str_replace("Ã©","e",$s);
			$s = str_replace("Ã","i",$s);
			$s = str_replace("i³","o",$s);
			$s = str_replace("i“","O",$s);
			$s = str_replace("iº","u",$s);
			$s = str_replace("iš","U",$s);
			$s = str_replace(" ","-",$s);
			$s=@ereg_replace("i±","n",$s);
			$s=@ereg_replace("i‘","N",$s);
			return $s;

		}

		public function getCategoria (){
			
			return $this->categoria2;
			
		}
		public function getCiudad(){
			return $this->ciudad2;
		}
		public function getYouTubeIdFromURL($url){
  		$url_string = parse_url($url, PHP_URL_QUERY);
  		parse_str($url_string, $args);
  		return isset($args['v']) ? $args['v'] : false;
		}
	}

