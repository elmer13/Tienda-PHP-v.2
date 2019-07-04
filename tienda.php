<?php
	include_once 'core/init.php'; // Incluimos el archivo init.php que contiene las instancias de las diferentes clases 
	if($mi_sesion->getValor("usuario")==TRUE){ // Verificamos que el usuario haya iniciado sesion
?>
<!DOCTYPE>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<meta name="description" content="Aqui toda nuestra descripcion">
	<meta name="keywords" content="Aqui, Palabras, Clave">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" type="text/css" href="css/estilos.css"/>
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
		$menu->cargarEnlace('tienda.php','Hola '.$_SESSION['usuario'].'!','menu','selected');
		$menu->cargarEnlace('categoria/informatica.php','Informática','menu','');
		$menu->cargarEnlace('categoria/telefonia.php','Telefonía','menu','');
		$menu->cargarEnlace('categoria/fotografia.php','Fotografía','menu','');
		$menu->cargarEnlace('categoria/videojuegos.php','Videojuegos','menu','');
		$menu->cargarEnlace('cerrar_sesion.php','Salir','menu','');
		// Nos aseguramos de que a la administración solo pueda acceder el usuario con ese rol definido
		if($mi_sesion->getValor("rol")=="admin"){
			$menu->cargarEnlace('admin.php','Panel de Administración','menu','');
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
		
		$tag->openTag("div","","item","");
		$tag->openTag("a","","",array('href'=>"carrito/ver_carrito.php")); // Creamos un enlace para que el cliente pueda ver el carrito
		$tag->output("Ver Carrito");
		$tag->closeTag("a");
		$tag->closeTag("div");
		
		$tag->closeTag("div");		
		
		$tag->openTag("div","contenido","","");		
		
		$tag->openTag("div","","mi_vi","");
		$tag->output("<h2>Bienvenido</h2>");
		$tag->output("<p>Bienvenidos a nuestra web, donde te ofrecemos los mejores productos que se pueden encontrar hoy en dia. </br>Como podrás observar, para hacer tu busqueda más placentera dividimos nuestros productos en diferentes categorias: Informática, Telefonía, Fotografía y Videojuegos.</p>");						
		$tag->closeTag("div");
		
		$tag->openTag("div","vision","mi_vi","");
		$tag->output("<h2>Nuestro Servicio</h2>");
		$tag->output("<p>Ofrecemos una amplia visión del producto para garantizarte la adquisión de cada uno de ellos, solo tendrás que añadir los productos que desees al carrito y una vez hayas terminado podrás generar un resumen del pedido mediante un PDF.</p>");
		$tag->closeTag("div");	
		
		$tag->closeTag("div");
		
		$tag->closeTag("div");	
	?>
</body>
</html>
<?php
	}else{ // Si no ha iniciado sesion restringimos el acceso al perfil de la tienda redirrecionandolo al index
		header("location:index.php");
	}
?>