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
 

  
  $sentencia = $base_de_datos->query("SELECT * FROM traspaso where id='$id';");
  $productos = $sentencia->fetchAll(PDO::FETCH_OBJ);

   

  $idventa="";
  $fecha="";
  $hora="";
  $total_venta="";
  $recibido=0.00;
  $cambio=0.00;
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
   if($recibido==''){
       $recibido=0.00;
      ///echo $_COOKIE["usuario"]; 
   }
   if($cambio==''){
       $cambio=0.00;
      ///echo $_COOKIE["usuario"]; 
   }
   foreach($datos_cliente as $datos){
      $nombre_cliente=$datos->nombre;

   }



//$pdf = new FPDF($orientation='P',$unit='mm', array(80,350));
$pdf = new FPDF($orientation='P',$unit='mm', array(80,350));
//$pdf = new FPDF();
//$pdf->AddPage('p', 'letter');

$pdf->AddPage();
$pdf->SetFont('Courier','B',20);    //Letra Helvetica, negrita (Bold), tam. 20
//$pdf->Image('./files/imagenes/logov6.png',5,6,70,48,'png');
// $pdf->Cell(30,5,"FERRETERIA ",0,1,"C");
 //$pdf->Cell(30,10,"TALLER MODELO Wachenfeld",0,1,"C");


  $pdf->Cell(30,10,"   ZUFRUTA ",0,1,"L");
 $pdf->SetFont('Helvetica','B',10);  
 $pdf->setX(5);
 $pdf->Cell(30,5,"     BAJA DE PRODUCTOS\n ",0,1,"L");
 $pdf->Cell(30,5,"",0,1,"L");
 $pdf->setX(5);
  $pdf->Cell(30,5,"",0,1,"L");

$pdf->SetFont('Helvetica','',20);    
 //$pdf->setY(58);
 $pdf->SetTextColor(225,0,0);
 
 $pdf->setY(25);
 $pdf->setX(128);
 $pdf->Cell(25,8, $idventa,0,1,'C');
 $pdf->SetTextColor(0,0,0);
$pdf->SetFont('Helvetica','B',21);    
$pdf->setY(24);
$pdf->setX(136);
$pdf->Cell(5,5,date("d", strtotime($fecha)),0,0,'R');
$pdf->setX(153);
$pdf->Cell(5,5,'fecha: '.date("m", strtotime($fecha)),0,0,'R');
$pdf->SetFont('Helvetica','B',10);    
$pdf->setY(35);
$pdf->setX(5);
$pdf->setX(35);
$pdf->SetFont('Courier','B',10);    //Letra Helvetica, negrita (Bold), tam. 20
 
 
$pdf->SetFont('Helvetica','B',10);
$pdf->setX(5);
$pdf->Cell(5,5,date("d-m-Y", strtotime($fecha)).' '.$hora.utf8_decode('                Nº ').$orden,0,1,'L');
$pdf->SetFont('Helvetica','B',10);  
$pdf->setX(5);
// $pdf->Cell(5,5,'Encargado: ' .$nombre_cliente,0,1,'L');
 
$pdf->setX(5);
$pdf->Cell(5,5,'Vendedor: ' .$nombre_de_usuario,0,1,'L');
$pdf->Ln(1);

 
if($tipoDeVenta==1){
   $pdf->SetFont('Helvetica','B',10);    
   $pdf->setX(5);
   // $pdf->Cell(5,5,'VENTA AL CONTADO  ' ,0,1,'L');
}else{
   $pdf->SetFont('Helvetica','B',10);    
   $pdf->setX(5);
   // $pdf->Cell(5,5,'VENTA AL CREDITO  ' ,0,1,'L');
}
// $pdf->setX(2);
// $textypos+=10;
// $textypos+=10;
 $pdf->SetFont('Helvetica','B',9); 

 //$pdf->Ln(5);
 
 
 $pdf->setX(2);
 $pdf->Cell(5,10,'ARTICULO.                      CANT | PRECIO |TOTAL',0,0,"center");
//$pdf->Cell(152,10,utf8_decode(' Nº   CANT.        D E T A L L E                                              P. Unit     TOTAL'),1,0,"L");
$pdf->Ln(5);

$pdf->setX(12);
// $pdf->Cell(5,5,'____________________________________________________________________________');

$sentencia = $base_de_datos->query("SELECT productos.codigo,productos.nombre,productos_traspasados.precio as precioVenta,productos_traspasados.cantidad,productos_traspasados.descuento  FROM productos_traspasados ,productos ,traspaso where traspaso.id='$idventa' and traspaso.id=productos_traspasados.id_traspaso and productos_traspasados.id_producto=productos.id");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);

