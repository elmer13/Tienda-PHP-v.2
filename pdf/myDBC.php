<?php
	include_once '../core/classes/DBAbstractModel.php';

	class myDBC extends DBAbstractModel{
		public $mysqli = null;

 		public function seleccionar_cliente($id_cliente='') {
		if($id_cliente != '') {
		$this->query = "
		SELECT *
		FROM clientes
		WHERE id_cliente= '$id_cliente'
		";
		$this->getResultsFromQuery();
		}
		return $this->consulta;
		}
	
	 	public function seleccionar_pedido($id_cliente='') {
		if($id_cliente != '') {
		$this->query = "
		SELECT *
		FROM pedidos
		WHERE id_cliente= '$id_cliente'
		order by id_pedido desc limit 1
		";
		$this->getResultsFromQuery();
		}
		return $this->consulta;
		}	
		
	 	public function seleccionar_detallesPedido($id_pedido='') {
		if($id_pedido != '') {
		$this->query = "
		SELECT *
		FROM detalle_pedido
		WHERE id_pedido= '$id_pedido'
		";
		$this->getResultsFromQuery();
		}
		return $this->consulta;
		}	
		
	 	public function seleccionar_producto($codigo_articulo='') {
		if($codigo_articulo != '') {
		$this->query = "
		SELECT t1.codigo_articulo, t1.nombre, t1.marca, t1.precio, t2.cantidad
		FROM articulos AS t1
		INNER JOIN detalle_pedido t2 ON t2.codigo_articulo = t1.codigo_articulo
		WHERE t1.codigo_articulo= '$codigo_articulo'
		ORDER by t1.codigo_articulo ASC limit 1
		";
		$this->getResultsFromQuery();
		}
		return $this->consulta;
		}	
		
		public function clearText($text) {
			$text = trim($text);
			return $this->mysqli->real_escape_string($text);
		}
    }
?>