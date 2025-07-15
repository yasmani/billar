<?php
include_once "base_de_datos.php";
include"./fpdf181/fpdf.php";
//include "fpdf/fpdf.php";
 
date_default_timezone_set("America/La_Paz");
$id="";
$id=$_GET['id'];
$fecha_arqueo=$_GET['fecha'];
 


 
 

$pdf = new FPDF($orientation='P',$unit='mm', array(80,300));
$pdf->AddPage();
$pdf->SetFont('Helvetica','B',15);    //Letra Helvetica, negrita (Bold), tam. 20
$textypos = 5;
$pdf->setX(18); 
//$pdf->Cell(50,5,"TALLER MODELO  ",0,1,"C");
$pdf->setX(18); 


$pdf->SetFont('Courier','B',25);    //Letra Helvetica, negrita (Bold), tam. 20
// $pdf->Image('./files/imagenes/alf.jpeg',15,6,50,28,'jpeg');
$pdf->Ln(2);
$pdf->setX(5);
$pdf->SetFont('Helvetica','B',12);
 $pdf->Cell(40,10,"CIERRE DE CAJA X MESA ",0,1,"L");
 $pdf->setX(5);
 $pdf->Cell(5,$textypos,"APERTURA :".$id,0,1,'L');
 //$pdf->Cell(5,$textypos,"CAJERO 1 ",0,1,'L');
 $pdf->SetFont('Courier','B',10);  
 $pdf->setX(5);
 $pdf->Cell(5,$textypos,"fecha:".date("d/m/Y  H:i:s", strtotime($fecha_arqueo)),0,1,"center");
    
$textypos+=10;
$ahora = date("d-m-Y H:i:s");
$pdf->setX(2);

 
// $pdf->Cell(5,$textypos,'------------------------------------------------------');
//$textypos+=8;


 //$pdf->Cell(5,$textypos,'ARTICULO.               CANT | PRECIO | TOTAL');
$pdf->setX(2);
 
$sentenciamesa = $base_de_datos->query("SELECT  *   FROM  mesa where id between 1 and 16  order by id asc ");
$mesas = $sentenciamesa->fetchAll(PDO::FETCH_OBJ);
$totalmesas=0;
foreach($mesas as $me){
   

$sentencia = $base_de_datos->query("SELECT productos_vendidos_tienda.id,
 ventastienda.entregado as mesa,
 productos_vendidos_tienda.cantidad,
  productos.nombre,
  productos_vendidos_tienda.inicio,
    productos_vendidos_tienda.precio,
  productos_vendidos_tienda.cantidad,


  productos_vendidos_tienda.fin 
  FROM mesa, productos, `ventastienda` ,productos_vendidos_tienda
   where ventastienda.id=productos_vendidos_tienda.id_venta 
   and productos_vendidos_tienda.id_producto=productos.id 
   and ventastienda.entregado='$me->id' 
    and mesa.id=ventastienda.entregado 
    and productos_vendidos_tienda.id_producto=23
    and ventastienda.apertura='$id'
    and mesa.id='$me->id';
");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);

$total =0;

$total2 =0;
 
  $pdf->SetFont('Helvetica','B',16);
 $pdf->Cell(11,5,"MESA ".$me->mesa,0,1,"L");
 $pdf->SetFont('Helvetica','B',9);
 foreach($productos as $producto){
 
$pdf->setX(7);
$pdf->Cell(11,8, date('H:i:s', strtotime($producto->inicio)),0,0,"L");
$pdf->setX(25);
$pdf->Cell(30,8, date('H:i:s', strtotime($producto->fin)),0,0,"L");


$fechaUno=new DateTime($producto->inicio);
$fechaDos=new DateTime($producto->fin);

$dateInterval = $fechaUno->diff($fechaDos);
$data= $dateInterval->format(' %H horas %i minutos %s segundos');
$total=($dateInterval->format('%H')*15)+($dateInterval->format('%i')*0.25);
$pdf->setX(40);

$pdf->Cell(18,8, "h:".$dateInterval->format('%H')*1 ." m:".$dateInterval->format('%i'),0,0,"L");
 
$pdf->Cell(11,8, number_format(  $producto->precio*$producto->cantidad,0,".",",") ." bs",0,1,"L");
$total2+= $producto->precio*$producto->cantidad;
$totalmesas+=$total2;
 
 }
 $pdf->Cell(11,8,"total                ". number_format( $total2,0,".",",") ." bs",0,1,"L");
 
}
$pdf->Cell(11,8,"TOTAL  DE      MESAS        ". number_format( $totalmesas
,0,".",",") ." bs",0,1,"L");
  
$pdf->setX(2);
$pdf->SetFont('Helvetica','B',10);
$pdf->setX(2);
//$valorY = $valorY+15;
// $pdf->Cell(5,10,'GRACIAS POR TU PREFERENCIA ',0,1,"L");
$pdf->Cell(5,10,'.............................');

$pdf->output();