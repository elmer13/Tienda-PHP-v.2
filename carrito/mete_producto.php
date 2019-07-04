<?php
	include_once 'Carrito.class.php'; // Incluimos la clase carrito
	include_once '../core/init.php'; // Incluimos el archivo init.php que contiene las instancias de las diferentes clases 

	if($mi_sesion->getValor("usuario")==TRUE){ // Verificamos que el usuario haya iniciado sesion
		if($_POST["cantidad"]==NULL){ // Si la cantidad es nula la definimos por defecto a 1
			$_POST["cantidad"]=1;
		}
		// Introducimos los productos al carrito de acuerdo a los valores pasados por POST de cada uno de ellos
		if (isset($_SESSION['carrito']) || isset($_POST['codigo_articulo'])){ // Comprobamos que se hayan recibido el codigo articulo o la sesion carrito
			@$articulo->NameCategoryById($_POST['id_categoria']); // llamamos a un metodo que nos retorne el nombre de la categoria mediante su ID
			foreach($articulo->consulta[0] as $key=>$nombre_categoria){ // Recorremos el array y almacenamos en una variable el nombre de la categoria 
			}
			@$_SESSION["carrito"]->agregarProducto(array("codigo_articulo"=>@$_POST["codigo_articulo"],"nombre"=>@$_POST["nombre"],"marca"=> @$_POST["marca"],"categoria"=> @$nombre_categoria, "fotoarticulo"=>@$_POST["fotoarticulo"],"precio"=> @$_POST["precio"], "cantidad"=>@$_POST["cantidad"]));	
			header("location: ../categoria/informatica.php"); // Redireccionamos a una categoria de la tienda
		}

	}else{ // Si el usuario no ha iniciado sesión le redireccionamos al login
		header("location:../index.php"); 
	}
?>