$total =0;
// $off = $textypos+14;
$pdf->Ln(5);
$numero=1;
 
 
foreach($productos as $producto){
   $valorY=$pdf->getY();     

   $pdf->setY($pdf->getY());
   $pdf->SetFont('Helvetica','B',10);
   $pdf->setX(2);
   if(strlen($producto->nombre)>16){
      $pdf->SetFont('Helvetica','B',10);
      
      $pdf->setX(2);
      $pdf->Cell(50,12,utf8_decode(strtoupper(substr($producto->nombre, 0,16))),0,1,"L");
      $pdf->setX(2);
      $pdf->Cell(50,-6,utf8_decode(strtoupper(substr($producto->nombre, 16,100))),0,0,"L");
      $pdf->SetFont('Helvetica','B',10.5);
      $pdf->Ln(-10);
      //$pdf->setY($pdf->getY()-4);
      $pdf->setX(40);
      $pdf->Cell(10,8,(number_format((int)$producto->cantidad,1,',','.'))    );
      $pdf->setX(52);
      $pdf->Cell(11,8,(number_format($producto->precioVenta,1,',','.')),0,0,"L");
      $pdf->setX(60);
      //$pdf->Cell(11,8,($producto->descuento),0,0,"L");
      $pdf->setX(65);
      $pdf->Cell(11,8, number_format(($producto->precioVenta*$producto->cantidad)- $producto->descuento,1,".",",") ,0,1,"L");
   }else{
      $pdf->SetFont('Helvetica','B',10);
      $pdf->setY($pdf->getY()+2);
      $pdf->setX(2);
      $pdf->Cell(50,4,utf8_decode(strtoupper(substr($producto->nombre, 0,17))),0,0,"L");
      $pdf->SetFont('Helvetica','B',10.5);
   $pdf->Ln(-2);
   //$pdf->setY($pdf->getY()-4);
   $pdf->setX(40);
   $pdf->Cell(10,8,(number_format((int)$producto->cantidad,1,',','.'))    );
   $pdf->setX(52);
   $pdf->Cell(11,8,(number_format($producto->precioVenta,1,',','.')),0,0,"L");
   $pdf->setX(60);
   //$pdf->Cell(11,8,($producto->descuento),0,0,"L");
   $pdf->setX(65);
   $pdf->Cell(11,8, number_format(($producto->precioVenta*$producto->cantidad)- $producto->descuento,1,".",",") ,0,1,"L");
   }
   
   $total += ($producto->precioVenta*$producto->cantidad)-$producto->descuento;
}
 
 
 
 
$pdf->SetFont('Helvetica','B',13); 

$pdf->setX(15);
$pdf->Ln(5);
$pdf->Cell(5,1,'____________________________________________________________',0,1,"C");
$pdf->Ln(5);
$pdf->setX(2);
//$textypos=$textypos+6;
$pdf->SetFont('Helvetica','B',12);
$pdf->setX(31);
$pdf->Cell(5,4,"TOTAL..  ",0,0,"L");
$pdf->setX(68);
//$pdf->setY($pdf->getY()-8);
$pdf->Cell(5,4,number_format($total,2,".",",")."bs.",0,1,"R");


$pdf->setX(31);
$pdf->Cell(5,4,"DESC..  ",0,0,"L");
$pdf->setX(68);
//$pdf->setY($pdf->getY()-8);
$pdf->Cell(5,4,number_format($descuento_de_toda_la_venta,2,".",",")."bs.",0,1,"R");

$pdf->setX(20);
$pdf->Cell(5,4,"RECIBIDO:",0,0,"L");
$pdf->setX(68);
//$pdf->setY($pdf->getY()-8);
$pdf->Cell(5,4,number_format($recibido,1,".",",")."bs.",0,1,"R");
$pdf->setX(20);
$pdf->Cell(5,4,"CAMBIO:",0,0,"L");
$pdf->setX(68);
//$pdf->setY($pdf->getY()-8);
$pdf->Cell(5,4,number_format($cambio,1,".",",")."bs.",0,1,"R");

$pdf->Ln(3);
 

$pdf->Cell(5,1,'____________________________________________________________');

$pdf->SetFont('Helvetica','B',7); 
$pdf->Ln(3);
$pdf->setX(2);
$pdf->Cell(5,5,'Nota: Una Vez Retirada la mercaderia no se aceptan cambios ',0,1,"L");
$pdf->Cell(5,5,' ni devoluciones',0,1,"L");


$pdf->output();