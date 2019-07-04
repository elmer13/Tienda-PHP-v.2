<?php
	include_once '../carrito/Carrito.class.php'; // Incluimos la clase carrito
	include_once '../core/init.php'; // Incluimos el archivo init.php que contiene las instancias de las diferentes clases 
	if($mi_sesion->getValor("usuario")==TRUE){ // Verificamos que el usuario haya iniciado sesion
		if($mi_sesion->getValor("rol")=="admin"){ // Verificamos que el usuario que inicio sesión tenga rol de administrador
			if(isset($_GET['nombre'])){ // Comprobamos que se haya recibido una variable mediante el metodo GET
				if($articulo->getByName($_GET['nombre']) == null){ // Nos aseguramos que no sea nulo 
				$errors[] = 'El nombre de articulo no existe.';
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
		
		$tag->openTag("div","zona_admin","","");
		
		$tag->openTag("h1","","","");
		$tag->output("Buscar / Modificar Articulo");
		$tag->closeTag("h1");
		
		if($articulo->consulta==null){ // Siempre y cuando la consulta sea nula mostramos el formulario de busqueda
			$form->startForm("","GET","form-logeo", array('name'=>'frmempleado','class'=>'generic','enctype'=>'multipart/form-data', 'onsubmit'=>'')); // Abrimos el formulario 

			$tag->openTag("div","","line","");						
			$tag->openTag("label","","",array("for"=>"codigo")); 
			$tag->output("Nombre: "); 
			$tag->closeTag("label");						
			$input->addInput("text","nombre","",array("id"=>"nombre","placeholder"=>"Nombre",'class'=>'text','size'=>16, "required"=>"required"));
			$tag->closeTag("div");
						
			$input->addInput("reset","","Cancelar",array('id'=>'reset'));
			$input->addInput("submit","","Buscar",array('id'=>'submit'));
			// En caso de no introducir correctamente los datos del formulario mostramos el error
			if(empty($errors) === false){
				echo '<p>' . implode('</p><p>', $errors) . '</p>';	
			}
			$tag->output("<br/>");
			$form->endForm(); // Cerramos el formulario
		}else{ // Si la consulta es diferente de nulo, significa que se ha ejecutado la consulta, por lo tanto mostramos los resultados
			echo "Resultados encontrados: ".count($articulo->consulta);
			foreach($articulo->consulta as $key=>$values){ // Recorremos los diferentes resultados y mostramos sus diferentes enlaces en una tabla
			?>
				<table width="100%" border="0" style="border-top:1px dashed #ccc">
					<tr>
						<td width="294" align="left" style="padding:10px"><a href="ver_articulo.php?date=<?php echo $values["codigo_articulo"];?>"><?php echo $values['nombre'];?></a></td>
						<td width="271" align="right" style="text-align:right;padding:10px;"><span style="font-size:12px;"><?php echo $row_DatosListado['fecha'];?></span></td>
					</tr>
				</table>
			<?php
			}
		}
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