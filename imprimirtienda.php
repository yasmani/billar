<?php
include_once "base_de_datos.php";
include "./fpdf181/fpdf.php";
//include "fpdf/fpdf.php";
 
date_default_timezone_set("America/La_Paz");
$id="";
if (isset($_GET['ticket'])) {
      /* Deshacemos el trabajo hecho por 'serialize' */
      $idget = unserialize($_GET['ticket']);
      // El contenido del idget está en el índice 'error'
    $id= $idget['id'];
  }
 

  
  $sentencia = $base_de_datos->query("SELECT * FROM ventas where id='$id';");
  $productos = $sentencia->fetchAll(PDO::FETCH_OBJ);

   

  $idventa="";
  $fecha="";
  $hora="";
  $total_venta="";
  $recibido="";
  $cambio="";
  $cliente="";
  $detalle="";
  $orden="";
  $apertura="";
  $tipoDeVenta="";
  $nombre_de_usuario="";
  $descuento_de_toda_la_venta="";
  foreach($productos as $producto){
      $idventa=$producto->id;
      $fecha=$producto->fecha;
      $hora=$producto->hora;
      $total_venta=round($producto->total, 0, PHP_ROUND_HALF_UP);
      $recibido=$producto->Thing;
      $cambio=$producto->devolver;
      $cliente=$producto->cliente;
      $detalle=$producto->detalle;
      $orden=$producto->orden;
      $apertura=$producto->apertura;
      $tipoDeVenta=$producto->tipoDeVenta;
      $nombre_de_usuario=$producto->nombre_de_usuario;
      $descuento_de_toda_la_venta=$producto->descuento;
   }
   $info = $base_de_datos->query("SELECT * FROM cliente where id='$cliente';");
   $datos_cliente = $info->fetchAll(PDO::FETCH_OBJ);
   foreach($datos_cliente as $datos){
      $nombre_cliente=$datos->nombre;

   }



//$pdf = new FPDF($orientation='P',$unit='mm', array(80,350));
$pdf = new FPDF($orientation='P',$unit='mm', array(200,350));
//$pdf = new FPDF();
//$pdf->AddPage('p', 'letter');

$pdf->AddPage();
$pdf->SetFont('Courier','B',15);    //Letra Helvetica, negrita (Bold), tam. 20
$pdf->Image('./files/imagenes/logotiendahl.png',5,5,180,60,'png');
// $pdf->Cell(30,5,"FERRETERIA ",0,1,"C");
 //$pdf->Cell(30,10,"TALLER MODELO Wachenfeld",0,1,"C");


 

$pdf->SetFont('Helvetica','',20);    
 //$pdf->setY(58);
 $pdf->SetTextColor(225,0,0);
 
 $pdf->setY(48);
 $pdf->setX(128);
 $pdf->Cell(25,8, $idventa,0,1,'C');
 $pdf->SetTextColor(0,0,0);
$pdf->SetFont('Helvetica','B',21);    
$pdf->setY(24);
$pdf->setX(136);
$pdf->Cell(5,5,date("d", strtotime($fecha)),0,0,'R');
$pdf->setX(153);
$pdf->Cell(5,5,date("m", strtotime($fecha)),0,0,'R');
$pdf->SetFont('Helvetica','B',20);    
$pdf->setX(167);
$pdf->Cell(5,5,date("y", strtotime($fecha)),0,1,'R');
$pdf->SetFont('Helvetica','B',13);  
$pdf->setY(60);
$pdf->setX(15);
$pdf->Cell(5,5,'Nombre del Cliente: ' .$nombre_cliente,0,1,'L');
$pdf->setY(60);
$pdf->setX(110);
$pdf->Cell(5,5,'Vendedor: ' .$nombre_de_usuario,0,1,'L');
$pdf->Ln(1);

