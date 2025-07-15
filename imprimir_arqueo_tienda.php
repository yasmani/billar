<?php
include_once "base_de_datos.php";
include"./fpdf181/fpdf.php";
//include "fpdf/fpdf.php";
 
date_default_timezone_set("America/La_Paz");
$id="";
$id=$_GET['id'];
$fecha_arqueo=$_GET['fecha'];
 


 
 

$pdf = new FPDF($orientation='P',$unit='mm', array(80,600));
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
$pdf->SetFont('Helvetica','B',20);
 $pdf->Cell(40,10,"CIERRE DE CAJA ",0,1,"L");
 $pdf->setX(5);
 $pdf->Cell(5,$textypos,"APERTURA :".$id,0,1,'L');
 //$pdf->Cell(5,$textypos,"CAJERO 1 ",0,1,'L');
 $pdf->SetFont('Courier','B',10);  
 $pdf->setX(5);
 $pdf->Cell(5,$textypos,"fecha:".date("d/m/Y  H:i:s", strtotime($fecha_arqueo)));
 $pdf->Ln(5);
 //$pdf->Cell(5,5,date("d-m-Y", strtotime($fecha)).' '.$hora.utf8_decode('  Nº ').$orden,0,1,'L');
 $pdf->setX(5);
//  $pdf->Cell(30,5,"av.banzer 6to y 7mo anillo   \n ",0,1,"L");
 $pdf->setX(5);
 $pdf->Cell(30,5,"  ",0,1,"L");
 $pdf->setX(5);
//  $pdf->Cell(30,5,"Boliche ",0,1,"L");
 $pdf->setX(5);
 
 $pdf->setX(5);
  $pdf->Cell(30,5,"",0,1,"L");
//$pdf->Cell(50,5,"'CAJERO 1'",0,1,"C");
$pdf->setY(10); 
 
$pdf->SetFont('Helvetica','B',20);
//  $pdf->Cell(30,10,"A.L.F  ",0,1,"L");
 $pdf->SetFont('Helvetica','B',10);  
 $pdf->setX(5);
 
 $pdf->Cell(30,5,"        \n ",0,1,"L");
 $pdf->Cell(30,5,"  ",0,1,"L");
 $pdf->setX(5);
  $pdf->Cell(30,5," ",0,1,"L");





$pdf->setY(30); 

$textypos+=15;


$pdf->setX(12);
 
$pdf->SetFont('Helvetica','B',13);    
$textypos+=12;
$pdf->setX(38);

$pdf->setX(38);
$textypos+=10;
// $pdf->Cell(5,$textypos,"CIERRE DE CAJA",0,0,'C');
$pdf->SetFont('Helvetica','B',13);    
//$textypos+=10;
$pdf->setX(2);
 
$pdf->setX(2);
$pdf->SetFont('Helvetica','B',10);
$textypos+=10;
 
$ahora = date("d-m-Y H:i:s");
$pdf->setX(2);



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
// $pdf->Cell(5,$textypos,'------------------------------------------------------');
//$textypos+=8;


$pdf->setY(6);
//$pdf->Cell(5,$textypos,'ARTICULO.               CANT | PRECIO | TOTAL');
$pdf->setX(2);
$pdf->Cell(5,$textypos,'ARTICULO.               CANT | PRECI    |TOTAL',0,0,"center");

$sentencia = $base_de_datos->query("SELECT productos.codigo,ventastienda.tarjeta,ventastienda.transferencia, productos_vendidos_tienda.id, productos_vendidos_tienda.id_producto, (productos_vendidos_tienda.descuento) as descuento , sum(productos_vendidos_tienda.cantidad) as cantidad,productos.nombre, productos_vendidos_tienda.precio as precioVenta , SUM(productos_vendidos_tienda.precio*productos_vendidos_tienda.cantidad)as total FROM ventastienda,productos_vendidos_tienda ,productos WHERE productos_vendidos_tienda.apertura='$id' and productos_vendidos_tienda.id_venta=ventastienda.id and productos.id=productos_vendidos_tienda.id_producto  GROUP by productos_vendidos_tienda.id_producto;");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);

