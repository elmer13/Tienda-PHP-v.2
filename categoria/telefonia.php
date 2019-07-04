<?php
	include_once '../carrito/Carrito.class.php'; // Incluimos la clase carrito
	include_once '../core/init.php'; // Incluimos el archivo init.php que contiene las instancias de las diferentes clases 
	if($mi_sesion->getValor("usuario")==TRUE){ // Verificamos que el usuario haya iniciado sesion
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
		$menu->cargarEnlace('../tienda.php','Hola '.$_SESSION['usuario'].'!','menu','');
		$menu->cargarEnlace('informatica.php','Inform&aacute;tica','menu','');
		$menu->cargarEnlace('telefonia.php','Telefon&iacute;a','menu','selected');
		$menu->cargarEnlace('fotografia.php','Fotograf&iacute;a','menu','');
		$menu->cargarEnlace('videojuegos.php','Videojuegos','menu','');
		$menu->cargarEnlace('../cerrar_sesion.php','Salir','menu','');
		// Nos aseguramos de que a la administración solo pueda acceder el usuario con ese rol definido
		if($mi_sesion->getValor("rol")=="admin"){
			$menu->cargarEnlace('../admin.php','Panel de Administración','menu','');
		}
		$menu->mostrarHorizontal();	
		$tag->closeTag("menu");
		$tag->closeTag("div");
						
		$tag->openTag("div","contenedor","",""); // '$tag' es el objeto instanciado de la clase que nos permite crear elementos html como divs, label, echo, etc
		
		$tag->openTag("div","enlaces","","");
		
		$tag->openTag("div","","item2","");
		if($_SESSION['carrito']->calcularCantidad()==""){ // Si el carrito esta vacio lo indicamos
			$tag->output("Vacio [0]");
		}else{ // En caso contrario mostramos la cantidad de productos  que va añadiendo el usuario
			$tag->output("Productos: ".$_SESSION['carrito']->calcularCantidad());
		}
		$tag->closeTag("div");
		// Creamos un enlace para poder mostrar el enlace del carrito
		$tag->openTag("div","","item","");
		$tag->openTag("a","","",array('href'=>"../carrito/ver_carrito.php"));
		$tag->output("Ver Carrito");
		$tag->closeTag("a");
		$tag->closeTag("div");
		
		$tag->closeTag("div");
		
		$tag->openTag("div","contenido","","");		
						
		$articulo->getByCategory(2); // Dependiendo del tipo de categoria mostraremos unos articulos u otros
		if($articulo->consulta!=null){ // Si existen productos en esta categoria mostramos
			foreach($articulo->consulta as $key=>$values){ // Recorremos el array de la consulta
				$tag->openTag("div","","producto","");
				$tag->openTag("center","","","");	
				$tag->openTag("img","","",array('src'=>"../admin/".$values['fotoarticulo'].""));
				$tag->closeTag("img");
				$tag->closeTag("br");
				$tag->openTag("div","","campo","");
				$tag->output("".$values['nombre']);
				$tag->closeTag("div");
				$tag->openTag("div","","campo","");
				$tag->output("&#8364; ".$values['precio']);
				$tag->closeTag("div");
				$tag->openTag("a","","",array('href'=>"../detalles.php?codigo_articulo=".$values['codigo_articulo'].""));
				$tag->output("ver");
				$tag->closeTag("a");
				$tag->closeTag("br");
				$tag->closeTag("br");
				// Agregamos el producto en cuestión mediante el método POST 
				$form->startForm("../carrito/mete_producto.php","POST","form-logeo", array('name'=>'form1','class'=>'generic','enctype'=>'multipart/form-data', 'onsubmit'=>'')); // Abrimos el formulario 
				
				$input->addInput("image","imageField","",array('id'=>'imageField','src'=>"../imagenes/comprar.gif"));	
				$input->addInput("hidden","codigo_articulo",$values['codigo_articulo'],array('id'=>'codigo_articulo'));						
				$input->addInput("hidden","nombre",$values['nombre'],array('id'=>'nombre'));						
				$input->addInput("hidden","marca",$values['marca'],array('id'=>'marca'));						
				$input->addInput("hidden","id_categoria",$values['id_categoria'],array('id'=>'id_categoria'));		
				$input->addInput("hidden","fotoarticulo",$values['fotoarticulo'],array('id'=>'fotoarticulo'));
				$input->addInput("hidden","precio",$values['precio'],array('id'=>'precio'));
				$input->addInput("text","cantidad",1,array('id'=>'cantidad'));
				$form->endForm(); // Cerramos el formulario

				$tag->closeTag("center");
				$tag->closeTag("div");
			}
		}else{
			$tag->output("No se encuentran productos");
		}
						
		$tag->closeTag("div");
		
		$tag->closeTag("div");	
	?>
</body>
</html>
<?php
	}else{ // Si el usuario no ha iniciado sesión le redireccionamos al login
		header("location: ../index.php");
	}
?>