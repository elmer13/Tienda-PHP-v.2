<?php
	include_once 'Carrito.class.php'; // Incluimos la clase carrito
	include_once '../core/init.php'; // Incluimos el archivo init.php que contiene las instancias de las diferentes clases 
	if($mi_sesion->getValor("usuario")==TRUE){ // Verificamos que el usuario haya iniciado sesion
		if(isset($_SESSION['carrito'])) $carrito = $_SESSION['carrito']; // Si existe la sesion carrito la guardamos en una variable
			if(isset ($_GET['action'])){ // Comprobamos que se haya recibido una acción mediante el metodo GET
				switch ($_GET['action']){ // Dependiendo de lo que reciba realizamos una acción u otra
					case 'vacear': // Vaceamos el carrito
						//Reemplazo el atributo carrito de la sesion con un objeto carrito sin productos
						$mi_sesion->agregarSesion(array("carrito"=>new Carrito(session_id())));
						$carrito = $_SESSION["carrito"];
						break;

					case 'guardar': // Guardamos los pedidos en el carrito
						$cliente->getUserByName($_SESSION["usuario"]); // Conseguimo los datos de usuario pasando como parametros la sesion 'usuario'
						$id_cliente = $cliente->propiedad["id_cliente"]; // almacenamos el id del cliente en una variable
						$carrito->guardarPedido($id_cliente,$carrito->productos); //  Guardamos los pedidos enviando como parametro el 'id_cliente' y sus diferentes productos
						$carrito->guardarDetalles($carrito->productos); // Una vez guardado el pedido, procedemos a guardar los detalles del mismo
						header("location:ver_carrito.php"); // Redireccionamos al carrito
						exit(); //Paramos el script
						break;
					case 'enviar':
						//Enviamos los datos del formulario via email
							$email_message = "Detalles de la matricula:\n\n";

							$email_to = 'elmer_03_12@hotmail.com';
							$email_subject = 'Formulario de registro FP 2013-14';

						// Ahora se envía el e-mail usando la función mail() de PHP
							@$header = $email_to;
							mail($email_to, $email_subject,$email_message, $header);
						//A continuación mostramos los datos del formulario al alumno
							echo "Nom i cognoms: <font color=blue size=\"1\">correcto</font><br/>";
							
							echo "Enviado Exitosamente</br></br>";
							header("location: ../carrito/ver_carrito.php");
							break;
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
		$menu->cargarEnlace('../tienda.php','Hola '.$_SESSION['usuario'].'!','menu','');
		$menu->cargarEnlace('../categoria/informatica.php','Inform&aacute;tica','menu','');
		$menu->cargarEnlace('../categoria/telefonia.php','Telefon&iacute;a','menu','');
		$menu->cargarEnlace('../categoria/fotografia.php','Fotograf&iacute;a','menu','');
		$menu->cargarEnlace('../categoria/videojuegos.php','Videojuegos','menu','');
		$menu->cargarEnlace('../cerrar_sesion.php','Salir','menu','');
		// Nos aseguramos de que a la administración solo pueda acceder el usuario con ese rol definido
		if($mi_sesion->getValor("rol")=="admin"){
			$menu->cargarEnlace('../admin.php','Panel de Administración','menu','');
		}
		$menu->mostrarHorizontal();	
		$tag->closeTag("menu");
		$tag->closeTag("div");
						
		$tag->openTag("div","contenedor","","");  // '$tag' es el objeto instanciado de la clase que nos permite crear elementos html como divs, label, echo, etc
	
		$tag->openTag("div","enlaces","","");
		
		$tag->openTag("div","","item2","");
		if($_SESSION['carrito']->calcularCantidad()==""){ // Si el carrito esta vacio lo indicamos
			$tag->output("Vacio [0]");
		}else{ // En caso contrario mostramos la cantidad de productos  que va añadiendo el usuario
			$tag->output("Productos: ".$_SESSION['carrito']->calcularCantidad());
		}
		$tag->closeTag("div");
		
		$tag->closeTag("div");						
		
		$tag->openTag("div","contenido","","");		
		
		$tag->openTag("div","seccion_carrito","","");
		
        $total = 0;
        if(count($carrito->productos)>0){
    ?>
			<form action="ver_carrito.php" method="get"> <!-- Colocamos todo dentro de un formulario por si el usuario desea realizar algunas acciones  -->
				<table border="0" class="productos_listado"> <!-- Creamos una tabla para mostra los productos del carrito -->
					<caption>Carrito de compras</caption> <!-- Titulos de las diferentes columnas -->
					<tr>
						<th width="40">&nbsp;</th>
						<th width="60">Cant.</th>
						<th width="70">C&oacute;digo</th>
						<th>Nombre</th>
						<th width="90">Precio unit.</th>
						<th width="90">Precio total</th>
					</tr>
					<?php
						foreach($carrito->productos as $producto){ // Recorremos el array carrito para coger los datos y posteriormente mostrarlos
					?>
					<tr> <!-- Mostramos los detalles de los diferentes productos del carrito -->
						<td align="center">
							<a href="javascript:void(0);"
							   onClick="window.location='eliminar_producto.php?linea=<?php echo $producto['codigo_articulo'] ;?>';">
								<img src="../imagenes/eliminar.png" alt="Eliminar" border="0" title="Eliminar"/>
							</a>
						</td>
						<td align="center"><?php echo $producto["cantidad"];?></td>
						<td align="center"><?php echo $producto["codigo_articulo"];?></td>
						<td align="center"><?php echo $producto["nombre"];?></td>
						<td align="center"><?php echo "&#8364;/. ".$producto["precio"];?></td>
						<td align="center"><?php echo "&#8364;/. ".$carrito->PrecioTotalPorProducto($producto["cantidad"],$producto["precio"]); ?></td>
					</tr>
					<?php		
					}
					?> <!-- Mostramos los totales calculados de los productos -->
					<tr> 
						<td class="td_linea" colspan="6"></td>
					</tr>
					<tr>
						<td colspan="5" align="left"><b>Monto:</b></td>
						<td align="center"><?php echo "&#8364;/. ".$carrito->calcularMonto(); ?></td>
					</tr>
					<tr>
						<td colspan="5" align="left"><b>Cantidad:</b></td>
						<td align="center"><?php echo $carrito->calcularCantidad(); ?></td>
					</tr>
					<tr>
						<td colspan="5" align="left"><b>Descuento:</b></td>
						<td align="center">%<?php echo $carrito->calcularDescuento() ; ?></td>
					</tr>
					<tr>
						<td colspan="5" align="left"><b>Total:</b></td>
						<td align="center"><?php echo "&#8364;/. ".$carrito->calcularPrecioTotal(); ?></td>
					</tr>
				</table> <!-- Cerramos la tabla -->
             <input type="button" value="Vacear Cesta" class="link_button" style="width:130px;" onclick="parent:location='ver_carrito.php?action=vacear'"/>
            <input type="button" name="confirmar"  value="Confirmar Pedido" class="link_button" style="width: 130px" onclick="parent:location='ver_carrito.php?action=guardar';"/>
            <input type="button" value="Generar PDF" class="link_button" style="width: 130px" onclick="parent:location='../pdf/creaPDF.php';"/>
            <input type="button" value="Enviar Email" class="link_button" style="width: 130px" onclick="parent:location='../email/envio_email.php';"/>
			</form> <!-- Cerramos el formulario -->
            <?php
				// En caso de no introducir correctamente los datos del formulario mostramos el error	
				if(empty($errors) === false){
					echo '<p>' . implode('</p><p>', $errors) . '</p>';	
				}
                }else{
                    echo 'No tiene ningun producto';
				}	
				$tag->closeTag("div");
				
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