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
 

  
  $sentencia = $base_de_datos->query("SELECT * FROM comprastienda where id='$id';");
  $productos = $sentencia->fetchAll(PDO::FETCH_OBJ);

   

  $idcompra="";
  $fecha="";
  $hora="";
  $total_compra="";
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
      $idcompra=$producto->id;
      $fecha=$producto->fecha;
      $hora=$producto->HORA;
      $total_compra=round($producto->total, 0, PHP_ROUND_HALF_UP);
   }
   $info = $base_de_datos->query("SELECT * FROM cliente where id='2';");
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
$pdf->SetFont('Courier','B',15);    //Letra Courier, negrita (Bold), tam. 20
// $pdf->Image('./files/imagenes/logonotfake.jpeg',15,3,50,50,'jpeg');
$pdf->setX(28);
$pdf->Cell(30,5,"TICKET",0,1,"C");
$pdf->setX(28);
 $pdf->Cell(30,10,"NOTA DE COMPRA",0,1,"C");


 

$pdf->SetFont('Courier','',20);    
 //$pdf->setY(58);
 $pdf->SetTextColor(225,0,0);
 
 $pdf->setY(55);
 $pdf->setX(128);
 $pdf->setX(128);
 $pdf->Cell(25,8, $idcompra,0,1,'C');
 $pdf->SetTextColor(0,0,0);
$pdf->SetFont('Courier','',21);    
$pdf->setY(24);
$pdf->setX(136);
// $pdf->Cell(5,5,date("d", strtotime($fecha)),0,0,'R');
$pdf->setX(153);
// $pdf->Cell(5,5,'fecha: '.date("m", strtotime($fecha)),0,0,'R');
// $pdf->SetFont('Courier','B',10);    
// $pdf->setY(55);
$pdf->setX(5);
$pdf->setX(35);
$pdf->SetFont('Courier','',10);    //Letra Courier, negrita (Bold), tam. 20
 
 
$pdf->SetFont('Courier','',10);
$pdf->setX(5);
$pdf->Cell(5,5,date("d-m-Y", strtotime($fecha)).' '.$hora.utf8_decode('                Nº ').$orden,0,1,'L');
 
$pdf->setX(5);
// $pdf->Cell(5,5,'Cliente: ' .$nombre_cliente,0,1,'L');
 
$pdf->setX(5);
// $pdf->Cell(5,5,'Vendedor: ' .$nombre_de_usuario,0,1,'L');
$pdf->Ln(1);

 
if($tipoDeVenta==1){
      
   $pdf->setX(5);
   $pdf->Cell(5,5,'DETALLE  ' ,0,1,'L');
}else{
      
   $pdf->setX(5);
   $pdf->Cell(5,5,'DETALLE  ' ,0,1,'L');
}
// $pdf->setX(2);
// $textypos+=10;
// $textypos+=10;
 

 //$pdf->Ln(5);
 
 
 $pdf->setX(2);
 $pdf->Cell(2,2,'----------------------------------' ,0,1,'L');
 $pdf->setX(2);
 $pdf->Cell(1,5,'ARTICULO.      CANT | PRECIO |TOTAL     ',0,1,"L");
 $pdf->setX(2);
 $pdf->Cell(2,2,'----------------------------------' ,0,1,'L');
//$pdf->Cell(152,10,utf8_decode(' Nº   CANT.        D E T A L L E                                              P. Unit     TOTAL'),1,0,"L");
//$pdf->Ln(5);

$pdf->setX(12);
// $pdf->Cell(5,5,'____________________________________________________________________________');

