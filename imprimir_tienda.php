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
 

  
  $sentencia = $base_de_datos->query("SELECT * FROM ventastienda where id='$id';");
  $productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
  $idventa="";
  $fecha="";
  $hora="";
  $total_venta="";
  $recibido=0.00;
  $cambio=0.00;
  $cliente="";
  $detalle="";
  $orden="0";
  $apertura="";
  $tipoDeVenta="";
  $nombre_de_usuario="";
  $descuento_de_toda_la_venta="";
  $transferencia='';
  $tarjeta='';
  $entrega='';
  $entregado='';
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
      $transferencia=$producto->transferencia;
      $tarjeta=$producto->tarjeta;
      $entrega=$producto->entregado;
       
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
$pdf->SetFont('Helvetica','B',15);    //Letra Helvetica, negrita (Bold), tam. 20
//   $pdf->Image('./files/logo/tuja.png',6,6,60,38,'png');
// $pdf->Ln(40);
$pdf->setX(12);
//$pdf->Cell(40,10,"        ",0,1,"L");
$pdf->setX(10);
    $pdf->Cell(40,10,utf8_decode("  BILLAR CABRERA"),0,1,"L");
  
      if($entrega==26){
           $pdf->setX(5);
      $pdf->Cell(40,10,"CONSUMO DEL PERSONAL ",0,1,"L");
   }else{
        $pdf->setX(25);
      $pdf->Cell(40,10,"MESA ".$entrega,0,1,"L");
   }
     
 
   $pdf->SetFont('Helvetica','',12);
     $pdf->setX(20);
    //  $pdf->Cell(40,5,"Sucursal Central",0,1,"L");
     $pdf->setX(10);
     
      $odd=$orden;
      //$odd=$orden>=100?($orden%100)+1:$orden;
    //  $pdf->Cell(40,5,$odd,0,1,"L");
     
     $pdf->setX(20);
     $pdf->Cell(40,5,"",0,1,"L");
 // $pdf->Ln(15);
 $pdf->SetFont('Helvetica','B',15);  
 $pdf->setX(20);
      //$pdf->Cell(40,10," ",0,1,"L");
          $pdf->SetFont('Helvetica','',10);
           $pdf->SetFont('Helvetica','b',10);  
           //$pdf->Ln(15);
 $pdf->setX(5);
    //  $pdf->Cell(40,5,utf8_decode("Cel:78094720  "),0,1,"L");
     $pdf->setX(5);
     $pdf->Cell(40,5,utf8_decode("3er A. EXTERNO ESQ. AV. JAPON 3875"),0,1,"L");
    //  $pdf->Cell(40,5,utf8_decode("a 3 cuadras de rotonda caca cala   "),0,1,"L");
    $pdf->SetFont('Helvetica','b',10);  
     // $pdf->Cell(40,5,utf8_decode("Patio de Comidas 1er Piso "),0,1,"L");
      
      $pdf->setX(5);
      //$pdf->Cell(40,5,utf8_decode("Celular: 75568642 "),0,1,"L");
     // $pdf->Cell(40,5,utf8_decode("de 8:30 a 9pm"),0,1,"L");
           $pdf->setX(8);
           $y=$pdf->getY();
           $pdf->setX(5);
 $pdf->Cell(5,5,date("d-m-Y", strtotime($fecha)).' '.$hora,0,1,'L');
  
  $pdf->setY($y);
  $pdf->setX(40);
 $pdf->Cell(30,5,utf8_decode('  Nº '),0,1,"L");
  $pdf->SetFont('Helvetica','B',19);
  $pdf->setY($y);
  $pdf->setX(52);
 $pdf->Cell(30,5, ($odd),0,1,"L");
    $pdf->SetFont('Helvetica','B',11); 
       $pdf->setX(5);
    //  $pdf->Cell(40,5,'cliente:'.$nombre_cliente, 0,1,"L");
if($tipoDeVenta==1){
   $pdf->SetFont('Courier','B',20);    
   $pdf->setX(20);
//   $pdf->Cell(5,10,'   MESA  ' ,0,1,'L');
}else{
   $pdf->SetFont('Courier','B',20);    
   $pdf->setX(15);
//   $pdf->Cell(5,10,'PARA LLEVAR' ,0,1,'L');
}
//  $pdf->setX(5);
//  $pdf->Cell(30,5,"  ",0,1,"L");
//  $pdf->setX(5);
//  $pdf->Cell(30,5," ",0,1,"L");
//  $pdf->setX(5);
//  $pdf->Cell(30,5,"telefono: 33600600",0,1,"L");
//  $pdf->setX(5);
//   $pdf->Cell(30,5,"",0,1,"L");


 

