<?php 
	class Sesion{
		private $mi_sesion; // Definimos como privada el atributo '$mi_sesion'
		
		public function  __construct(){
			// Comenzar la sesion
			session_start();
			// Pasamos las variables de sesion al atributo "mi_sesion"
			$this->mi_sesion = &$_SESSION;
		}
		
		public function agregarSesion($datos = array()){		
			
			if(is_array($datos) && count($datos) > 0){
					session_name($datos);
				// Colocamos en la variable de sesion los nombres asociativos y sus respectivos valores pasados mediante el array
				foreach($datos as $clave => $valor){
					$this->mi_sesion[$clave] = $valor;
				}
			}		
		}
		
		public function editarSesion($name, $valor){
			// Editamos una variable de sesion existente
			$this->mi_sesion[$name] = $valor;
		}
		
		public function comprobarSesion($name){
			// Verificamos si una variable de sesion existe
			return isset($this->mi_sesion[$name]);
		}
		
		public function getSesionId(){
			// Retornamos el id de sesion
			return session_id();
		}
		
		public function getValor($name){
			// Primero verificamos si existe
			if($this->comprobarSesion($name)){
				// Si existe la sesion devolvemos el valor
				return $this->mi_sesion[$name];
			}
			// De lo contrario retornamos falso
			return false;
		}
		
		public function borrarSesion($name){
			// Borra la variable de sesion enviada
			unset($this->mi_sesion[$name]);
		}
		
		public function eliminarSesion(){
			// Vaciamos el array de sesiones y destruimos toda la sesion
			$this->mi_sesion = array();
			session_destroy();
		}
	}
?>
