<?php
	include_once 'core/init.php'; // Incluimos el archivo init.php que contiene las instancias de las diferentes clases 
	if($mi_sesion->getValor("usuario")==TRUE){ // Verificamos que el usuario haya iniciado sesion
	if($mi_sesion->getValor("rol")=="admin"){ // Verificamos que el usuario que inicio sesión tenga rol de administrador
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
		// Agregamos y mostramos la cabecera de nuestra pagina
		$tag->openTag("div","cabecera","","");
		$tag->openTag("div","logotipo","","");
		$tag->output("<a href='#'>PROJECTO</a>");
		$tag->closeTag("div");
		$tag->closeTag("div");
		// Creamos y mostramos los enlaces creados							
		$tag->openTag("div","nav","menu2","");
		$tag->openTag("menu","","","");
		$menu->cargarEnlace('admin.php','Admin','menu','selected');
		$menu->cargarEnlace('admin/agregar_articulo.php','Agregar','menu','');
		$menu->cargarEnlace('admin/buscar_modificar_articulo.php','Buscar / Modificar','menu','');
		$menu->cargarEnlace('admin/eliminar_articulo.php','Eliminar','menu','');
		$menu->cargarEnlace('cerrar_sesion.php','Salir','menu','');
		$menu->cargarEnlace('tienda.php','Entrar como usuario normal->','menu','');
		$menu->mostrarHorizontal();	
		$tag->closeTag("menu");
		$tag->closeTag("div");
						
		$tag->openTag("div","contenedor","",""); // '$tag' es el objeto instanciado de la clase que nos permite crear elementos html como divs, label, echo, etc
						
		$tag->openTag("div","contenido","","");	
		
		$tag->openTag("div","zona_admin","","");	
		
		$tag->openTag("div","","mi_vi2","");
		$tag->output("<h3>Bienvenido</h3>");
		$tag->output("<p>Bienvenido a la página <b>".$_SESSION['usuario']."</b>, usted esta registrado como administrador de la página por lo tanto tendra ciertos privilegios. Usted podrá:<br/> - &nbsp;Agregar, Buscar, Modificar y eliminar productos.<br/> - Acceder como cliente para asi poder realizar pedidos como lo haria un usuario habitualmente.</p>");						
		$tag->closeTag("div");
		
		$tag->openTag("div","vision2","mi_vi2","");
		$tag->output("<h3>Nuestro Servicio</h3>");
		$tag->output("<p>Ofrecemos una amplia visión del producto para garantizarte la adquisión de cada uno de ellos, solo tendrás que añadir los productos que desees al carrito y una vez hayas terminado podrás generar un resumen del pedido mediante un PDF.</p>");
		$tag->closeTag("div");	
		
		$tag->closeTag("div");
		
		$tag->closeTag("div");	
		
		$tag->closeTag("div");	
	?>
</body>
</html>
<?php
}else{ // Si el usuario no tiene rol de administrador le redireccionamos al perfil de la tienda
header("location: tienda.php");
}
}else{ // Si el usuario no ha iniciado sesión le redireccionamos al login
	header("location: index.php");
}
?>