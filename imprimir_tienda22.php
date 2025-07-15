<?php
include_once "base_de_datos.php";
include "./fpdf181/fpdf.php";
//include "fpdf/fpdf.php";
 
date_default_timezone_set("America/La_Paz");
$id="";
 $total= $_GET['total'];
 $mesa= $_GET['mesa'];
 
$pdf = new FPDF($orientation='P',$unit='mm', array(80,350));
$pdf->AddPage();

  $pdf->SetFont('Courier','B',15);
   // $pdf->Image('./files/logo/logobillar.png',6,6,60,38,'png');
// $pdf->Ln(40);
  $pdf->setX(10);
//   $pdf->Cell(11,8, 'CUENTA BILLAR 55  : ' ,0,1,"L");
  $pdf->setX(20);
  $pdf->Cell(11,8, ' MESA #'.$mesa ,0,1,"L");

$sentencia = $base_de_datos->query("SELECT productos.lote,carrito.fechaInicio,carrito.fechaFin,carrito.titulo, productos.id,productos.codigo,productos.nombre,carrito.precio,carrito.cantidad,carrito.precio*carrito.cantidad as total FROM `carrito`,productos 
WHERE carrito.idproducto=productos.id and idmesa='$mesa';");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);


$sqlActualizar = $base_de_datos->prepare("UPDATE carrito SET bloqueo = 1 WHERE idmesa = ?");
$resultado = $sqlActualizar->execute([$mesa]);

$total =0;
 
$numero=1;
    $pdf->setX(5);
        // $pdf->Cell(8,13, '1111'  );
//   $pdf->Cell(11,8, 'CUENTA MESA : ' ,0,1,"L");
//  $pdf->Cell(10,4,'CUENTA MESA'    );
// $pdf->Cell(11,8, 'MESA ' ,0,1,"L");
foreach($productos as $producto){
        

 $total +=$producto->precio*$producto->cantidad;
  $pdf->SetFont('Courier','',10);
//   $pdf->setX(5);
  if(strlen($producto->nombre)>1){
      $pdf->SetFont('Courier','B',9);
      $nombre=$producto->titulo;
      $pdf->setX(5);
      if($producto->lote=='BILLAR'){
          $pdf->SetFont('Courier','B',9);
          $pdf->Cell(8,13,  date("H:i a", strtotime($producto->fechaInicio)).">" .date("H:i a", strtotime($producto->fechaFin))   );
          $pdf->SetFont('Courier','B',11);
          $pdf->setX(37);
      $pdf->Cell(50,13,' '.utf8_decode(strtoupper(substr($nombre, 0,25))),0,1,"L");
      }else{
          $pdf->Cell(8,13,number_format(( $producto->cantidad),1,".",",").'x'.number_format(( $producto->precio),0,".",",")  );
          $pdf->setX(20);
      $pdf->Cell(50,13,' '.utf8_decode(strtoupper(substr($nombre, 0,25))),0,1,"L");
      }
      
         $pdf->SetFont('Courier','B',8);
            
      $pdf->setX(13);
      $pdf->Cell(50,-6,utf8_decode(strtoupper(substr($nombre, 25,100))),0,0,"L");
      $pdf->SetFont('Courier','B',10.5);
      $pdf->Ln(-10);
     
      $pdf->setX(60);
       
      $pdf->setX(63);
      $pdf->Cell(11,8, number_format(($producto->precio*$producto->cantidad) ,0,".",",")."bs",0,1,"L");
  }else{
      $pdf->SetFont('Courier','B',10);
      $pdf->setY($pdf->getY()+2);
      $pdf->setX(5);
      $pdf->Cell(10,4,(number_format($producto->cantidad,1,',','.'))    );
      $pdf->Cell(50,4,utf8_decode(strtoupper(substr($producto->nombre , 0,17))),0,0,"L");
      $pdf->SetFont('Courier','B',10.5);
  $pdf->Ln(-2);
 
  $pdf->setX(48);
    
  $pdf->setX(60);
 
  $pdf->setX(63);
  $pdf->Cell(11,8, number_format(($producto->precio*$producto->cantidad) ,0,".",",")."bs" ,0,1,"L");
  }

   
 
}
   $pdf->setX(5);
  $pdf->Cell(11,8, '__________________________________',0,1,"L");
   $pdf->setX(28);
  $pdf->Cell(11,8, 'TOTAL: '.number_format(($total) ,0,".",",") ." bs",0,1,"L");
 
 


$pdf->output();