<?php
	include_once 'core/init.php';  // Incluimos el archivo init.php que contiene las instancias de las diferentes clases 
	if(!$mi_sesion->getValor("usuario")==TRUE){ // Verificamos que el usuario haya iniciado sesion
		if(empty($_POST) === false){ // Comprobamos que las variables que se envian por POST no esten vacias
			// Validamos los campos requeridos del formulario
			if($cliente->getUserByName($_POST['nombre']) == false){
				$errors[] = 'Lo sentimos, el nombre de usuario no existe.';
			}else{
				if(strlen($_POST['password']) <6){
					$errors[] = 'Su contraseña debe tener al menos 6 caracteres';
				}else if(strlen($_POST['password']) >18){
					$errors[] = 'La contraseña no puede contener más de 18 caracteres.';
				}
				$cliente->login($_POST['nombre'],$_POST['password']); // Llamamos al método login para iniciar sesion
				if($cliente->consulta[1]!=null){ // Si existe el usuario
					foreach($cliente->consulta[1] as $valor){
						$valores[]=$valor; // Recogemos los valores de la consulta en un array "$valores"
					}
					if(!$mi_sesion->comprobarSesion("usuario")==TRUE){ // Comprobamos la existencia de la sesion 'usuario' 
						$mi_sesion->agregarSesion(array("usuario"=>$_POST["nombre"],"rol"=>$valores[3])); // Posteriormente la creamos en caso que no exista junto a su rol
					}
					if($valores[3]=="admin"){ // Si es admin accede a la administración de la página
						header("location:admin.php");
					}else{ // En caso contrario, se le redirrecionará directamente a la página
						header("location: tienda.php");
					}		
				}else{ // No existe el usuario
					$errors[] = 'Lo sentimos, el nombre de usuario o la password es invalido';
				}
			}
		} 
?>
<!DOCTYPE>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description" content="Aqui toda nuestra descripcion">
	<meta name="keywords" content="Aqui, Palabras, Clave">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" type="text/css" href="css/estilos.css"/>
	<title>Tu Tienda y la de más gente</title>
</head>
<body>
	<?php	
		$tag->openTag("div","contenedor","",""); // '$tag' es el objeto instanciado de la clase que nos permite crear elementos html como divs, label, echo, etc					
		// Agregamos y mostramos la cabecera de nuestra pagina
		$tag->openTag("div","header","","");
		$tag->output("<h1>TIENDA ONLINE</h1>");
		$tag->output("<img src='imagenes/tienda-online.png' class='classname'/>");
		$tag->closeTag("div");
		// Creamos y mostramos los enlaces creados	
		$menu->cargarEnlace('index.php','Home','menu1','seleccionado');
		$menu->cargarEnlace('registro.php','Registro','menu1','');
		$menu->mostrarHorizontal();	
		
		$tag->openTag("div","","detalles","");
		
		$tag->openTag("div","","datos3",""); /*** Este div contiene el formulario para iniciar sesión ***/
		$tag->output("<h2>Inicia Sesión!</h2>");						
		
		$tag->openTag("div","section_l","","");	
		
		$form->startForm("index.php","POST","form-logeo", array('name'=>'form1','class'=>'generic','enctype'=>'', 'onsubmit'=>'')); // Abrimos el formulario 
							
		$tag->openTag("label","","",array("for"=>"usuario")); 
		$tag->output("Usuario: "); 
		$tag->closeTag("label");						
		$input->addInput("text","nombre","",array("id"=>"nombre","placeholder"=>"usuario",'class'=>'text','size'=>16, "required"=>"required"));
		
		$tag->output("<br/>");
		
		$tag->openTag("label","","",array("for"=>"password"));		
		$tag->output("Contraseña: ");
		$tag->closeTag("label");	
		$input->addInput("password","password","",array("id"=>"password","placeholder"=>"password",'class'=>'text','size'=>16,"required"=>"required"));

		$input->addInput("submit","","Entra",array('id'=>'login-submit'));
		// En caso de no introducir correctamente los datos del formulario mostramos el error	
		if(empty($errors) === false){
			echo '<p>' . implode('</p><p>', $errors) . '</p>';	
		}
		$tag->output("<br/>");
		$form->endForm(); // Cerramos el formulario
		$tag->closeTag("div");	
		$tag->closeTag("div");	
		$tag->openTag("div","","datos4",""); /*** Este div contiene un slider de presentación de la pagina ***/
		
		$tag->output("<h2>Añade articulos en pocos pasos!</h2>");
	?>
	<!-- Inputs del Slider -->
	<input checked type="radio" name="slider" id="slide1" />
	<input type="radio" name="slider" id="slide2" />
	<input type="radio" name="slider" id="slide3" />
	<input type="radio" name="slider" id="slide4" />
	<input type="radio" name="slider" id="slide5" />
	<?php
		$tag->openTag("div","slides","","");
		
		$tag->openTag("div","overflow","","");
		
		$tag->openTag("div","","inner","");
		$i=0;
		for($i=1;$i<=5;$i++){ //Recorremos las diferentes imagenes que se encuentren en la ruta correspondiente
			$tag->output("<article>");
			$tag->output("<img src='imagenes/image$i.png' />");
			$tag->output("</article>");
		}
		$tag->closeTag("div");	
		
		$tag->closeTag("div");	
		
		$tag->closeTag("div");
		
		$tag->openTag("div","controls","",""); // Creación de los diferentes controles de las imágenes 
		for($i=1;$i<=5;$i++){ // Recorrera las imagenes mediante flechas a los costados
			$tag->output("<label for='slide$i'></label>");
		}
		$tag->closeTag("div");	
		
		$tag->openTag("div","active","","");
		for($i=1;$i<=5;$i++){ // Recorrera las imagenes mediante unos circulos
			$tag->output("<label for='slide$i'></label>");
		}
		$tag->closeTag("div");	
		
		$tag->closeTag("div");
		
		$tag->closeTag("div");
		// Agregamos y luego mostramos el footer de nuestra pagina
		$tag->openTag("div","footer","","");
		$tag->output("Desarrollado por Elmer Garcia Yavi - 2014");
		$tag->closeTag("div");
		$tag->closeTag("div");	
	?>
</body>
</html>
<?php
	}else{
		header("location: tienda.php");  // Si inicio sesion restringimos el acceso posterior al formulario redirreccionandolo a la 'tienda'
	}
?>