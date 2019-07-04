<?php 
	// Incluimos las diferentes clases 
	error_reporting(0);
	include_once 'classes/sesion.php';
	include_once 'classes/cliente.php';
	include_once 'classes/HtmlForm.php';
	include_once 'classes/tags.php';
	include_once 'classes/articulo.php';
	include_once 'classes/tags.php';
	include_once 'classes/HtmlEnlace.php';
	include_once 'carrito/Carrito.class.php';

	// Instanciamos cada una de las clases que necesitaremos 
	$cliente = new Cliente();   
	$mi_sesion = new Sesion();
	$errors = array();
	@$form = new HtmlForm();
	@$input = new HtmlForm();
	@$tag = new Tag();
	$articulo = new Articulo();
	$menu = new HtmlEnlace();
	$enlace = new HtmlEnlace();
	// Si no esta creado el objeto carrito en la sesion, lo creo
	if(!$mi_sesion->comprobarSesion("carrito")==TRUE){
		$mi_sesion->agregarSesion(array("carrito"=>new Carrito(session_id())));
	}
?>