$total =0;
$off = $textypos+14;
$pdf->setY(30);
$total_tarjeta=0;
$total_transferencia=0;
$Total_cantidad=0;
 $pdf->Ln(10);
 foreach($productos as $producto){
     $Total_cantidad+=$producto->cantidad;
$valorY=$pdf->getY();     

$pdf->setY($pdf->getY());
$pdf->SetFont('Helvetica','B',6);
$pdf->setX(2);
$pdf->Cell(50,8,utf8_decode(strtoupper(substr($producto->nombre, 0,25))));
 
$pdf->SetFont('Helvetica','B',9);
$pdf->setX(37);
$pdf->Cell(10,8, number_format( $producto->cantidad,0,".",",") );
$pdf->setX(46);
$pdf->Cell(11,8,( number_format( $producto->precioVenta,0,".",",")),0,0,"L");
$pdf->setX(60);
$pdf->Cell(11,8, '',0,0,"L");
$pdf->setX(60);
if($producto->codigo=='23'){
    
//$pdf->Cell(11,8, number_format(($producto->precioVenta*$producto->cantidad)- $producto->descuento,0,".",",") ,0,1,"L");

$pdf->Cell(11,8, number_format($producto->total,0,".",",") ,0,1,"L");

$total+=number_format($producto->total,0,".",",");

}else{

//$pdf->Cell(11,8, number_format(($producto->precioVenta*$producto->cantidad)- $producto->descuento,1,".",",") ,0,1,"L");    
$pdf->Cell(11,8, number_format($producto->total,1,".",",") ,0,1,"L");  
$total+=number_format($producto->total,1,".",",");

}
 

}
 
 $sql_gatos = $base_de_datos->query("SELECT SUM(total) as gasto_total FROM `egresosadm` WHERE detalle='$id'");
$total_gastos = $sql_gatos->fetchAll(PDO::FETCH_OBJ);
$monto_total_gastos=0;
foreach($total_gastos as $gasto){
   $monto_total_gastos+=$gasto->gasto_total;
}



 $sql_gatos = $base_de_datos->query("SELECT SUM(total) as total FROM `fraccionamiento` WHERE detalle='$id'");
$total_f = $sql_gatos->fetchAll(PDO::FETCH_OBJ);
$monto_total_f=0;
foreach($total_f as $f){
   $monto_total_f+=$f->total;
}


 
 
 
 
 
 $sql_ventas = $base_de_datos->query("SELECT ventastienda.entregado,ventastienda.tarjeta,ventastienda.entrega,cliente.nombre as cliente, ventastienda.transferencia,ventastienda.detalle,ventastienda.descuento,ventastienda.tipoDeVenta, ventastienda.hora,ventastienda.nombre_de_usuario,ventastienda.orden,ventastienda.arqueo,ventastienda.total, ventastienda.fecha, ventastienda.id, GROUP_CONCAT( productos.codigo, '..', productos.nombre, '..', productos_vendidos_tienda.cantidad , '..', productos_vendidos_tienda.precio SEPARATOR '__') AS productos FROM ventastienda INNER JOIN productos_vendidos_tienda ON productos_vendidos_tienda.id_venta = ventastienda.id INNER JOIN productos ON productos.id = productos_vendidos_tienda.id_producto INNER JOIN cliente on cliente.id=ventastienda.cliente  and ventastienda.apertura='$id' GROUP BY ventastienda.id ORDER BY ventastienda.id DESC");
$sql_ventass = $sql_ventas->fetchAll(PDO::FETCH_OBJ);
 

foreach($sql_ventass as $producto){
    
   $total_tarjeta+=$producto->tarjeta;
  // $total+=$producto->total;
$total_transferencia+=$producto->transferencia;
}
 
//$textypos=$valorY-3;
$pdf->setX(2);
//$pdf->Cell(5,8,'--------------------------------------------------------------',0,1,"L");
$pdf->setX(26);
$pdf->Cell(5,8,'cant '.$Total_cantidad." "."     TOTAL..  ".number_format($total,0,".",","),0,1,"L");
$pdf->SetFont('Helvetica','B',12);
$pdf->setX(2);
$pdf->Cell(5,8,'--------------------------------------------------------------',0,1,"L");
//$textypos=$textypos+6;

$pdf->setX(25);
// $pdf->Cell(5,8,"DEBE..  ".number_format($total_tarjeta,0,".",",")."bs",0,1,"L");
$pdf->setX(25);
$pdf->Cell(5,8,"Transferencia..  ".number_format($total_transferencia+$monto_total_f,0,".",",")."bs",0,1,"L");
$pdf->setX(25);
$pdf->Cell(5,8,"Efectivo..  ".number_format($total-($total_tarjeta+$total_transferencia+$monto_total_f),0,".",",")."bs.",0,1,"L");

$pdf->setX(25);
$pdf->Cell(5,8,"Gastos..  ".number_format($monto_total_gastos,2,".",",")."bs.",0,1,"L");
//$monto_total_gastos
$pdf->setX(20);
$pdf->Cell(5,8,"sub total Efectivo..  ".number_format($total-($total_tarjeta+$total_transferencia+$monto_total_f)-$monto_total_gastos,0,".",",")."bs.",0,1,"L");
$pdf->setX(2);
$pdf->Cell(5,8,'--------------------------------------------------------------',0,1,"L");
$pdf->setX(25);
$pdf->Cell(5,8,"Total..  ".number_format($total-$monto_total_gastos,0,".",",")."bs.",0,1,"L");
 
 
 
