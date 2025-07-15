<?php
//Activamos el almacenamiento en el buffer
 
  include 'plantilla_de_todas_las_vendas.php';
	include_once "../base_de_datos.php";
	$inicio=date("Y-m-d", strtotime($_POST['inicio'])).' 00:00:00';
	$fin=date("Y-m-d", strtotime($_POST['fin'])).' 23:59:59';
	$vendedor=0; 
	$vendedor=$_POST['usuario']; 

	$sentencia = $base_de_datos->query("SELECT productos.precioCompra, ventastienda.id,productos.codigo,ventastienda.fecha,ventastienda.hora, productos.nombre as nombre_producto,productos_vendidos_tienda.precio as precio ,productos_vendidos_tienda.descuento,productos_vendidos_tienda.cantidad, tipoVenta.nombre as tipo_venta, usuario.usuario,productos_vendidos_tienda.cantidad FROM usuario, `ventastienda`,productos_vendidos_tienda ,productos,tipoVenta WHERE ventastienda.fecha BETWEEN '$inicio' AND '$fin' and  ventastienda.id=productos_vendidos_tienda.id_venta and productos.id=productos_vendidos_tienda.id_producto and tipoVenta.id=ventastienda.tipoDeVenta and usuario.id=ventastienda.idUsuario and '$vendedor'=ventastienda.idUsuario   ;");
	$sql = $base_de_datos->query("SELECT sum(total) as total, sum(descuento)as descuento from  ventastienda  where  ventastienda.fecha BETWEEN '$inicio' AND '$fin' and '$vendedor'=ventastienda.idUsuario ;");
	$resumenventas = $sql->fetchAll(PDO::FETCH_OBJ);

	$ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);

	$venta="";
	date_default_timezone_set("America/La_Paz");
  
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',12);
	$pdf->setX(15);
	// $pdf->Image('../files/imagenes/logo_boliviansoftware.png',15,10,20,0,'png');
	$pdf->setY(30);
	$pdf->setX(10);

	$pdf->Cell(35,10,'bolivian software',0,1,'L',1);

	$pdf->setX(60);
	$pdf->Cell(40,8,$vendedor."  TOTAL VENDIDO: DESDE ".date("d-m-Y", strtotime($inicio))." HASTA ".date("d-m-Y", strtotime($fin)),0,1,'L',0);
	$pdf->setX(10);
	//$pdf->Cell(5,6,'#.',1,0,'L',1);
	$pdf->Cell(20,6,'cod',1,0,'L',1);
	$pdf->Cell(25,6,'fecha',1,0,'L',1);
	$pdf->Cell(50,6,'nombre',1,0,'L',1);
	$pdf->Cell(15,6,'precio',1,0,'L',1);
	$pdf->Cell(15,6,'cant',1,0,'L',1);
	$pdf->Cell(15,6,'utilidad',1,0,'L',1);
	$pdf->Cell(15,6,'venta',1,0,'L',1);
	$pdf->Cell(20,6,'vendedor',1,0,'L',1);
	$pdf->Cell(15,6,'TOTAL',1,1,'L',1);
	
	$pdf->SetFont('Arial','B',10);
 $total_venta=0;
 $totalGanancia=0;
 $numero=0;
 $VENTA=0;
 $cant=0;
 $total_descuento=0;
 $total_utilidad_por_producto=0;
 $total_compra=0;
 $total_capital=0;

 $totalventasd=0;
 $descuento=0;
 foreach($resumenventas as $re){ 
	$totalventasd=$re->total;
	$descuento=$re->descuento;
 }
 foreach($ventas as $venta){ 
	$total_capital+=$venta->precioCompra;
		$utilidad_por_producto=0;
		$pdf->setX(10);
		$numero++;
		$total=($venta->precio *$venta->cantidad)-$venta->descuento;
		$total_descuento+=$venta->descuento;
		$utilidad_por_producto=(($venta->precio-$venta->precioCompra) * $venta->cantidad )-$venta->descuento;
	//	$pdf->Cell(5,6,$venta->id,1,0,'L',0);
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(20,6,$venta->codigo,1,0,'L',0);

	    $pdf->SetFont('Arial','B',7); 
		$pdf->Cell(25,6, ($venta->fecha)." ".$venta->hora,1,0,'L',0);
		$pdf->Cell(50,6,utf8_decode($venta->nombre_producto),1,0,'L',0);
		$pdf->Cell(15,6,utf8_decode($venta->precio),1,0,'L',0);
		$pdf->Cell(15,6,utf8_decode($venta->cantidad),1,0,'L',0);
		$pdf->Cell(15,6, ($utilidad_por_producto),1,0,'L',0);
		$pdf->Cell(15,6, ($venta->tipo_venta),1,0,'L',0);
		$pdf->Cell(20,6,utf8_decode($venta->usuario),1,0,'L',0);
		$pdf->Cell(15,6, $total,1,1,'L',0);
	$pdf->SetFont('Arial','B',10); 

		
		$cant=$cant+$venta->cantidad;
		$total_utilidad_por_producto+=$utilidad_por_producto;
		$total_venta+=$total;
		$total_compra+=$venta->precioCompra;
}  
$pdf->setX(105);
$pdf->Cell(15,6,"",1,0,'L',1);
$pdf->Cell(15,6,$total_descuento,1,0,'L',0);
$pdf->Cell(15,6,$total_utilidad_por_producto,1,0,'L',0);
//$pdf->Cell(20,6,"Bs",1,0,'L',1);
$pdf->Cell(15,6,"",1,0,'L',1);
$pdf->Cell(20,6,"",1,0,'L',1);
$pdf->Cell(15,6,$total_venta,1,1,'L',1);
$pdf->SetFont('Arial','B',10);
  $pdf->setX(90);


