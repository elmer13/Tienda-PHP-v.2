<?php
	include_once 'core/init.php'; // Incluimos el archivo init.php que contiene las instancias de las diferentes clases 
	if(!$mi_sesion->getValor("usuario")==TRUE){ // Verificamos que el usuario haya iniciado sesion
		if(isset($_POST['submit'])){ // Comprobamos que se haya recibido la variable POST del 'submit'
			// Validamos los campos requeridos del formulario
			if($cliente->getUserByNif($_POST['nif']) === true){
				$errors[] = 'El nif de cliente ya existe';
			}else{
				if($cliente->getUserByName($_POST['nombre']) === true){
					$errors[] = 'El nombre de usuario ya existe';
				}
				if(!ctype_alnum($_POST['nombre'])){
					$errors[] = 'Por favor, introduzca un usuario con sólo letras y números';	
				}
				if(strlen($_POST['password']) <6){
					$errors[] = 'Su contraseña debe tener al menos 6 caracteres';
				} else if(strlen($_POST['password']) >18){
					$errors[] = 'La contraseña no puede contener más de 18 caracteres.';
				}
				if(!ctype_digit($_POST['telefono'])){
					$errors[] = 'Por favor, introduzca un telefono con sólo y números';	
				}
				if(!ctype_digit($_POST['codigopostal']) || strlen($_POST['codigopostal']) <5 || strlen($_POST['codigopostal'])>5){
					$errors[] = 'Su codigo postal debe tener 5 caracteres numericos';
				}
				if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false){
					$errors[] = 'Por favor, introduzca un correo válido';
				}
			}
			if(empty($errors) === true){ // Si no hay errores, llamamos a un método 'setUser' enviando las diferentes variables recibidas por POST
				if($cliente->setUser(array("nif"=>$_POST["nif"] , "nombre"=>$_POST["nombre"], "password"=>$_POST["password"],"telefono"=>$_POST["telefono"] , "direccion"=>$_POST["direccion"],"localidad"=>$_POST["localidad"] , "provincia"=>$_POST["provincia"], "pais"=>$_POST["pais"], "codigopostal"=>$_POST["codigopostal"],  "email"=>$_POST["email"]))==true){
					header("location: index.php"); // Si se registro correctamente nos enviará directamente al login de inicio de sesion
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
		$tag->openTag("div","contenedor","",""); // '$tag' es el objeto instanciado de la clase que nos permite crear elementos html como divs,label, echo, etc					
		// Agregamos y mostramos la cabecera de nuestra pagina
		$tag->openTag("div","header","","");
		$tag->output("<h1>TIENDA ONLINE</h1>");
		$tag->output("<img src='imagenes/tienda-online.png' class='classname'/>");
		$tag->closeTag("div");
		// Creamos y mostramos los enlaces creados	
		$menu->cargarEnlace('index.php','Home','menu1','');
		$menu->cargarEnlace('registro.php','Registro','menu1','seleccionado');
		$menu->mostrarHorizontal();	
		
		$tag->openTag("div","","detalles","");
		
		$tag->openTag("div","","datos3",""); /*** Este div contiene el formulario para iniciar sesión ***/	
		$tag->output("<h2>Registro</h2>");	
		
		$form->startForm("","POST","form-logeo", array('name'=>'frmempleado','class'=>'generic','enctype'=>'', 'onsubmit'=>'')); // Abrimos el formulario 
						
		$tag->openTag("div","","line","");	
		$tag->openTag("label","","",array("for"=>"nif")); 
		$tag->output("Nif: "); 
		$tag->closeTag("label");						
		$input->addInput("text","nif","",array("id"=>"nif","placeholder"=>"nif",'class'=>'text','size'=>16,  "required"=>"required"));
		$tag->closeTag("div");

		$tag->openTag("div","","line","");	
		$tag->openTag("label","","",array("for"=>"nombre")); 
		$tag->output("Nombre: "); 
		$tag->closeTag("label");						
		$input->addInput("text","nombre","",array("id"=>"nombre","placeholder"=>"nombre",'class'=>'text','size'=>16, "required"=>"required"));
		$tag->closeTag("div");	

		$tag->openTag("div","","line","");		
		$tag->openTag("label","","",array("for"=>"password"));		
		$tag->output("Contraseña: ");
		$tag->closeTag("label");	
		$input->addInput("password","password","",array("id"=>"password","placeholder"=>"contraseña",'class'=>'text','size'=>16,"required"=>"required"));
		$tag->closeTag("div");
						
		$tag->openTag("div","","line","");
		$tag->openTag("label","","",array("for"=>"telefono")); 
		$tag->output("Telefono: "); 
		$tag->closeTag("label");						
		$input->addInput("text","telefono","",array("id"=>"telefono","placeholder"=>"telefono",'class'=>'text','size'=>16, "required"=>"required"));
		$tag->closeTag("div");

		$tag->openTag("div","","line","");
		$tag->openTag("label","","",array("for"=>"direccion")); 
		$tag->output("Dirección: "); 
		$tag->closeTag("label");						
		$input->addInput("text","direccion","",array("id"=>"direccion","placeholder"=>"direccion",'class'=>'text','size'=>16, "required"=>"required"));
		$tag->closeTag("div");

		$tag->openTag("div","","line","");
		$tag->openTag("label","","",array("for"=>"localidad")); 
		$tag->output("Localidad: "); 
		$tag->closeTag("label");						
		$input->addInput("text","localidad","",array("id"=>"localidad","placeholder"=>"localidad",'class'=>'text','size'=>16, "required"=>"required"));
		$tag->closeTag("div");

		$tag->openTag("div","","line","");
		$tag->openTag("label","","",array("for"=>"provincia")); 
		$tag->output("Provincia: "); 
		$tag->closeTag("label");						
		$input->addInput("text","provincia","",array("id"=>"provincia","placeholder"=>"provincia",'class'=>'text','size'=>16, "required"=>"required"));
		$tag->closeTag("div");

		$tag->openTag("div","","line","");
		$tag->openTag("label","","",array("for"=>"pais")); 
		$tag->output("Pais: "); 
		$tag->closeTag("label");						
		$input->addInput("text","pais","",array("id"=>"pais","placeholder"=>"pais",'class'=>'text','size'=>16, "required"=>"required"));
		$tag->closeTag("div");

		$tag->openTag("div","","line","");
		$tag->openTag("label","","",array("for"=>"codigopostal")); 
		$tag->output("CP: "); 
		$tag->closeTag("label");						
		$input->addInput("text","codigopostal","",array("id"=>"codigopostal","placeholder"=>"codigo postal",'class'=>'text','size'=>16, "required"=>"required"));
		$tag->closeTag("div");	
						
		$tag->openTag("div","","line","");
		$tag->openTag("label","","",array("for"=>"email")); 
		$tag->output("Email: "); 
		$tag->closeTag("label");						
		$input->addInput("text","email","",array("id"=>"email","placeholder"=>"email",'class'=>'text','size'=>16, "required"=>"required"));
		$tag->closeTag("div");
						
		$input->addInput("reset","","Cancelar",array('id'=>'reset2'));
		$input->addInput("submit","submit","Registrarse",array('id'=>'submit2'));
		// En caso de no introducir correctamente los datos del formulario mostramos el error
		if(empty($errors) === false){
			echo '<p>' . implode('</p><p>', $errors) . '</p>';	
		}
		$tag->output("<br/>");
		$form->endForm(); // Cerramos el formulario
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
		for($i=1;$i<=5;$i++){
			$tag->output("<label for='slide$i'></label>"); // Recorrera las imagenes mediante flechas a los costados
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