///LISTA INSUMO
 /*
$sql = $base_de_datos->query("SELECT productos.codigo,productos.nombre, cierre.cantidad as tienda from cierre ,productos WHERE productos.id=cierre.idproducto and cierre.idcierre='$id';");
$productos = $sql->fetchAll(PDO::FETCH_OBJ);
$monto_total_gastos=0;
// $pdf->Cell(5,5,'QUEDA   EN INVENTARIO',0,1,"center");
$pdf->SetFont('Helvetica','B',6);
$pdf->setX(5);
// $pdf->Cell(5,5,'ARTICULO.                   CANT  ',0,1,"center");
$pdf->Cell(11,5,'codigo',1,0,"center");
$pdf->Cell(40,5,'nombre',1,0,"center");
$pdf->Cell(11,5,'cantidad',1,1,"center");
$total=0;
foreach($productos as $p){
  
$pdf->SetFont('Helvetica','B',8);
$pdf->setX(5);
$pdf->Cell(11,8,( number_format( $p->codigo,0,".",",")),1,0,"L");
$pdf->Cell(40,8,utf8_decode(strtoupper(substr($p->nombre, 0,25))),1,0,"L");
  $pdf->SetFont('Helvetica','B',10);
$pdf->Cell(11,8,( number_format( $p->tienda,0,".",",")),1,1,"C");
$pdf->setX(60);
$pdf->Cell(11,8, '',0,0,"L");
$pdf->setX(30);
 
$total+=$p->tienda;
}
 
 $pdf->setX(5);
$pdf->Cell(60,8,"TOTAL INVENTARIO   :  ". $total,1,1,"C");
*/
 


// detalle venta por pedido 

$sentencia_pedidos = $base_de_datos->query("SELECT 
p.codigo,
v.orden,
v.tarjeta,
v.transferencia,
t.id_venta,
v.entregado,
t.id, 
t.id_producto,
t.descuento,
t.cantidad,
p.nombre, 
t.precio as precioVenta 
FROM ventastienda v
LEFT JOIN productos_vendidos_tienda t on t.id_venta=v.id
LEFT JOIN productos p on p.id=t.id_producto
WHERE v.apertura='$id';");
$pedidos = $sentencia_pedidos->fetchAll(PDO::FETCH_OBJ);

$pdf->setX(2);
$pdf->Cell(5,8,'--------------------------------------------------------------',0,1,"L");
$pdf->SetFont('Helvetica','B',8);
$pdf->setX(20);
$pdf->Cell(8,8,'DETALLE PEDIDOS',0,1,"L");

$pdf->setX(2);
$pdf->Cell(5,8,'#     MESA  PRODUCTO   CANT.  PRECIO   TOTAL',0,0,"center");
$total_pedido=0;
 $pdf->Ln(10);
foreach($pedidos as $p){


$valorY=$pdf->getY();     

$pdf->setY($pdf->getY());
$pdf->SetFont('Helvetica','B',9);
$pdf->setX(4);
$pdf->Cell(11,8,number_format( $p->orden,0,".",",") );
$pdf->setX(10);
$pdf->Cell(11,8,number_format( $p->entregado,0,".",",") );
$pdf->setX(16);
$pdf->SetFont('Helvetica','B',5);
$pdf->Cell(50,8,utf8_decode(strtoupper(substr($p->nombre, 0,25))));
$pdf->SetFont('Helvetica','B',9);
$pdf->setX(42);
$pdf->Cell(50,8, number_format( $p->cantidad,0,".",",") );
$pdf->setX(50);
$pdf->Cell(11,8,( number_format( $p->precioVenta,0,".",",")),0,0,"L");
$pdf->setX(63);
if($p->codigo=='23'){
    
$pdf->Cell(11,8, number_format(($p->precioVenta*$p->cantidad)- $p->descuento,0,".",",") ,0,1,"L");

   $total_pedido+=number_format(($p->precioVenta*$p->cantidad)- $p->descuento,0,".",",");
}else{

$pdf->Cell(11,8, number_format(($p->precioVenta*$p->cantidad)- $p->descuento,1,".",",") ,0,1,"L");    

$total_pedido+=number_format(($p->precioVenta*$p->cantidad)- $p->descuento,1,".",",");
}

}

$pdf->setX(2);
$pdf->Cell(5,8,'--------------------------------------------------------------',0,1,"L");
$pdf->setX(25);
$pdf->Cell(5,8,"Total..  ".number_format($total_pedido,0,".",",")."bs.",0,1,"L");

$pdf->output();