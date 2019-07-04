<?php
	include_once '../carrito/Carrito.class.php'; // Incluimos la clase carrito
	include_once '../core/init.php'; // Incluimos el archivo init.php que contiene las instancias de las diferentes clases 
	if($mi_sesion->getValor("usuario")==TRUE){ // Verificamos que el usuario haya iniciado sesion
		if($mi_sesion->getValor("rol")=="admin"){ // Verificamos que el usuario que inicio sesión tenga rol de administrador
			if(isset($_POST['submit'])){ // Comprobamos que se haya recibido la variable POST del 'submit'
				// Validamos los campos requeridos del formulario
				if($articulo->getByCode($_POST['codigo_articulo']) === true){
					$errors[] = 'El codigo de articulo ya existe';
				}else{
					if(!ctype_alnum($_POST['codigo_articulo']) || strlen($_POST['codigo_articulo']) <5 || strlen($_POST['codigo_articulo'])>5){
						$errors[] = 'Por favor, introduzca un codigo con 5 caracteres alfanumericos';
					}
					if(isset($_FILES['myfile']) && !empty($_FILES['myfile']['name'])){
						
						$name 			= $_FILES['myfile']['name'];
						$tmp_name 		= $_FILES['myfile']['tmp_name'];
						$allowed_ext 	= array('jpg', 'jpeg', 'png', 'gif' );
						$a 				= explode('.', $name);
						$file_ext 		= strtolower(end($a)); unset($a);
						$file_size 		= $_FILES['myfile']['size'];		
						$path 			= "fotoarticulo";
						
						if(in_array($file_ext, $allowed_ext) === false){
							$errors[] = 'El tipo de archivo de imagen no esta permitido.';	
						}
						
						if($file_size > 2097152){
							$errors[] = 'El tamaño del archivo debe ser menor de 2mb.';
						}
						
					} else {
						$newpath = 'fotoarticulo/default_image.jpg';
					}
				
				}
				if(empty($errors) === true){  // Si no hay errores, llamamos a un método 'setArticle' enviando las diferentes variables recibidas por POST
								if(isset($_FILES['myfile']) && !empty($_FILES['myfile']['name'])){
							
									$newpath = $articulo->file_newpath($path, $name);

									move_uploaded_file($tmp_name, $newpath);

								}
								$avatar	= htmlentities(trim($newpath));
					$articulo->setArticle(array("codigo_articulo"=>$_POST["codigo_articulo"] , "id_categoria"=>$_POST["categoria"], "nombre"=>$_POST["nombre"],"marca"=>$_POST["marca"], "precio"=>$_POST["precio"], "fotoarticulo"=>$avatar,"descripcion"=>$_POST["descripcion"]));
					$correct[] = 'El articulo se agregó correctamente.';
				}
			}	


 ?>
 <!DOCTYPE>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description" content="Aqui toda nuestra descripcion">
	<meta name="keywords" content="Aqui, Palabras, Clave">
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
		$menu->cargarEnlace('agregar_articulo.php','Agregar','menu','selected');
		$menu->cargarEnlace('buscar_modificar_articulo.php','Buscar / Modificar','menu','');
		$menu->cargarEnlace('eliminar_articulo.php','Eliminar','menu','');
		$menu->cargarEnlace('../cerrar_sesion.php','Salir','menu','');
		$menu->cargarEnlace('../tienda.php','Entrar como usuario normal->','menu','');
		$menu->mostrarHorizontal();	
		$tag->closeTag("menu");
		$tag->closeTag("div");
						
		$tag->openTag("div","contenedor","",""); // '$tag' es el objeto instanciado de la clase que nos permite crear elementos html como divs, label, echo, etc
		
		$tag->openTag("div","contenido","","");		
		
		$tag->openTag("div","zona_admin","","");	
		
		$tag->openTag("h1","","","");
		$tag->output("Agregar Articulo");
		$tag->closeTag("h1");
						
		$form->startForm("","POST","", array('name'=>'frmempleado','class'=>'generic','enctype'=>'multipart/form-data', 'onsubmit'=>'')); // Abrimos el formulario 

		$tag->openTag("div","","line","");						
		$tag->openTag("label","","",array("for"=>"codigo")); 
		$tag->output("Codigo: "); 
		$tag->closeTag("label");						
		$input->addInput("text","codigo_articulo","",array("id"=>"codigo","placeholder"=>"codigo",'class'=>'text','size'=>16, "required"=>"required"));
		$tag->closeTag("div");
						
		$tag->openTag("div","","line","");						
		$tag->openTag("label","","",array("for"=>"categoria"));	
		$tag->output("Categoria: ");
		$tag->closeTag("label");			
		$values = array(1=>"informatica",2=>"telefonia",3=>"fotografia",4=>"videojuegos");						
		$form->addSelect("categoria", $values,0);
		$tag->closeTag("div");	
						
		$tag->openTag("div","","line","");
		$tag->openTag("label","","",array("for"=>"nombre")); 
		$tag->output("Nombre: "); 
		$tag->closeTag("label");						
						$input->addInput("text","nombre","",array("id"=>"nombre","placeholder"=>"nombre",'class'=>'text','size'=>16, "required"=>"required"));
		$tag->closeTag("div");
						
		$tag->openTag("div","","line","");
		$tag->openTag("label","","",array("for"=>"marca")); 
		$tag->output("Marca: "); 
		$tag->closeTag("label");						
						$input->addInput("text","marca","",array("id"=>"marca","placeholder"=>"marca",'class'=>'text','size'=>16, "required"=>"required"));
		$tag->closeTag("div");
						
		$tag->openTag("div","","line","");						
		$tag->openTag("label","","",array("for"=>"precio"));	
		$tag->output("Precio: ");
		$tag->closeTag("label");
						foreach(range(1, 1000) as $propiedad){ // Mostramos los primeros 100 numero con la función range en un select para que el usuario defina la cantidad										
						$valor[$propiedad]= $propiedad;

						}
						$form->addSelect("precio", $valor,0);
		$tag->closeTag("div");					
						
		$tag->openTag("div","","line","");						
		$tag->openTag("label","","",array("for"=>"imagen")); 
		$tag->output("Imagen: "); 
		$tag->closeTag("label");						
		$input->addInput("file","myfile","",array("id"=>"imagen","placeholder"=>"imagen",'class'=>'text','size'=>16));
		$tag->closeTag("div");	
	
		$tag->openTag("div","","line","");
		$tag->openTag("label","","",array("for"=>"descripcion"));	
		$tag->output("Descripci&oacute;n: ");
		$tag->closeTag("label");
		$form->addTextarea("descripcion",5,41,"",array("id"=>"descripcion","placeholder"=>"descripcion","required"=>"required"));
		$form->closeTextarea();
		$tag->closeTag("div");
						
		$input->addInput("reset","","Cancelar",array('id'=>'reset'));
		$input->addInput("submit","submit","Guardar",array('id'=>'submit'));
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