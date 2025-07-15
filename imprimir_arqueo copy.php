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
$pdf->setY(15); 
$pdf->Cell(60,$textypos,"Tienda Dubai",0,1,"C");
$pdf->setY(15); 
//$pdf->Image('./files/imagenes/logo.jpg',25,10,30,0,'jpeg');
$pdf->setY(37); 

$textypos+=5;


$pdf->setX(12);
//$pdf->Cell(60,$textypos,"'El ARCA'",0,0,"C");
$pdf->SetFont('Helvetica','B',13);    
$textypos+=10;
$pdf->setX(38);
$pdf->Cell(5,$textypos,"APERTURA :".$id,0,0,'C');
$pdf->setX(38);
$textypos+=10;
$pdf->Cell(5,$textypos,"CIERRE DE CAJA",0,0,'C');
$pdf->SetFont('Helvetica','B',13);    
//$textypos+=10;
$pdf->setX(2);
//$pdf->Cell(5,$textypos,"Fecha:".date("d/m/Y:H:i:s", strtotime($fecha)));
$pdf->setX(2);
$pdf->SetFont('Helvetica','B',10);
$textypos+=10;
/*$pdf->Cell(5,$textypos,"Direccion:  ");
$pdf->SetFont('Helvetica','B',13);
$pdf->setX(2);
$textypos+=10;
$pdf->Cell(5,$textypos,"Pedidos:  ");
$textypos+=10;*/
$ahora = date("d-m-Y H:i:s");
$pdf->setX(2);

$pdf->Cell(5,$textypos,"fecha:".date("d/m/Y  H:i:s", strtotime($fecha_arqueo)));

$pdf->setX(2);
$textypos+=10;
//$pdf->Cell(5,$textypos,"cliente:".$cliente,0,0,"L");
//$textypos+=10;
$pdf->SetFont('Helvetica','B',13); 
$pdf->setX(26);
//$pdf->Cell(5,$textypos,"ORDEN:".$orden,0,0,"L");
$pdf->SetFont('Helvetica','B',9);    //Letra Helvetica, negrita (Bold), tam. 20
 
$textypos+=5;
$pdf->setX(2);
$pdf->Cell(5,$textypos,'-----------------------');
//$textypos+=8;


$pdf->setY(41);
//$pdf->Cell(5,$textypos,'ARTICULO.               CANT | PRECIO | TOTAL');
$pdf->setX(2);
$pdf->Cell(5,$textypos,'ARTICULO.                  CANT | PRECIO | TOTAL',0,0,"center");

$sentencia = $base_de_datos->query("SELECT productos_vendidos.id_producto,SUM(productos_vendidos.cantidad) as cantidad,productos.nombre, productos.precioVenta , SUM(productos.precioVenta)as total FROM `ventas`,productos_vendidos ,productos WHERE apertura='$id' and productos_vendidos.id_venta=ventas.id and productos.id=productos_vendidos.id_producto GROUP by productos_vendidos.id_producto");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);

$total =0;
$off = $textypos+14;
$pdf->setY(70);
 foreach($productos as $producto){
$valorY=$pdf->getY();     

$pdf->setY($pdf->getY());
$pdf->SetFont('Helvetica','B',6);
$pdf->setX(2);
$pdf->Cell(50,8,utf8_decode(strtoupper(substr($producto->nombre, 0,25))));
//$pdf->Cell(50,$off,strtoupper("Hola"));
$pdf->SetFont('Helvetica','B',9);
$pdf->setX(37);
$pdf->Cell(10,8,  $producto->cantidad."  " );
$pdf->setX(46);
$pdf->Cell(11,8,($producto->precioVenta),0,0,"L");
$pdf->setX(60);
$pdf->Cell(11,8, number_format($producto->precioVenta*$producto->cantidad,2,".",",") ,0,1,"L");

$total += $producto->precioVenta*$producto->cantidad;
//$off+=14;

}
 
//$textypos=$valorY-3;

$pdf->setX(2);
$pdf->Cell(5,8,'-----------------------',0,1,"L");
//$textypos=$textypos+6;
$pdf->SetFont('Helvetica','B',12);
$pdf->setX(31);
$pdf->Cell(5,8,"TOTAL..  ",0,0,"L");
$pdf->setX(68);
//$pdf->setY($pdf->getY()-8);
$pdf->Cell(5,8,number_format($total,2,".",",")."bs.",0,1,"R");
$pdf->setX(31);
//$off = $textypos+6;
$pdf->setX(68);

$pdf->setX(68);
//$valorY = $valorY+6;
$pdf->setX(31);
$pdf->setX(68);

$pdf->setX(2);
$pdf->SetFont('Helvetica','B',10);
$pdf->setX(2);
//$valorY = $valorY+15;
$pdf->Cell(5,10,'GRACIAS POR TU PREFERENCIA ',0,1,"L");
$pdf->Cell(5,10,'.............................');

$pdf->output();