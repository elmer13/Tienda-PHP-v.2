<?php	
	class HtmlForm{
		// Definimos los atributos de la clase Form como publicos
		public $action;
		public $method;
		public $id;
		public $type;
		public $name;
		public $value;
		public $rows;
		public $cols;
		public $legend;
		public $width;
		public $selected;
		public $multiple;
		public $radio;
		public $_atributs = array(); 
			
		public function startForm($action,$method,$id,$atributs = array()){ // Con este metodo abrimos el formulario pasando los parametros necesarios y guardandolos
			$this->action = $action;
			$this->method = $method;
			$this->id = $id;
			$this->_atributs = $atributs;
			// Mostramos la obertura del formulario
			echo "<form method=\"".$this->method."\" action=\"".$this->action."\" id=\"".$this->id."\" name=\"".@$this->_atributs['name']."\" enctype=\"".@$this->_atributs['enctype']."\" class=\"".@$this->_atributs['class']."\" onsubmit=\"".@$this->_atributs['onsubmit']."\" onClick=\"".@$this->_atributs['onClick']."\">";
		}
			 
		public function openfieldset($texto,$width){ // Pasamos los diferentes parametros para la creación del fieldset y las guardamos 
			$this->legend=$texto;
			$this->width=$width;
			// Mostramos la obertura del fieldset
			echo "<fieldset style='width:".$this->width."px;'><legend>".$this->legend."</legend>";
		}

		public function addInput($type,$name,$value,$atributs = array()){ // Creación de los diferentes inputs teniendo en cuenta el tipo y sus caracteristicas
			$this->type = $type;
			$this->name = $name;
			$this->value = $value;
			$this->_atributs=$atributs;
			// Mostramos los inputs
			echo "<input type=\"".@$this->type."\" name=\"".@$this->name."\" value=\"".@$this->value."\" placeholder=\"".@$this->_atributs["placeholder"]."\" id=\"".@$this->_atributs["id"]."\" src=\"".@$this->_atributs["src"]."\" class=\"".@$this->_atributs["class"]."\" size=\"".@$this->_atributs["size"]."\" ".@$this->_atributs["readonly"]." ".@$this->_atributs["required"]."/>";
		}
				
		public function  addTextarea($name,$rows,$cols,$value,$atributs = array()){ // Creación de un textarea teniendo como atributos principales el 'rows' y el 'cols'
			$this->name = $name;
			$this->rows = $rows;
			$this->cols = $cols;
			$this->value = $value;
			$this->_atributs=$atributs;
			// Mostramos la obertura del textarea
			echo "<textarea name=\"".@$this->name."\" rows=\"".@$this->rows."\" cols=\"".@$this->cols."\" id=\"".@$this->_atributs["id"]."\" value=\"".@$this->value."\" placeholder=\"".@$this->_atributs["placeholder"]."\" ".@$this->_atributs["required"].">";
		}
			
		public function closeTextarea(){ // Cerramos el textarea
			echo "</textarea>";
		}
			
		
		
		public function addSelect($name, $values, $multiple){ // Creación de un select pasandole como parametros sus caracteristicas y un array de valores predefinidos
			$this->value=$values;
			$this->name=$name;
			
			if($multiple==1){ // Si la variable 'multiple' vale 1 
				echo "<select name='".$this->name."[]' multiple='multiple'>";
			}else{ // En caso contrario
				echo "<select name='".$this->name."'>";
			}
			
			while(list($values, $text)=each($this->value)){  // Asignamos a la variable '$value' los diferentes valores del array   
				echo "<option value='".$values."'>".$this->value[$values]."</option>"; // Mostramos las diferentes opciones del select
			}
			
			echo  "</select>";
		}
		
		public function addcheckradio($type,$name,$values,$selected=0,$id){ // Creación de un checkradio pasandole como valor un array y posteriormente guardamos las variables
			$this->value = $values;
			$this->selected = $selected;
			$this->type = $type;
			$this->id = $id;
				
			if ($this->type=="checkbox"){
				$this->name = $name."[]";
			}else{
				$this->name = $name;
			}
				
			$c=1;   
			
			while(list($val,$l)=each($this->value)){ // Asignamos a la variable '$value' los diferentes valores del array      
				if ($c==$this->selected){ //En caso de selecionar una opcion por defecto 
					$this->check = " checked/>";
				}else{
					$this->check = " />";
				}
				// Mostramos el checkradio 	
				echo "<label>".$this->value[$val]."</label><input type='".$this->type."' name='".$this->name."' id='".$this->id."'  value='".$val."'".$this->check."<br>";
				$c++;
			}
		}

		public function closefieldset(){ // Cerramos el fieldset
			echo "</fieldset>";
		}
			
		public function endForm(){ // Cerramos el formulario
			echo "</form>";
		}
			
	}
?>