// $pdf->SetFont('Courier','',20);    
 //$pdf->setY(58);
 $pdf->SetTextColor(225,0,0);
 
 //$pdf->setY(20);
 //$pdf->setX(128);
 //$pdf->Cell(25,8, $idventa,0,1,'C');
 $pdf->SetTextColor(0,0,0);
//$pdf->SetFont('Helvetica','B',21);    
//$pdf->setY(24);
//$pdf->setX(136);
//$pdf->Cell(5,5,date("d", strtotime($fecha)),0,0,'R');
//$pdf->setX(153);
//$pdf->Cell(5,5,'fecha: '.date("m", strtotime($fecha)),0,0,'R');
 
 $pdf->SetFont('Courier','B',12); 
 $pdf->setX(30);
 //$pdf->Ln(5);
 //$pdf->Cell(5,3,'DETALLE ' ,0,1,'L');
  $pdf->setX(5);
$pdf->Cell(5,5,'___________________________',0,1,"L");
 
 $pdf->setX(5);
  $pdf->SetFont('Courier','B',10); 
 $pdf->Cell(5,10,'Cant | Producto       |SubTotal',0,0,"L");
 //$pdf->Cell(5,10,'Producto     Cant|Precio|SubTotal',0,0,"L");
//$pdf->Cell(152,10,utf8_decode(' Nº   CANT.        D E T A L L E                                              P. Unit     TOTAL'),1,0,"L");
$pdf->Ln(5);

$pdf->setX(12);
// $pdf->Cell(5,5,'____________________________________________________________________________');

$sentencia = $base_de_datos->query("SELECT productos.lote, productos_vendidos_tienda.inicio,productos_vendidos_tienda.fin,productos_vendidos_tienda.detalle,productos.codigo,productos.nombre,productos_vendidos_tienda.precio as precioVenta,productos_vendidos_tienda.cantidad,productos_vendidos_tienda.descuento  FROM productos_vendidos_tienda ,productos ,ventastienda where ventastienda.id='$idventa' and ventastienda.id=productos_vendidos_tienda.id_venta and productos_vendidos_tienda.id_producto=productos.id");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);

$total =0;
// $off = $textypos+14;
$pdf->Ln(5);
$numero=1;
 
 
foreach($productos as $producto){
   $valorY=$pdf->getY();     

   $pdf->setY($pdf->getY());
   $pdf->SetFont('Courier','',10);
   $pdf->setX(5);
   if(strlen($producto->nombre)>1){
      $pdf->SetFont('Courier','B',10);
      $nombre=$producto->nombre.'' ;
      $pdf->setX(5);
    //   $pdf->Cell(10,13,(number_format($producto->cantidad,1,',','.'))    );
      
       if($producto->lote=='BILLAR'){
          $pdf->SetFont('Courier','B',9);
          $pdf->Cell(8,13,  date("H:i a", strtotime($producto->inicio))."." .date("H:i a", strtotime($producto->fin))   );
          $pdf->SetFont('Courier','B',7);
          $pdf->setX(37);
      $pdf->Cell(50,13,' '.utf8_decode(strtoupper(substr($nombre, 0,25))),0,1,"L");
      }else{
             $pdf->setX(5);
      $pdf->Cell(10,13,(number_format($producto->cantidad,1,',','.'))    );
        //   $pdf->Cell(8,13,number_format(( $producto->cantidad),1,".",",").'x'.number_format(( $producto->precio),1,".",",")  );
          $pdf->setX(20);
      $pdf->Cell(50,13,' '.utf8_decode(strtoupper(substr($nombre, 0,25))),0,1,"L");
      }
      
    //   $pdf->Cell(50,13,utf8_decode(strtoupper(substr($nombre, 0,15))),0,1,"L");
    //   $pdf->setX(15);
    //   $pdf->Cell(50,-6,utf8_decode(strtoupper(substr($nombre, 14,100))),0,0,"L");
      $pdf->SetFont('Courier','B',10.5);
      $pdf->Ln(-10);
      //$pdf->setY($pdf->getY()-4);
      //$pdf->setX(38);
      //$pdf->Cell(10,8,(number_format((int)$producto->cantidad,0,',','.'))    );
     // $pdf->setX(48);
      //$pdf->Cell(11,8,(number_format($producto->precioVenta,2,'.','.')),0,0,"L");
      $pdf->setX(60);
      //$pdf->Cell(11,8,($producto->descuento),0,0,"L");
      
      
            if($producto->lote=='BILLAR'){
                $pdf->setX(58);
    //  $pdf->Cell(11,8, number_format(($producto->precioVenta*$producto->cantidad)- $producto->descuento,0,".",",") ,0,1,"L");
    $pdf->Cell(11,8, number_format(($producto->precioVenta)- $producto->descuento,0,".",",") ,0,1,"L");
            }else{
                $pdf->setX(58);
      $pdf->Cell(11,8, number_format(($producto->precioVenta*$producto->cantidad)- $producto->descuento,1,".",",") ,0,1,"L");
            }
      
      
   }else{
      $pdf->SetFont('Courier','B',10);
      $pdf->setY($pdf->getY()+2);
      $pdf->setX(5);
      $pdf->Cell(10,4,(number_format((int)$producto->cantidad,0,',','.'))    );
      $pdf->Cell(50,4,utf8_decode(strtoupper(substr($producto->nombre , 0,17))),0,0,"L");
      $pdf->SetFont('Courier','B',10.5);
   $pdf->Ln(-2);
   //$pdf->setY($pdf->getY()-4);
 //  $pdf->setX(38);
//   $pdf->Cell(10,8,(number_format((int)$producto->cantidad,0,',','.'))    );
   $pdf->setX(48);
   //$pdf->Cell(11,8,(number_format($producto->precioVenta,2,'.','.')),0,0,"L");
   $pdf->setX(60);
   //$pdf->Cell(11,8,($producto->descuento),0,0,"L");
   $pdf->setX(63);
   $pdf->Cell(11,8, number_format(($producto->precioVenta*$producto->cantidad)- $producto->descuento,1,".",",") ,0,1,"L");
   }
   
   $total += ($producto->precioVenta*$producto->cantidad)-$producto->descuento;
}
 
 
 
 
$pdf->SetFont('Courier','',13); 

