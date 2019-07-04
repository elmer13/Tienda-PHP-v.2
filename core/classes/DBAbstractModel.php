<?php
	abstract class DBAbstractModel{ // Declaramos una clase abstracta
		// Atributos de la conexion con la bd y atributos de la clase
		private static $host='localhost';
		private static $user='root';
		private static $pass='';
		protected $dbname='tienda-elmer';
		private $conexion;
		protected $query;
		protected $resultado;
		protected $fila;
		protected $exito;
		public $consulta;
		
		// Conectar a la base de datos
		private function abrirConexion(){	
			$this->conexion= new mysqli(self::$host,self::$user,self::$pass,$this->dbname);	
			if ($this->conexion->connect_errno) { // En caso de error en la conexión
				echo "Error MySQLi: ("&nbsp. $this->conexion->connect_errno.") " . $this->conexion->connect_error;
				exit();
			}
			$this->conexion->set_charset("utf8"); // Cotejamiento utf8 para evitar problemas de ortografia en la bd
		}
	
		// Desconectar la base de datos
		private function cerrarConexion(){
			$this->conexion->close();
		}
	
		// Ejecutar un query simple del tipo INSERT, DELETE, UPDATE
		protected function ejecutarConsulta(){
			$this->abrirConexion();
			if(!$this->conexion->query($this->query)){ // Si falla, lo indicamos
				echo "La consulta ha fallado.".$this->conexion->error;
				echo "<br/>";
			}
			else{ // Caso contrario, nos realiza la query y cerramos la conexión
			$this->cerrarConexion();
			}
		}
		
		// Traer resultados de una consulta en un Array
		protected function getResultsFromQuery(){
			$this->abrirConexion(); // Abrimos la conexión
			$this->resultado = $this->conexion->query($this->query); // Realizamos la consulta y lo almacenamos en una variable protegida
			while($this->fila = $this->resultado->fetch_assoc()){ // La recorremos mediante fetch_assoc
				$this->consulta[]= $this->fila; // Almacenamos los resultados en un array
			}
			$this->resultado->close(); 
			$this->cerrarConexion(); // Cerramos la conexión
			if(!$this->consulta){ // Si la consulta fallo retorna false
				return false;
			}else{ // Si la consulta se realizo con existo retornamos el array
				return $this->consulta;
			}
		}	
	}
?>