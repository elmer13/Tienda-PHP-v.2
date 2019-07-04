<?php
	include_once '../carrito/Carrito.class.php'; // Incluimos la clase carrito
	include_once '../core/init.php'; // Incluimos el archivo init.php que contiene las instancias de las diferentes clases 
	if($mi_sesion->getValor("usuario")==TRUE){ // Verificamos que el usuario haya iniciado sesion
		if($mi_sesion->getValor("rol")=="admin"){ // Verificamos que el usuario que inicio sesión tenga rol de administrador
			$id_articulo=$_GET['date'];
			$articulo->getByCode($id_articulo);
	
		if (isset($_POST['submit2'])) {
				if (!$articulo->getByCode($_POST['codigo_articulo']) === false) {
					$errors[] = 'El codigo de articulo ya existe';
				}
				else{

				if (!ctype_alnum($_POST['codigo_articulo']) || strlen($_POST['codigo_articulo']) <5 || strlen($_POST['codigo_articulo'])>5){
					$errors[] = 'Por favor, introduzca un codigo con 5 caracteres alfanumericos';
				}
						if (isset($_FILES['myfile']) && !empty($_FILES['myfile']['name'])) {
							
							$name 			= $_FILES['myfile']['name'];
							$tmp_name 		= $_FILES['myfile']['tmp_name'];
							$allowed_ext 	= array('jpg', 'jpeg', 'png', 'gif' );
							$a 				= explode('.', $name);
							$file_ext 		= strtolower(end($a)); unset($a);
							$file_size 		= $_FILES['myfile']['size'];		
							$path 			= "fotoarticulo";
							
							if (in_array($file_ext, $allowed_ext) === false) {
								$errors[] = 'El tipo de archivo de imagen no esta permitido.';	
							}
							
							if ($file_size > 2097152) {
								$errors[] = 'El tamaño del archivo debe ser menor de 2mb.';
							}
							
						} else {
							$newpath = 'fotoarticulo/default_image.jpg';
						}
						
				}


	if(empty($errors) === true){
					if (isset($_FILES['myfile']) && !empty($_FILES['myfile']['name'])) {
				
						$newpath = $articulo->file_newpath($path, $name);

						move_uploaded_file($tmp_name, $newpath);

					}
					$avatar	= htmlentities(trim($newpath));
		$articulo->edit(array("codigo_articulo"=>$_POST["codigo_articulo"] , "id_categoria"=>$_POST["categoria"], "nombre"=>$_POST["nombre"],"marca"=>$_POST["marca"], "precio"=>$_POST["precio"], "fotoarticulo"=>$avatar,"descripcion"=>$_POST["descripcion"]));
		$correct[] = 'El articulo se realizó correctamente, actualize la pagina para ver los cambios.';
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
		$menu->cargarEnlace('buscar_modificar_articulo.php','Buscar / Modificar','menu','selected');
		$menu->cargarEnlace('eliminar_articulo.php','Eliminar','menu','');
		$menu->cargarEnlace('../cerrar_sesion.php','Salir','menu','');
		$menu->cargarEnlace('../tienda.php','Entrar como usuario normal->','menu','');
		$menu->mostrarHorizontal();	
		$tag->closeTag("menu");
		$tag->closeTag("div");
						
		$tag->openTag("div","contenedor","",""); // '$tag' es el objeto instanciado de la clase que nos permite crear elementos html como divs, label, echo, etc
						
		$tag->openTag("div","contenido","","");		
						
		$tag->openTag("h1","","","");
		$tag->output("Buscar / Modificar Articulo");
		$tag->closeTag("h1");
						
		if($articulo->propiedad["codigo_articulo"]==null){ // Si el codigo articulo es nulo "no existe"
			echo "no existe";
		}else{ //En caso contrario mostramos los detalles de ese articulo
			$tag->openTag("div","mostrar","",""); // '$tag' es el objeto instanciado de la clase que nos permite crear elementos html como divs,label, echo, etc
				echo "<img src=".$articulo->propiedad["fotoarticulo"]." width='190px' height='150px' alt='imagen'><br/>";
				echo "<br/><b>ID: </b>".$articulo->propiedad["codigo_articulo"];
				echo "<br/><b>ID Categoria: </b>".$articulo->propiedad["id_categoria"];
				echo "<br/><b>Nombre: </b>".$articulo->propiedad["nombre"];
				echo "<br/><b>Descripción: </b>".$articulo->propiedad["descripcion"];
				echo "<br/><b>Marca: </b>".$articulo->propiedad["marca"];
				echo "<br/><b>Precio: </b>".$articulo->propiedad["precio"]." €";
			$tag->closeTag("div");
			
			$tag->openTag("div","editar","","");
		
			$form->startForm("","POST","form-logeo", array('name'=>'frmempleado','class'=>'generic','enctype'=>'multipart/form-data', 'onsubmit'=>'')); // Abrimos el formulario 
				
			$tag->openTag("div","","","");						
			$tag->openTag("label","","",array("for"=>"codigo")); 
			$tag->output("Codigo: "); 
			$tag->closeTag("label");						
			$input->addInput("text","codigo_articulo",$articulo->propiedad["codigo_articulo"],array("id"=>"codigo","placeholder"=>"codigo",'class'=>'text','size'=>16, "readonly"=>"readonly","required"=>"required"));
			$tag->closeTag("div");
						
			$tag->openTag("div","","","");						
			$tag->openTag("label","","",array("for"=>"categoria"));	
			$tag->output("Categoria: ");
			$tag->closeTag("label");			
			$values = array(1=>"informatica",2=>"telefonia",3=>"fotografia",4=>"videojuegos");						
			$form->addSelect("categoria", $values,0);
			$tag->closeTag("div");	
						
			$tag->openTag("div","","","");
			$tag->openTag("label","","",array("for"=>"nombre")); 
			$tag->output("Nombre: "); 
			$tag->closeTag("label");						
			$input->addInput("text","nombre","",array("id"=>"nombre","placeholder"=>"nombre",'class'=>'text','size'=>16, "required"=>"required"));
			$tag->closeTag("div");
						
			$tag->openTag("div","","","");
			$tag->openTag("label","","",array("for"=>"marca")); 
			$tag->output("Marca: "); 
			$tag->closeTag("label");						
			$input->addInput("text","marca","",array("id"=>"marca","placeholder"=>"marca",'class'=>'text','size'=>16, "required"=>"required"));
			$tag->closeTag("div");
						
			$tag->openTag("div","","","");						
			$tag->openTag("label","","",array("for"=>"precio"));	
			$tag->output("Precio: ");
			$tag->closeTag("label");
			foreach(range(1, 1000) as $propiedad) { // Mostramos los primeros 100 numero con la función range en un select para que el usuario defina la cantidad										
				$valor[$propiedad]= $propiedad;
			}
			$form->addSelect("precio", $valor,0);
			$tag->closeTag("div");					
						
			$tag->openTag("div","","","");						
			$tag->openTag("label","","",array("for"=>"imagen")); 
			$tag->output("Imagen: "); 
			$tag->closeTag("label");						
			$input->addInput("file","myfile","",array("id"=>"imagen","placeholder"=>"imagen",'class'=>'text','size'=>16));
			$tag->closeTag("div");	
	
			$tag->openTag("div","","","");
			$tag->openTag("label","","",array("for"=>"descripcion"));	
			$tag->output("Descripción: ");
			$tag->closeTag("label");
			$form->addTextarea("descripcion",4,30,"",array("id"=>"descripcion","placeholder"=>"descripcion","required"=>"required"));
			$form->closeTextarea();
			$tag->closeTag("div");
						
			$input->addInput("reset","","Cancelar");
			$input->addInput("submit","submit2","Editar",array('id'=>'login-submit'));
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
		}
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