<?php
include_once('../core/init.php'); // Incluimos el archivo init.php que contiene las instancias de las diferentes clases 
include_once('../pdf/myDBC.php'); // Incluimos la clase myDBC que contiene los diferentes métodos de los pedidos
if($mi_sesion->getValor("usuario")==TRUE){ // Verificamos que el usuario haya iniciado sesion

?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<style>
	#contenido{
		width:25%;
		margin:10px auto;
		padding:20px 20px;
		height:auto;
		background:white;
	}
	</style>
</head>
<body bgcolor="grey">
		<?php
			$tag->openTag("div","contenido","",""); // '$tag' es el objeto instanciado de la clase que nos permite crear elementos html como divs, label, echo, etc
			// Instanciamos la clase que necesitaremos
			$consultaCliente = new myDBC();
			$consultaPedido = new myDBC();
			$consultaDetalle = new myDBC();
			$consultaProducto = new myDBC();
			$consultaEmail = new myDBC();

			$cliente->getUserByName($_SESSION["usuario"]); // Traer datos del cliente mediante el nombre 
			$id_cliente = $cliente->propiedad["id_cliente"]; // almacenamos el id del cliente en una variable
			$datosPersona = $consultaCliente->seleccionar_cliente($id_cliente); // Seleccionamos el cliente pasandole como parametro el id del cliente
			$email_cliente = $datosPersona[0]["email"];
			$datosPedido =$consultaPedido->seleccionar_pedido($id_cliente); // Traer datos del pedido pasandole como para el id del cliente
			$id_pedido = $datosPedido[0]["id_pedido"]; // Almacenamos la id del pedido
			$datosDetallesPedido = $consultaDetalle->seleccionar_detallesPedido($id_pedido); // Traer los diferentes detalles de los pedidos mediante su id
			foreach($datosDetallesPedido as $producto=>$values){
				$datosProducto = $consultaProducto->seleccionar_producto($values["codigo_articulo"]); // Traer datos de los diferentes productos del pedido mediante el codigo del articulo
			}
	
	
			//Enviamos los datos del formulario via email
			$email_message =  "<h2>Detalles del Cliente</h2><br/>";
			foreach($datosPersona as $key => $values){
				$email_message = "ID Cliente: ".$values["id_cliente"]."<br/>";
				$email_message = "Nif: ".$values["nif"]."<br/>";
				$email_message = "Nombre: ".$values["nombre"]."<br/>";
				$email_message = "Tel&eacute;fono: ".$values["telefono"]."<br/>";
				$email_message = "Direcci&oacute;n: ".$values["direccion"]."<br/>";
				$email_message = "Localidad: ".$values["localidad"]."<br/>";
				$email_message = "Prov&iacute;ncia: ".$values["provincia"]."<br/>";
				$email_message = "Pa&iacute;s: ".$values["pais"]."<br/>";
				$email_message = "C&oacute; Postal: ".$values["codigopostal"]."<br/>";
				$email_message = "Email: ".$values["email"]."<br/>";
			}
			
			$email_message = "<br/><h2>Detalles del Pedido</h2><br/>";
			foreach($datosPedido as $key => $values){
				$email_message = "ID Pedido: ".$values["id_pedido"]."<br/>";
				$email_message = "fecha: ".$values["fecha"]."<br/>";
			}
	
			foreach($datosProducto as $key=>$values){
				$email_message = "<br/>C&oacute;digo articulo: ".$values["codigo_articulo"]."<br/>";
				$email_message = "Nombre: ".$values["nombre"]."<br/>";
				$email_message = "Marca: ".$values["marca"]."<br/>";
				$email_message = "Precio: ".$values["precio"]."<br/>";
				$email_message = "Cantidad: ".$values["cantidad"]."<br/>";
			}
			
			$email_to =  $email_cliente;
			$email_subject = 'Tu tienda y la de más gente';

			// Ahora se envía el e-mail usando la función mail() de PHP
				@$header = $email_to;
				mail($email_to, $email_subject,$email_message, $header);
				
			// A continuación mostramos un vista previa de lo que recibira el cliente en su email
			echo "<h2>Detalles del Cliente</h2><br/>";
			foreach($datosPersona as $key => $values){
				echo "ID Cliente: <font color=blue size=\"1\">".$values["id_cliente"]."</font><br/>";
				echo "Nif: <font color=blue size=\"1\">".$values["nif"]."</font><br/>";
				echo "Nombre: <font color=blue size=\"1\">".$values["nombre"]."</font><br/>";
				echo "Tel&eacute;fono: <font color=blue size=\"1\">".$values["telefono"]."</font><br/>";
				echo "Direcci&oacute;n: <font color=blue size=\"1\">".$values["direccion"]."</font><br/>";
				echo "Localidad: <font color=blue size=\"1\">".$values["localidad"]."</font><br/>";
				echo "Prov&iacute;ncia: <font color=blue size=\"1\">".$values["provincia"]."</font><br/>";
				echo "Pa&iacute;s: <font color=blue size=\"1\">".$values["pais"]."</font><br/>";
				echo "C&oacute;digo Postal: <font color=blue size=\"1\">".$values["codigopostal"]."</font><br/>";
				echo "Email: <font color=blue size=\"1\">".$values["email"]."</font><br/>";
			}
	
			echo "<br/><h2>Detalles del Pedido</h2><br/>";
			foreach($datosPedido as $key => $values){
				echo "ID Pedido: <font color=blue size=\"1\">".$values["id_pedido"]."</font><br/>";
				echo "Fecha: <font color=blue size=\"1\">".$values["fecha"]."</font><br/>";
			}
	
			foreach($datosProducto as $key=>$values){
				echo "<br/>C&oacute;digo Articulo: <font color=blue size=\"1\">".$values["codigo_articulo"]."</font><br/>";
				echo "Nombre: <font color=blue size=\"1\">".$values["nombre"]."</font><br/>";
				echo "Marca: <font color=blue size=\"1\">".$values["marca"]."</font><br/>";
				echo "Precio: <font color=blue size=\"1\">".$values["precio"]."</font><br/>";
				echo "Cantidad: <font color=blue size=\"1\">".$values["cantidad"]."</font><br/><br/>";
			}
	
			echo "Enviado Exitosamente</br></br>";
			echo ("<a href='javascript:history.back(1)'>Regresar</a>");
			
			$tag->closeTag("div");
		?>
 </body>
</html>
<?php
	}else{ // Si no ha iniciado sesion restringimos el acceso a la tienda redirrecionandolo al index
	header("location:../index.php");
	}
?>