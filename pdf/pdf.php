<?php
include_once('fpdf.php');
class PDF extends FPDF
{
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Desarrollado por Elmer Garcia Yavi - 2014','T',0,'C');
    }
 
    function Header()
    {
        $this->SetFont('Arial','B',27);
 
        $this->Line(10,10,206,10);
        $this->Line(10,35.5,206,35.5);
 
        $this->Cell(145,27,'TU TIENDA ONLINE',0,0,'R', $this->Image('images/logo.png',20,12,20));
        $this->Cell(40,25,'',0,0,'C',$this->Image('images/logo.png', 175, 12, 19));
 
        $this->Ln(9);
    }
 
    function ImprimirTexto($file)
    {
        $txt = file_get_contents($file);
        $this->SetFont('Arial','',14);
        $this->MultiCell(0,8,$txt);
 
    }
 
    function cabecera($cabecera)
    {
        $this->SetXY(60,115);
        $this->SetFont('Arial','B',15);
        foreach($cabecera as $columna)
        {
            $this->Cell(40,7,$columna,1, 2 , 'L' ) ;
        }
    }
	
 
    function datos($datos)
    {
        $this->SetXY(100,115);
        $this->SetFont('Arial','',12);
            foreach ($datos as $columna)
            {
                $this->Cell(65,7,utf8_decode(@$columna['id_cliente']),'TRB',2,'L' );
                $this->Cell(65,7,utf8_decode(@$columna['nif']),'TRB',2,'L' );
                $this->Cell(65,7,utf8_decode(@$columna['nombre']),'TRB',2,'L' );
                $this->Cell(65,7,utf8_decode(@$columna['telefono']),'TRB',2,'L' );
                $this->Cell(65,7,utf8_decode(@$columna['direccion']),'TRB',2,'L' );
                $this->Cell(65,7,utf8_decode(@$columna['localidad']),'TRB',2,'L' );
                $this->Cell(65,7,utf8_decode(@$columna['provincia']),'TRB',2,'L' );
                $this->Cell(65,7,utf8_decode(@$columna['pais']),'TRB',2,'L' );
                $this->Cell(65,7,utf8_decode(@$columna['codigopostal']),'TRB',2,'L' );
                $this->Cell(65,7,utf8_decode(@$columna['email']),'TRB',2,'L' );
            }
 
    }
 
		//El método tabla integra a los métodos cabecera y datos
		function tabla($cabecera,$datos)
		{
			$this->cabecera ($cabecera) ;
			$this->datos($datos);
		}
 
  
 //Tabla coloreada
function TablaPedido($header,$producto=array())
{
//Colores, ancho de línea y fuente en negrita
$this->SetFillColor(255,0,0);
$this->SetTextColor(255);
$this->SetDrawColor(128,0,0);
$this->SetLineWidth(.3);
$this->SetFont('','B');
//Cabecera

$this->Cell(30,7,$header[0],1,0,'C',1);
$this->Cell(75,7,$header[1],1,0,'C',1);
$this->Ln();
//Restauración de colores y fuentes
$this->SetFillColor(224,235,255);
$this->SetTextColor(0);
$this->SetFont('');
	$this->SetXY(60,218);
//Datos
   $fill=false;
       foreach($producto as $key=>$values){
$this->Cell(30,6,utf8_decode($values["id_pedido"]),'LR',0,'C',$fill);
$this->Cell(75,6,utf8_decode($values["fecha"]),'LR',0,'C',$fill);
$fill=true;
   $this->Ln();
   }
	$this->SetXY(60,224);
   $this->Cell(105,0,'','T');

}

  //Tabla coloreada
function TablaProducto($header,$producto=array())
{
//Colores, ancho de línea y fuente en negrita
$this->SetFillColor(255,0,0);
$this->SetTextColor(255);
$this->SetDrawColor(128,0,0);
$this->SetLineWidth(.3);
$this->SetFont('','B');
//Cabecera

$this->Cell(30,7,$header[0],1,0,'C',1);
$this->Cell(75,7,$header[1],1,0,'C',1);
$this->Cell(30,7,$header[2],1,0,'C',1);
$this->Cell(30,7,$header[3],1,0,'C',1);
$this->Cell(30,7,$header[4],1,0,'C',1);
$this->Ln();
//Restauración de colores y fuentes
$this->SetFillColor(224,235,255);
$this->SetTextColor(0);
$this->SetFont('');

//Datos
       foreach($producto as $key=>$values){
$this->Cell(30,6,utf8_decode($values["codigo_articulo"]),'LR',0,'C');
$this->Cell(75,6,utf8_decode($values["nombre"]),'LR',0,'L');
$this->Cell(30,6,utf8_decode($values["marca"]),'LR',0,'C');
$this->Cell(30,6,utf8_decode($values["precio"]),'LR',0,'C');
$this->Cell(30,6,utf8_decode($values["cantidad"]),'LR',0,'C');
   $this->Ln();
   }
   $this->Cell(195,0,'','T');

}
}//fin clase PDF

?>