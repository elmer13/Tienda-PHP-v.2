<?php
	include_once 'Carrito.class.php'; // Incluimos la clase carrito
	include_once '../core/init.php'; // Incluimos el archivo init.php que contiene las instancias de las diferentes clases 
	
	if($mi_sesion->getValor("usuario")==TRUE){ // Verificamos que el usuario haya iniciado sesion
		$_SESSION["carrito"]->eliminarProducto($_GET["linea"]); // Posteriormente elimino el producto determinado de la sesión
		header("location: ver_carrito.php"); // Redireccionamos con exito al carrito
	}else{ // Si el usuario no ha iniciado sesión le redireccionamos al login 
		header("location: ../index.php");
	}
?>