$pdf->setX(10);
//$pdf->Cell(10,6,"",0,0,'L',0);
$pdf->Cell(25,6,"",0,0,'L',0);
$pdf->Cell(15,6,"",0,0,'L',0);
$pdf->Cell(23,6,"",0,0,'L',0);
//$pdf->Cell(23,6,"",0,0,'L',1);
$pdf->Cell(30,6,"",0,0,'L',0);
$pdf->Cell(30,6,"",0,1,'L',0);
$pdf->SetFont('Arial','B',10);
  $pdf->setX(90);

$pdf->setX(10);
//$pdf->Cell(10,6,"",0,0,'L',0);
$pdf->Cell(20,6,"",0,0,'L',0);
$pdf->Cell(60,6,"",0,0,'L',0);
$pdf->Cell(23,6,"",0,0,'L',0);
$pdf->Cell(23,6,"",0,0,'L',0);
$pdf->Cell(30,6,"SUB TOTAL  ",1,0,'L',1);
$pdf->Cell(30,6,$total_venta."bs",1,1,'L',1);
$pdf->setX(10);
//$pdf->Cell(10,6,"",0,0,'L',0);
$pdf->Cell(20,6,"",0,0,'L',0);
$pdf->Cell(60,6,"",0,0,'L',0);
$pdf->Cell(23,6,"",0,0,'L',0);
$pdf->Cell(23,6,"",0,0,'L',0);
$pdf->Cell(30,6,"DESCUENTO",1,0,'L',1);
$pdf->Cell(30,6,$descuento."bs",1,1,'L',1);
$pdf->SetFont('Arial','B',10);

$pdf->setX(10);
//$pdf->Cell(10,6,"",0,0,'L',0);
$pdf->Cell(20,6,"",0,0,'L',0);
$pdf->Cell(60,6,"",0,0,'L',0);
$pdf->Cell(23,6,"",0,0,'L',0);
$pdf->Cell(23,6,"",0,0,'L',0);
$pdf->Cell(30,6,"  TOTAL ",1,0,'L',1);
$pdf->Cell(30,6,$total_venta-$descuento."bs",1,1,'L',1);
  $pdf->setX(90);

$pdf->setX(10);
//$pdf->Cell(10,6,"",0,0,'L',0);
$pdf->Cell(20,6,"",0,0,'L',0);
$pdf->Cell(60,6,"",0,0,'L',0);
$pdf->Cell(23,6,"",0,0,'L',0);
$pdf->Cell(23,6,"",0,0,'L',0);
$pdf->Cell(30,6,"TOTAL COSTO",1,0,'L',1);
$pdf->Cell(30,6,$total_capital."bs",1,1,'L',1);
$pdf->SetFont('Arial','B',10);
  $pdf->setX(90);

$pdf->setX(10);
//$pdf->Cell(10,6,"",0,0,'L',0);
$pdf->Cell(20,6,"",0,0,'L',0);
$pdf->Cell(60,6,"",0,0,'L',0);
$pdf->Cell(23,6,"",0,0,'L',0);
$pdf->Cell(23,6,"",0,0,'L',0);
$pdf->Cell(30,6,"UTILIDAD",1,0,'L',1);
$pdf->Cell(30,6,($total_utilidad_por_producto - $descuento)."bs",1,1,'L',1);
$pdf->SetFont('Arial','B',10);
  $pdf->setX(90);



  $pdf->Cell(40,8,"TOTAL ".$total_venta." Bolivianos",1,1,'L');
	// $pdf->Cell(260,6,utf8_decode($var),1,1,'L',0);
	$pdf->Output();
?>
 