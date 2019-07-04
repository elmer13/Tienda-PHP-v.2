<?php
include_once('../core/init.php');
include_once('pdf.php');
include_once('myDBC.php');
if($mi_sesion->getValor("usuario")==TRUE){ // Verificamos que el usuario haya iniciado sesion

    $pdf = new PDF();
    $pdf->AddPage('P', 'Letter'); //Vertical, Carta
    $pdf->SetFont('Arial','B',12); //Arial, negrita, 12 puntos
	
    $pdf->Ln();
 
    $pdf->ImprimirTexto('textoFijo.txt'); //Texto fijo
 
    //Creamos objeto de la clase myDBC
    //para hacer uso del método seleccionar_persona()
    $consultaCliente = new myDBC();
	$consultaPedido = new myDBC();
	$consultaDetalle = new myDBC();
	$consultaProducto = new myDBC();
	$cliente->getUserByName($_SESSION["usuario"]);
	$id_cliente = $cliente->propiedad["id_cliente"];
	
    $datosPersona = $consultaCliente->seleccionar_cliente($id_cliente);
    $cabecera = array('ID Cliente', 'Nif', 'Nombre', 'Telefono', 'Direccion', 'Localidad', 'Provincia', 'Pais', 'Codigo postal', 'Email');
	$pdf->Ln();
    $pdf->tabla($cabecera,$datosPersona); //Método que integra a cabecera y datos
	
	
	$datosPedido =$consultaPedido->seleccionar_pedido($id_cliente);
	$header=array('ID Pedido','Fecha de Pedido');
	$pdf->SetXY(60,211);
	$pdf->TablaPedido($header,$datosPedido);

 
		
	$id_pedido = $datosPedido[0]["id_pedido"];
	$datosDetallesPedido = $consultaDetalle->seleccionar_detallesPedido($id_pedido);

	//Segunda página

    $pdf->AddPage('P', 'Letter'); //Vertical, Carta
    $pdf->SetFont('Arial','B',12); //Arial, negrita, 12 puntos
	
    $pdf->Ln();
 
    $pdf->ImprimirTexto('textoFijo2.txt'); //Texto fijo
	foreach($datosDetallesPedido as $producto=>$values){
	$datosProducto = $consultaProducto->seleccionar_producto($values["codigo_articulo"]);
	}
	$header=array('Codigo Articulo','Nombre','marca','Precio','cantidad');	
	$pdf->SetY(60);
    $pdf->SetFont('Arial','B',10); //Arial, negrita, 12 puntos
	$pdf->TablaProducto($header,$datosProducto);
	
    $pdf->Output(); //Salida al navegador del pdf
	}else{ // Si no ha iniciado sesion restringimos el acceso al perfil de la tienda redirrecionandolo al index
	header("location:../index.php");
	}
?>