$pdf->setX(15);
$pdf->Ln(0);
  $pdf->setX(5);
$pdf->Cell(5,5,'_________________________',0,1,"L");
$pdf->Ln(3);
$pdf->setX(2);
//$textypos=$textypos+6;

$pdf->setX(20);
// $pdf->Cell(5,4,"DESCUENTO..  ",0,0,"L");
$pdf->setX(65);
//$pdf->setY($pdf->getY()-8);
// $pdf->Cell(5,4,number_format($descuento_de_toda_la_venta,2,".",",")."bs.",0,1,"R");
// $pdf->SetFont('Courier','B',12);
// $pdf->setX(20);
$pdf->SetFont('Courier','B',12);
// $pdf->Cell(5,4,"  TOTAL..  ",0,0,"L");
$pdf->setX(63);
//$pdf->setY($pdf->getY()-8);
// $pdf->Cell(5,4,number_format($total-$descuento_de_toda_la_venta,2,".",",")."bs.",0,1,"R");
$pdf->setX(5);
$pdf->Cell(5,4,"QR..  ",0,0,"L");
$pdf->setX(65);
// $pdf->setY($pdf->getY()-8);
$pdf->Cell(5,4,number_format($transferencia,1,".",",")."bs.",0,1,"R");
// $pdf->SetFont('Courier','',12);
$pdf->setX(5);
// $pdf->Cell(5,4,"DEBE..  ",0,0,"L");
$pdf->setX(63);
//$pdf->setY($pdf->getY()-8);
// $pdf->Cell(5,4,number_format($tarjeta,1,".",",")."bs.",0,1,"R");

$pdf->setX(5);
//$pdf->Cell(5,4,"EFECTIVO:",0,0,"L");
$pdf->setX(63);
//$pdf->setY($pdf->getY()-8);
//$pdf->Cell(5,4,number_format($recibido,1,".",",")."bs.",0,1,"R");
$pdf->setX(5);
//$pdf->Cell(5,4,"CAMBIO:",0,0,"L");
$pdf->setX(63);
//$pdf->setY($pdf->getY()-8);
//$pdf->Cell(5,4,number_format($cambio,1,".",",")."bs.",0,1,"R");
//$pdf->SetFont('Courier','B',13);
$pdf->setX(5);
$pdf->Cell(5,4,"TOTAL:",0,0,"L");
$pdf->setX(63);
//$pdf->setY($pdf->getY()-8);
$pdf->Cell(5,4,number_format($total,0,".",",")."bs.",0,1,"R");
$pdf->Ln(3);
 
  $pdf->setX(5);
//$pdf->Cell(5,5,'___________________________',0,1,"L");

$pdf->SetFont('Helvetica','B',10); 
$pdf->Ln(3);
$pdf->setX(2);
//$pdf->MultiCell(65,5,"NOTA:".utf8_decode($detalle));

//$pdf->Cell(5,5,"Nota: ".$detalle,0,1,"L");
//$pdf->Ln(5);
//$pdf->setX(10);
//$pdf->Cell(5,5,'  GRACIAS POR SU PREFERENCIA',0,1,"L");
// $pdf->Cell(5,5,' ni devoluciones',0,1,"L");


$pdf->output();