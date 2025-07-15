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
  $sentencia = $base_de_datos->query("SELECT * FROM ventastienda , usuario where ventastienda.id='$id' and usuario.id=ventastienda.idUsuario;");
  $productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
  $sql_abonos = $base_de_datos->query("SELECT * FROM abonos where id_venta='$id';");
  $resultado_sql_abonos = $sql_abonos->fetchAll(PDO::FETCH_OBJ);

   

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
  foreach($productos as $producto){
      $idventa=$producto->id;
      $fecha=$producto->fecha;
      //$hora=$producto->hora;
      $total_venta=round($producto->total, 0, PHP_ROUND_HALF_UP);
      $recibido=$producto->Thing;
      $cambio=$producto->devolver;
      $cliente=$producto->cliente;
      $detalle=$producto->detalle;
      $orden=$producto->orden;
      $apertura=$producto->apertura;
      $tipoDeVenta=$producto->tipoDeVenta;
      $nombre_de_usuario=$producto->nombre_de_usuario;
   }
   $info = $base_de_datos->query("SELECT * FROM cliente where id='$cliente';");
   $cliente = $info->fetchAll(PDO::FETCH_OBJ);
   foreach($cliente as $datos){
      $nombre_cliente=$datos->nombre;

   }



//$pdf = new FPDF($orientation='P',$unit='mm', array(80,350));
$pdf = new FPDF($orientation='P',$unit='mm', array(200,350));
//$pdf = new FPDF();
//$pdf->AddPage('p', 'letter');

$pdf->AddPage();
$pdf->SetFont('Helvetica','B',15);    //Letra Helvetica, negrita (Bold), tam. 20
$pdf->Image('./files/imagenes/logo.jpeg',5,10,50,0,'jpeg');
$pdf->Cell(160,10,"NOMBRE DE LA EMPRESA",0,1,"C");



$pdf->SetFont('Helvetica','B',12);    
$pdf->setY(10);
$pdf->setX(150);
$pdf->Cell(25,8,utf8_decode("N° ".$idventa),1,1,'C');
// $textypos+=10;
$pdf->setX(120);
$pdf->Cell(5,5,"Direccion: Centro comercial norte",0,1,'R');
$pdf->setX(95);
$pdf->Cell(5,5,"WhatsApp: 70-9999-9",0,1,'R');
$pdf->setX(105);
$pdf->Cell(5,5,"Fecha:".date("d/m/Y", strtotime($fecha)).' '.$hora,0,1,'R');
$pdf->setX(80);
$pdf->Cell(5,5,"Hora:".$hora,0,1,'R');
$pdf->setX(55);
//$pdf->Cell(5,5,"Cliente:".$nombre_cliente,0,1,"L");
$pdf->setX(55);
$pdf->Cell(5,5,"vendedor:".$nombre_de_usuario,0,1,"L");
$pdf->Ln(6);
$pdf->setX(70);
if($tipoDeVenta==1){
   $pdf->SetFont('Helvetica','B',12);    
   $pdf->Cell(50,5,'VENTA AL CONTADO  ' ,1,1,'R');
}else{
   $pdf->SetFont('Helvetica','B',12);    
   $pdf->Cell(50,5,'VENTA AL CREDITO  ' ,1,1,'R');
}
// $pdf->setX(2);
// $textypos+=10;
// $textypos+=10;
 $pdf->SetFont('Helvetica','B',11); 
// $pdf->setX(26);
 //$pdf->Cell(5,5,"ORDEN:".$orden,0,0,"L");
// $pdf->SetFont('Helvetica','B',9);    //Letra Helvetica, negrita (Bold), tam. 20
 
// $textypos+=10;
 $pdf->setX(12);
$pdf->Cell(5,5,'--------------------------------------------------------------------------------------------------------');
// $textypos+=8;
// $pdf->setX(2);
$pdf->Ln(5);


$pdf->Cell(5,5,'  FECHA.         HORA          USUARIO                                                       |MONTO PAGADO');
$pdf->Ln(5);

$pdf->setX(12);
$pdf->Cell(5,5,'--------------------------------------------------------------------------------------------------------',0,0,"L");
$sentencia = $base_de_datos->query("SELECT productos.nombre,productos_vendidos_tienda.precio as precioVenta,productos_vendidos_tienda.cantidad,productos_vendidos_tienda.descuento FROM productos_vendidos_tienda ,productos ,ventastienda where ventastienda.id='$idventa' and ventastienda.id=productos_vendidos_tienda.id_venta and productos_vendidos_tienda.id_producto=productos.id");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);

$total =0;
// $off = $textypos+14;
$pdf->Ln(5);
foreach($resultado_sql_abonos as $abono){
   $pdf->SetFont('Helvetica','B',10);
   $pdf->setX(15);
   //$pdf->Cell(5,5,"Fecha:".date("d/m/Y", strtotime($fecha)).' '.$hora,0,0,'R');
   
   $pdf->Cell(5,5,date("d/m/Y", strtotime($abono->monto)).' '.$abono->hora,0,0,"L");
   $pdf->setX(55);
   $pdf->Cell(5,5, $nombre_de_usuario,0,0,"L");
   //$pdf->Cell(100,5,  $abono->monto." " );
   // $pdf->setX(120);
   $pdf->setX(140);
   $pdf->Cell(11,5,($abono->monto)."bs",0,1,"L");
   // $pdf->setX(140);

   // $pdf->Cell(11,5,($producto->descuento)."bs",0,0,"L");
   // $pdf->setX(155);
   //$pdf->Cell(5,5, number_format(($producto->precioVenta*$producto->cantidad)-$producto->descuento,2,".",",")." bs." ,0,1,"L");
   
    $total += $abono->monto;
}
$pdf->SetFont('Helvetica','B',13); 

$pdf->setX(12);
$pdf->Cell(5,5,'--------------------------------------------------------------------------------------------------------',0,0,"L");
$pdf->Ln(5);
$pdf->Cell(5,5,'                                                                     Total Del Credito   '.$total_venta .' bs',0,1,"L");
$pdf->Cell(5,5,'                                                                                     Pagado   '.$total.' bs',0,1,"L");
$pdf->Cell(5,5,'                                                                                       Saldo   '.($total_venta-$total),0,0,"L");
$pdf->Ln(5);

$pdf->Cell(5,5,'--------------------------------------------------------------------------------------------------------',0,0,"L");
$pdf->SetFont('Helvetica','B',8); 
$pdf->Ln(5);
$pdf->setX(15);
 $pdf->SetFont('Helvetica','B',9);
 
// $pdf->Cell(5,$off+6,'GRACIAS POR SU PREFERENCIA ');

$pdf->output();