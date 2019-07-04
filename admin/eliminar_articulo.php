<?php
	include_once '../carrito/Carrito.class.php'; // Incluimos la clase carrito
	include_once '../core/init.php'; // Incluimos el archivo init.php que contiene las instancias de las diferentes clases 
	if($mi_sesion->getValor("usuario")==TRUE){ // Verificamos que el usuario haya iniciado sesion
		if($mi_sesion->getValor("rol")=="admin"){ // Verificamos que el usuario que inicio sesión tenga rol de administrador
			if(isset($_POST['submit'])){ // Comprobamos que se haya recibido la variable POST del 'submit'
				if($articulo->getByCode($_POST['codigo_articulo']) == null){ // Nos aseguramos que no sea nulo 
					$errors[] = 'Lo sentimos, el codigo de articulo no existe.';
				}
					
				if(empty($errors) === true){ // Si no hay errores, llamamos a un método 'detele' enviando la variable recibida por POST

					$articulo->delete($_POST["codigo_articulo"]);
					$correct[] = 'El articulo se eliminó correctamente.';
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
	<link rel="stylesheet" type="text/css" href="../css/estilos.css"/>
	<title>Tu Tienda y la de más gente</title>
</head>
<body>
  	<?php
		// Agregamos y mostramos la cabecera de nuestra pagina
		$tag->openTag("div","cabecera","","");
		$tag->openTag("div","logotipo","","");
		$tag->output("<a href='#'>PROJECTO</a>");
		$tag->closeTag("div");
		$tag->closeTag("div");
		// Creamos y mostramos los enlaces creados	
		$tag->openTag("div","nav","menu2","");
		$tag->openTag("menu","","","");
		$menu->cargarEnlace('../admin.php','Admin','menu','');
		$menu->cargarEnlace('agregar_articulo.php','Agregar','menu','');
		$menu->cargarEnlace('buscar_modificar_articulo.php','Buscar / Modificar','menu','');
		$menu->cargarEnlace('eliminar_articulo.php','Eliminar','menu','selected');
		$menu->cargarEnlace('../cerrar_sesion.php','Salir','menu','');
		$menu->cargarEnlace('../tienda.php','Entrar como usuario normal->','menu','');
		$menu->mostrarHorizontal();	
		$tag->closeTag("menu");
		$tag->closeTag("div");
						
		$tag->openTag("div","contenedor","",""); // '$tag' es el objeto instanciado de la clase que nos permite crear elementos html como divs, label, echo, etc
						
		$tag->openTag("div","contenido","","");	
		
		$tag->openTag("div","zona_admin","","");	
		
		$tag->openTag("h1","","","");
		$tag->output("Eliminar Articulo");
		$tag->closeTag("h1");
						
						
		$form->startForm("","POST","form-logeo", array('name'=>'frmempleado','class'=>'generic','enctype'=>'multipart/form-data', 'onsubmit'=>'')); // Abrimos el formulario 

		$tag->openTag("div","","line","");						
		$tag->openTag("label","","",array("for"=>"codigo")); 
		$tag->output("Codigo: "); 
		$tag->closeTag("label");						
		$input->addInput("text","codigo_articulo","",array("id"=>"codigo","placeholder"=>"Codigo Articulo",'class'=>'text','size'=>16, "required"=>"required"));
		$tag->closeTag("div");
						
		$input->addInput("reset","","Cancelar",array('id'=>'reset'));
		$input->addInput("submit","submit","Eliminar",array('id'=>'submit'));
		// En caso de no introducir correctamente los datos del formulario mostramos el error
		if(empty($errors) === false){
			echo '<p>' . implode('</p><p>', $errors) . '</p>';	
		}
		// En caso de introducir correctamente los datos del formulario mostramos un mensaje
		if(empty($correct) === false){
			echo '<p>' . implode('</p><p>', $correct) . '</p>';	
		}
		$tag->output("<br/>");
		$form->endForm(); // Cerramos el formulario
		$tag->closeTag("div");	
		$tag->closeTag("div");	
		$tag->closeTag("div");	
	?>
</body>
</html>
<?php
		}else{ // Si el usuario no tiene rol de administrador le redireccionamos al perfil de la tienda
		header("location: ../tienda.php");
		}
	}else{ // Si el usuario no ha iniciado sesión le redireccionamos al login
		header("location: ../index.php");
	}
?>