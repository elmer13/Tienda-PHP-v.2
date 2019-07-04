<?php
	include_once 'DBAbstractModel.php'; // Importar modelo de abstracción de base de datos

	class Cliente extends DBAbstractModel{
	    // Atributos de la clase
		protected $id_cliente;
		protected $nif;
		public $nombre;
		public $telefono;
		public $direccion;
		public $localidad;
		public $provincia;
		public $pais;
		public $codigopostal;
		public $email;
		private $password;
		public $propiedad;
		
		// Traer datos de un cliente por el nif
		public function getUserByNif($nif='') {
			if($nif != '') {
				$this->query = "
				SELECT *
				FROM clientes
				WHERE nif = '$nif'
				";
				$this->getResultsFromQuery();
			}
			if(count($this->consulta) == 1) {
				foreach ($this->consulta as $propiedad=>$valor) {
					$this->propiedad = $valor;
				}
				return true;
			} else {
				return false;
			}
		}
	
		// Crear un nuevo cliente
		public function setUser($user_data=array()){
			if(array_key_exists('nif', $user_data)) {
				if(!$this->getUserByNif($user_data['nif'])){
					foreach ($user_data as $propiedad=>$valor) {
						$$propiedad = $valor;
					}
					@$password   = md5($password);
					$this->query = "
					INSERT INTO clientes
					(nif, nombre, password, telefono, direccion, localidad, provincia, pais, codigopostal, email)
					VALUES
					('$nif', '$nombre','$password','$telefono','$direccion','$localidad','$provincia','$pais','$codigopostal','$email')
					";
					$this->ejecutarConsulta();
						return true;
				}
					return false;
			}
		}

		// Login de inicio de sesion pasando como parametro el nombre y el password
		public function login($nom, $pass) {
			if($nom != '') {
				$pass=md5($pass);
				$this->query = "
				SELECT id_cliente, nombre, password, rol
				FROM clientes
				WHERE nombre = '$nom' AND password = '$pass'
				";
				$this->getResultsFromQuery();
			}
		}

		// Traer datos del cliente mediante su nombre
		public function getUserByName($nombre='') {
		if($nombre != '') {
		$this->query = "
		SELECT *
		FROM clientes
		WHERE nombre = '$nombre'
		";
		$this->getResultsFromQuery();
		}
			if(count($this->consulta) == 1) {
				foreach ($this->consulta as $propiedad=>$valor) {
					$this->propiedad = $valor;
				}
				return true;
			} else {
				return false;
			}
		}
		
	
		// Modificar un cliente teniendo como comparador el nif
		public function edit($user_data=array()) {
			foreach ($user_data as $propiedad=>$valor) {
				$$propiedad = $valor;
			}
			$this->query = "
			UPDATE clientes
			SET nombre='$nombre',
			telefono='$telefono',
			direccion='$direccion'
			localidad='$localidad',
			provincia='$provincia',
			pais='$pais',
			codigopostal='$codigopostal',
			email='$email',
			password='$password'
			WHERE nif = '$nif'
			";
			$this->ejecutarConsulta();
		}

		// Eliminar un cliente mediante el nif
		public function delete($nif='') {
			$this->query = "
			DELETE FROM clientes
			WHERE nif = '$nif'
			";
			$this->ejecutarConsulta();
		}
	}
?>