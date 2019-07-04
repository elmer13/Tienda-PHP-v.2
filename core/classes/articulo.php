<?php
	include_once 'DBAbstractModel.php'; // Importar modelo de abstracción de base de datos

	class Articulo extends DBAbstractModel{
		// Atributos de la clase
		protected $codigo_articulo;
		protected $id_categoria;
		public $nombre;
		public $marca;
		public $precio;
		public $fotoarticulo;
		public $descripcion;
		public $propiedad;
		public $vamos;
		public $cantidad=1;
		public $nuevo= array();
		
		// Traer datos de articulos de la categoria correspondiente por ID
		public function getByCategory($id_categoria='') {
			if($id_categoria != '') {
				$this->query = "
				SELECT *
				FROM articulos
				WHERE id_categoria= '$id_categoria'
				";
				$this->getResultsFromQuery();
			}
		}
		// Traer nombre de categoria por ID
		public function NameCategoryById($id_categoria=''){
			if($id_categoria !=''){
				$this->query = "
				SELECT categoria_nombre
				FROM categorias
				WHERE codigo_categoria= '$id_categoria'
				";
				$this->getResultsFromQuery();
			}
			return $this->consulta;
		}
		
		// Traer datos de un articulo por codigo del articulo
		public function getByCode($codigo_articulo='') {
			if($codigo_articulo != '') {
				$this->query = "
				SELECT *
				FROM articulos
				WHERE codigo_articulo= '$codigo_articulo'
				";
				$this->getResultsFromQuery();
			}
			if(count($this->consulta) == 1) {
				foreach ($this->consulta as $propiedad=>$valor) {
					$this->propiedad = $valor;
				}
				return true;
			}else{
				return false;
			}
		}
		
		// Traer datos de articulos mediante el nombre
		public function getByName($busqueda='') {
			if($busqueda != '') {
				$this->query = "
				SELECT *
				FROM articulos
				WHERE nombre LIKE '%$busqueda%'
				order by codigo_articulo ASC 
				";
				$this->getResultsFromQuery();
			}
		}
		
		// Crear un nuevo articulo
		public function setArticle($article_data=array()){
			if(array_key_exists('codigo_articulo', $article_data)){
				if(!$this->getByCode($article_data['codigo_articulo'])){
					foreach ($article_data as $propiedad=>$valor) {
						$$propiedad = $valor;
					}
					$this->query = "
					INSERT INTO articulos
					(codigo_articulo, id_categoria, nombre, marca, precio, fotoarticulo,descripcion)
					VALUES
					('$codigo_articulo', '$id_categoria', '$nombre', '$marca', '$precio','$fotoarticulo','$descripcion')
					";
					$this->ejecutarConsulta();
					return true;
				}
				return false;
			}
		}
		
		// Reasignación del nombre de la imagen al agregar articulo permitiendo asi que no haya problemas en caso de tener el mismo nombre
		public function file_newpath($path, $filename){
			if ($pos = strrpos($filename, '.')) {
			   $name = substr($filename, 0, $pos);
			   $ext = substr($filename, $pos);
			} else {
			   $name = $filename;
			}
			
			$newpath = $path.'/'.$filename;
			$newname = $filename;
			$counter = 0;
			
			while (file_exists($newpath)) {
			   $newname = $name .'_'. $counter . $ext;
			   $newpath = $path.'/'.$newname;
			   $counter++;
			}	
			return $newpath;
		}
		
		// Editar un articulo teniendo en cuenta el codigo del articulo
		public function edit($article_data=array()) {
			foreach ($article_data as $propiedad=>$valor) {
				$$propiedad = $valor;
				
			}
			$this->query = "
			UPDATE articulos
			SET id_categoria='$id_categoria',
			nombre='$nombre',
			marca='$marca',
			precio='$precio',
			fotoarticulo='$fotoarticulo',
			descripcion='$descripcion'
			WHERE codigo_articulo = '$codigo_articulo'
			";
			$this->ejecutarConsulta();
		}

		# Eliminar un articulo mediante el codigo del articulo
		public function delete($codigo_articulo='') {
			$this->query = "
			DELETE FROM articulos
			WHERE codigo_articulo = '$codigo_articulo'
			";
			$this->ejecutarConsulta();
		}
	}
?>