$sentencia = $base_de_datos->query("SELECT productos.codigo, productos_comprados_tienda.id, productos.id,productos.codigo,productos.nombre,productos_comprados_tienda.precio,productos_comprados_tienda.cantidad,productos_comprados_tienda.precio *productos_comprados_tienda.cantidad as total 
FROM `productos_comprados_tienda`, productos 
WHERE productos_comprados_tienda.id_compra='$id' and  productos_comprados_tienda.id_producto=productos.id");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);

$total =0;
// $off = $textypos+14;
$pdf->Ln(1);
$numero=1;
 
 
foreach($productos as $producto){
   $valorY=$pdf->getY();     

   $pdf->setY($pdf->getY());
   $pdf->SetFont('Courier','',10);
   $pdf->setX(2);
   if(strlen($producto->nombre)>16){
      $pdf->SetFont('Courier','',10);
      
      $pdf->setX(2);
      $pdf->Cell(50,12,utf8_decode(strtoupper(substr($producto->nombre, 0,16))),0,1,"L");
      $pdf->setX(2);
      $pdf->Cell(50,-6,utf8_decode(strtoupper(substr($producto->nombre, 16,100))),0,0,"L");
      $pdf->SetFont('Courier','',10.5);
      $pdf->Ln(-10);
      //$pdf->setY($pdf->getY()-4);
      $pdf->setX(40);
      $pdf->Cell(10,8,(number_format((int)$producto->cantidad,1,',','.'))    );
      $pdf->setX(52);
      $pdf->Cell(11,8,(number_format($producto->precio,1,',','.')),0,0,"L");
      $pdf->setX(60);
      //$pdf->Cell(11,8,($producto->descuento),0,0,"L");
      $pdf->setX(65);
      $pdf->Cell(11,8, number_format(($producto->precio*$producto->cantidad) ,1,".",",") ,0,1,"L");
   }else{
      $pdf->SetFont('Courier','',10);
      $pdf->setY($pdf->getY()+2);
      $pdf->setX(2);
      $pdf->Cell(50,4,utf8_decode(strtoupper(substr($producto->codigo." ".$producto->nombre, 0,17))),0,0,"L");
      $pdf->SetFont('Courier','',10.5);
   $pdf->Ln(-2);
   //$pdf->setY($pdf->getY()-4);
   $pdf->setX(38);
   $pdf->Cell(10,8,(number_format((int)$producto->cantidad,1,',','.'))    );
   $pdf->setX(50);
   $pdf->Cell(11,8,(number_format($producto->precio,1,',','.')),0,0,"L");
   $pdf->setX(60);
   //$pdf->Cell(11,8,($producto->descuento),0,0,"L");
   $pdf->setX(65);
   $pdf->Cell(11,8, number_format(($producto->precio*$producto->cantidad),1,".",",") ,0,1,"L");
   }
   
   $total += ($producto->precio*$producto->cantidad);
}
 
 
 
 
$pdf->SetFont('Courier','B',13); 

$pdf->setX(15);
$pdf->Ln(5);
$pdf->Cell(5,1,'____________________________________________________________',0,1,"C");
$pdf->Ln(5);
$pdf->setX(2);
//$textypos=$textypos+6;
$pdf->SetFont('Courier','B',12);
$pdf->setX(31);
$pdf->Cell(5,4,"TOTAL..  ",0,0,"L");
$pdf->setX(68);
//$pdf->setY($pdf->getY()-8);
$pdf->Cell(5,4,number_format($total,2,".",",")."bs.",0,1,"R");


$pdf->setX(31);
// $pdf->Cell(5,4,"DESC..  ",0,0,"L");
$pdf->setX(68);
//$pdf->setY($pdf->getY()-8);
// $pdf->Cell(5,4,number_format($descuento_de_toda_la_venta,2,".",",")."bs.",0,1,"R");

$pdf->setX(20);
// $pdf->Cell(5,4,"RECIBIDO:",0,0,"L");
$pdf->setX(68);
//$pdf->setY($pdf->getY()-8);
// $pdf->Cell(5,4,number_format($recibido,1,".",",")."bs.",0,1,"R");
$pdf->setX(20);
// $pdf->Cell(5,4,"CAMBIO:",0,0,"L");
//$pdf->setY($pdf->getY()-8);
// $pdf->Cell(5,4,number_format($cambio,1,".",",")."bs.",0,1,"R");

$pdf->Ln(3);


$pdf->setX(8);
$pdf->Cell(5,1,'_____________________________________________________________________');

$pdf->SetFont('Courier','B',7); 
$pdf->Ln(3);
$pdf->setX(2);
//$pdf->Cell(5,5,'Nota: Una Vez Retirada la mercaderia no se aceptan cambios ',0,1,"L");
//$pdf->Cell(5,5,' ni devoluciones',0,1,"L");


$pdf->output();