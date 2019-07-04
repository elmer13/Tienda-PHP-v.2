<?php
	class Tag{
		// Definimos los atributos de la clase Tag como publicos
		public $type;
		public $id;
		public $class;
		public $attributes = array();
		public $atrr = array();

		public function openTag($type,$id,$clase,$attributes = array()){ // Este metodo define la obertura de los diferentes elementos html que podemos crear ej:label, divs, etc
			$this->type = $type;
			$this->id = $id;
			$this->clase = $clase;
			$this->attributes = $attributes;
			// A continuación ponemos a nulo las variables que no esten definidas en caso contrario definimos las etiquetas
			if(empty($this->id) || $this->id == ""){ $this->id = NULL;}else{ $this->id = "id=\"".@$this->id."\"";} 
			if(empty($this->clase) || $this->clase == ""){ $this->clase = NULL;}else{ $this->clase = "class=\"".@$this->clase."\"";}
			if(!empty($this->attributes)){ // Si contiene atributos los implementamos y los mostramos de una manera determinada
				foreach($attributes as $key => $values){ // Recorremos los valores del array y los guardamos en la variable en otro array 'atrr'
					$way[] = $key;	
					$actions[] = $values;
					array_push($this->atrr,$key."=\"".$values."\"");
				}
				$acciones = implode(" ", $this->atrr); // Separamos los atributos por espacio y mostramos la etiqueta 
				$this->atrr = array();
				echo "<".$this->type." ".@$this->clase." ".@$this->id." ".$acciones.">";
			}else{ // Si no contiene atributos mostramos la etiqueta sin esa opción
				echo "<".$this->type." ".@$this->clase." ".@$this->id.">";	
			}
		}
			
		public function closeTag($typecloser){ // Cerramos el elemento html
			echo "</".$typecloser.">";
		}
			
		public function output($value){ //creamos el metodo output que nos permitira entre otras cosas crear un echo
			echo $value;
		}
	}	
?>