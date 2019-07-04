<?php
	include_once '../core/classes/DBAbstractModel.php'; // Llamamos a la clase que contiene la conexión a la base de datos

	class Carrito extends DBAbstractModel{
		// Atributos de la clase
		public $codigo;
		public $productos;
		public $propiedad;
		// Constructor que se inicializa mediante una ID
		function  __construct($id) {
			$this->codigo=$id;
			$this->productos=array();
		}

		// Indico el codigo y recupero un producto si es que existe en el carrito
		public function obtenerProducto($codigo){
			foreach($this->productos as $indice => $producto){
				if($producto["codigo_articulo"]==$codigo){
					return $producto;
				}
			}
			return null;
		}
		
		// Actualiza la cantidad de items para un mismo producto que ya existe en el carrito
		public function actualizarCantidad($codigo,$cantidad){
			foreach ($this->productos as $indice => $producto){
				if($producto["codigo_articulo"]== $codigo){
					$producto["cantidad"] += $cantidad;
				}
			}
		}
		// Calcula el precio total por producto teniendo en cuenta la cantidad y el precio
		public function PrecioTotalPorProducto($cantidad, $precio){
		$total = $cantidad * $precio;
			return number_format($total, 2, '.', '');
		}

		// Agrego o actualizo su cantidad de un producto al carrito
		public function agregarProducto($producto=array()){
			// Busco el producto si ya fue insertado
			$yaIncluido = $this->obtenerProducto($producto["codigo_articulo"]);
			if($yaIncluido){
				$this->actualizarCantidad($producto["codigo_articulo"], 1);
			}else{
				$this->productos[]=$producto;
			}
		}
		
		// Calcular el monto total de los productos
		public function calcularMonto(){
			$monto = 0;
			foreach($this->productos as $indice => $producto){
				$monto += $producto["precio"]*$producto["cantidad"];
			}
			return number_format($monto, 2, '.', '');
		}
		
		// Calcular cantidad de productos en el carrito
		public function calcularCantidad(){
			$cantidad = 0;
			foreach($this->productos as $indice => $producto){
				$cantidad += $producto["cantidad"];
			}
			return $cantidad;
		}
		
		// Calcular descuento
		public function calcularDescuento(){
			$cantidad = $this->calcularCantidad();
			if($cantidad > 1000){
					return 20;
			}else if($cantidad > 100){
					return 10;
			}else if($cantidad > 3){
					return 2;
			}else
			   return 0;
		}

		// Calcular precio total
		public function calcularPrecioTotal(){
			$total=$this->calcularMonto()*(100 - $this->calcularDescuento())/100;
			return number_format($total, 2, '.', '');
	   }
		
		// Elimina un producto del carrito. recibe la linea del carrito que debe eliminar
		public function eliminarProducto($linea){
		 	$pro2 = array();
		    foreach ($this->productos as $indice => $producto){
				if($producto["codigo_articulo"]!=$linea){
				   $pro2[]=$producto;
				}          
			}
			$this->productos=$pro2;
		}

		// Guarda los pedidos recibiendo como parametro el id del cliente y dichos productos
		public function guardarPedido($id_cliente, $productos){
			$fechaactual = date('Y-m-d');
			//Operaciones en pedido
			$this->query = "
			INSERT INTO pedidos
			(id_cliente,fecha)
			VALUES
			('$id_cliente','$fechaactual')
			";
			$this->ejecutarConsulta();		
		}		
		
		// Retorna el id de pedido más reciente
		public function getId() {
			$this->query = "
			SELECT id_pedido
			FROM pedidos 
			order by id_pedido desc limit 1
			";
			$this->getResultsFromQuery();
		}
		
		// Guardamos los detalles del pedido 
		public function guardarDetalles($productos){
			$this->getId();
			foreach($this->consulta as $propiedad=>$valor){
				$this->propiedad = $valor;
			}
			$id_pedido= $this->propiedad["id_pedido"];
			foreach($productos as $producto){
				$codigo_articulo = $producto['codigo_articulo'];
				$cantidad = $producto['cantidad'];
					$this->query = "
					INSERT INTO detalle_pedido
					(id_pedido,codigo_articulo, cantidad)
					VALUES
					('$id_pedido','$codigo_articulo','$cantidad');
					";
					$this->ejecutarConsulta();
			}
		}
	}
?>
