<?php
	class HtmlEnlace{
		// Definimos los atributos de la clase HtmlEnlace como privados
		private $enlaces=array();
		private $titulos=array();
		
		public function cargarEnlace($en,$tit,$id,$clase){ // Agregamos los diferentes enlaces y los guardamos en los arrays 
			$this->enlaces[]=$en;
			$this->titulos[]=$tit;
			$this->id=$id;
			$this->clase[]=$clase;
		}
		
		public function mostrarHorizontal(){ // Mostramos los enlaces horizontalmente
			echo '<div id='.$this->id.'>';
			echo '<ul>';
			for($f=0;$f<count($this->enlaces);$f++){ // Recorremos los enlaces para agregarle sus diferentes titulos y enlaces 'href'
				echo '<li style="float:left;"><a href="'.$this->enlaces[$f].'" class="'.$this->clase[$f].'">'.$this->titulos[$f].'</a></li>'; //	float:left tiene una influencia importante para que se muestre de esta manera
			}
			echo '</ul>';
			echo '</div>';
		}
	  
		public function mostrarVertical(){ // Mostramos los enlaces horizontalmente
			echo '<div id='.$this->id.'>';
			echo '<ul>';	
			for($f=0;$f<count($this->enlaces);$f++){ // Recorremos los enlaces para agregarle sus diferentes titulos y enlaces 'href'
				echo '<li><a href="'.$this->enlaces[$f].'" class="'.$this->clase[$f].'">'.$this->titulos[$f].'</a></li>';
			}
			echo '</ul>';
			echo '</div>';
		}
	}
?>
