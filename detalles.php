<?php
	include_once 'core/init.php'; // Incluimos el archivo init.php que contiene las instancias de las diferentes clases
	if($mi_sesion->getValor("usuario")==TRUE){ // Verificamos que el usuario haya iniciado sesion
		if(isset($_GET['codigo_articulo'])){ // Comprobamos que se haya recibido una variable mediante el metodo GET
			$articulo->getByCode($_GET['codigo_articulo']);
		}else{ // En caso contrario redireccionamos a la tienda
			header("location:tienda.php"); 
		}
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
		$menu->cargarEnlace('tienda.php','Hola '.$_SESSION['usuario'].'!','menu','selected');
		$menu->cargarEnlace('categoria/informatica.php','Inform&aacute;tica','menu','');
		$menu->cargarEnlace('categoria/telefonia.php','Telefon&iacute;a','menu','');
		$menu->cargarEnlace('categoria/fotografia.php','Fotograf&iacute;a','menu','');
		$menu->cargarEnlace('categoria/videojuegos.php','Videojuegos','menu','');
		$menu->cargarEnlace('cerrar_sesion.php','Salir','menu','');
		// Nos aseguramos de que a la administración solo pueda acceder el usuario con ese rol definido
		if($mi_sesion->getValor("rol")=="admin"){
			$menu->cargarEnlace('admin.php','Panel de Administraci&oacute;n','menu','');
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
					
		$id_categoria=$articulo->propiedad["id_categoria"]; // Recogemos el id de la categoria
		$articulo->NameCategoryById($id_categoria); // llamamos a un metodo en el que le pasamos como parametro el id de la categoria 
		foreach($articulo->consulta[1] as $key=>$nombre_categoria){ // Cogemos el nombre de la categoria  en la variable '$nombre_categoria'
		}
		$tag->openTag("div","","detalles2","");
		
		$tag->openTag("div","","datos1","");	
		$tag->openTag("center","","","");
		$tag->output("<img src='admin/".@$articulo->propiedad['fotoarticulo']."' width='300px' height='350px'>");
		// Agregamos el producto en cuestión mediante el método POST 
		$form->startForm("carrito/mete_producto.php","POST","form-logeo2", array('name'=>'form1','class'=>'generic2','enctype'=>'multipart/form-data', 'onsubmit'=>'')); // Abrimos el formulario 
		
		$input->addInput("image","imageField","",array('id'=>'imageField','src'=>"imagenes/comprar.gif"));	
		$input->addInput("hidden","codigo_articulo",@$articulo->propiedad['codigo_articulo'],array('id'=>'codigo_articulo'));						
		$input->addInput("hidden","nombre",@$articulo->propiedad['nombre'],array('id'=>'nombre'));						
		$input->addInput("hidden","marca",@$articulo->propiedad['marca'],array('id'=>'marca'));						
		$input->addInput("hidden","id_categoria",@$articulo->propiedad['id_categoria'],array('id'=>'id_categoria'));		
		$input->addInput("hidden","fotoarticulo",@$articulo->propiedad["fotoarticulo"],array('id'=>'fotoarticulo'));
		$input->addInput("hidden","precio",@$articulo->propiedad["precio"],array('id'=>'precio'));
		$input->addInput("text","cantidad",1,array('id'=>'cantidad'));
	
		$form->endForm(); // Cerramos el formulario

		$tag->closeTag("center");
		$tag->closeTag("div");	
		// Mostramos los detalles de un producto determinado
		$tag->openTag("div","","datos2","");	
		$tag->output("<br/><b>C&oacute;digo: </b>".$articulo->propiedad["codigo_articulo"]);
		$tag->output("<br/><b>Nombre: </b>".$articulo->propiedad["nombre"]);
		$tag->output("<br/><b>Marca: </b>".$articulo->propiedad["marca"]);
		$tag->output("<br/><b>Descripci&oacute;n: </b>".$articulo->propiedad["descripcion"]);
		$tag->output("<br/><b>Categoria: </b>".$nombre_categoria."");
		$tag->output("<br/><b>Precio: </b>".$articulo->propiedad["precio"]." &#8364;");
		$tag->closeTag("div");
		
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