$pdf->setX(100);
if($tipoDeVenta==1){
   $pdf->SetFont('Helvetica','B',12);    
   // $pdf->Cell(50,5,'CONTADO  ' ,1,1,'C');
}else{
   $pdf->SetFont('Helvetica','B',12);    
    //$pdf->Cell(45,5,'CREDITO  ' ,1,1,'C');
}
// $pdf->setX(2);
// $textypos+=10;
// $textypos+=10;
 $pdf->SetFont('Helvetica','B',11); 

 //$pdf->Ln(5);
 
 
 $pdf->setX(15);
$pdf->Cell(152,10,utf8_decode(' Nº   CANT.        D E T A L L E                                              P. Unit     TOTAL'),1,0,"L");
$pdf->Ln(5);

$pdf->setX(12);
// $pdf->Cell(5,5,'____________________________________________________________________________');

$sentencia = $base_de_datos->query("SELECT productos.codigo,productos.nombre,productos_vendidos.precio as precioVenta,productos_vendidos.cantidad,productos_vendidos.descuento FROM productos_vendidos ,productos ,ventas where ventas.id='$idventa' and ventas.id=productos_vendidos.id_venta and productos_vendidos.id_producto=productos.id");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);

$total =0;
// $off = $textypos+14;
$pdf->Ln(5);
$numero=1;
foreach($productos as $producto){
   $pdf->SetFont('Helvetica','B',8);
   $pdf->setX(15);
   $pdf->Cell(8,5,($numero),1,0,"L");
   $numero++;
   $pdf->setX(23);

   $pdf->Cell(13,5,(number_format((int)$producto->cantidad,0,',','.')),1,0,"L");
   $pdf->setX(36);
   $pdf->SetFont('Helvetica','B',8);
   $pdf->Cell(85,5,utf8_decode(strtoupper(substr( $producto->nombre, 0,50))),1,0,"L");
   $pdf->SetFont('Helvetica','B',11);
   $pdf->setX(121);
   $pdf->Cell(15,5,($producto->precioVenta),1,0,"L");
   $pdf->setX(136);

   // $pdf->Cell(11,5,($producto->descuento),1,0,"L");
   // $pdf->setX(147);
   $pdf->Cell(31,5, number_format(($producto->precioVenta*$producto->cantidad)-$producto->descuento,2,".",",")." bs." ,1,1,"L");
   
    $total += $producto->precioVenta*$producto->cantidad;
}
for ($numero; $numero <25 ;$numero++) { 
   # code...
   $pdf->SetFont('Helvetica','B',11);
   $pdf->setX(15);
   $pdf->Cell(8,5,$numero,1,0,"L");
   $pdf->setX(23);

   $pdf->Cell(13,5,'',1,0,"L");
   $pdf->setX(36);
   $pdf->Cell(85,5,'',1,0,"L");
   $pdf->setX(121);
   $pdf->Cell(15,5,'',1,0,"L");
   $pdf->setX(136);

   // $pdf->Cell(11,5,'',1,0,"L");
   // $pdf->setX(147);
   $pdf->Cell(31,5, '',1,1,"L");
   
   
}
 
 
 
$pdf->SetFont('Helvetica','B',13); 

$pdf->setX(15);
$pdf->Cell(5,1,'____________________________________________________________');


$pdf->Ln(3);
$pdf->Cell(5,5,'                                                                                              SubTotal:   '.($total_venta+$descuento_de_toda_la_venta ).' bs',0,1,"L");
$pdf->Cell(5,5,'                                                                                              Descuento:   '.$descuento_de_toda_la_venta .' bs',0,1,"L");
$pdf->Cell(5,5,'                                                                                              Total:   '.($total_venta ).' bs',0,1,"L");
// $pdf->Cell(5,5,'                                                                                                 Recibido:   '.$recibido.' bs',0,1,"L");
// $pdf->Cell(5,5,'                                                                                                 Cambio:   '.$cambio,0,0,"L");
// $pdf->Ln(5);
$pdf->setX(15);

$pdf->Cell(5,1,'____________________________________________________________');

$pdf->SetFont('Helvetica','B',8); 
$pdf->Ln(3);
$pdf->setX(15);
$pdf->Cell(5,5,'Nota: Una Vez Retirada la mercaderia no se aceptan cambios ni devoluciones',0,1,"L");


$pdf->output();