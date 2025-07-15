<?php
//Activamos el almacenamiento en el buffer
  include 'plantilla_de_todas_las_compras.php';
	include_once "../base_de_datos.php";
	$inicio=date("Y-m-d", strtotime($_POST['inicio'])).' 00:00:00';
	$fin=date("Y-m-d", strtotime($_POST['fin'])).' 23:59:59';
 
	$sentencia = $base_de_datos->query("SELECT codigo , productos.nombre,productos.descripcion,SUM(cantidad) as cantidad,sum(productos.precioCompra) as monto,productos.precioVenta as precio,productos.precioCompra as precioCompra from productos_comprados,productos  WHERE productos_comprados.id_producto=productos.id and  productos_comprados.id_compra IN (SELECT id FROM `compras` WHERE fecha BETWEEN '$inicio' AND '$fin')GROUP by  productos_comprados.id_producto");
	$ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);
	

	$venta="";
	date_default_timezone_set("America/La_Paz");
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',9); 
	$pdf->setX(60);
	$pdf->Cell(40,8,"                                  TOTAL COMPRADO: DESDE ".date("d-m-Y", strtotime($inicio))." HASTA ".date("d-m-Y", strtotime($fin)),0,1,'C',0);
	$pdf->setX(10);
	$pdf->Cell(7,6,'N.',1,0,'C',1);
	$pdf->Cell(10,6,'COD',1,0,'C',1);
	$pdf->Cell(40,6,'NOMBRE',1,0,'L',1);
	$pdf->Cell(40,6,'proveedor',1,0,'L',1);
	$pdf->Cell(20,6,'P/ COMPRA',1,0,'L',1);
	$pdf->Cell(20,6,'P/ VENTA',1,0,'L',1);
	$pdf->Cell(20,6,'CANTIDAD',1,0,'L',1);
	$pdf->Cell(20,6,'UTILIDAD',1,0,'L',1);
	$pdf->Cell(10,6,'MONTO',1,1,'L',1);
	
	$pdf->SetFont('Arial','',10);
 $total=0;
 $totalGanancia=0;
 $numero=0;
 $cant=0;
	foreach($ventas as $venta){ 
		$pdf->setX(10);
		$numero++;
		$pdf->Cell(7,6,$numero,1,0,'L',0);
		$pdf->Cell(10,6,$venta->codigo,1,0,'L',0);
		$pdf->SetFont('Arial','B',8); 
		$pdf->Cell(40,6,utf8_decode($venta->nombre),1,0,'L',0);
		$pdf->Cell(40,6,utf8_decode($venta->descripcion),1,0,'L',0);
		$pdf->SetFont('Arial','B',9); 
		$pdf->Cell(20,6,$venta->precioCompra ,1,0,'L',0);
		$pdf->Cell(20,6,$venta->precio ,1,0,'L',0);
		$pdf->Cell(20,6,$venta->cantidad ,1,0,'L',0);
		$cant=$cant+$venta->cantidad;
		$totalGanancia=$totalGanancia+$venta->cantidad * ($venta->precio-$venta->precioCompra);
		$pdf->Cell(20,6,$venta->cantidad * ($venta->precio-$venta->precioCompra),1,0,'L',0);
		$pdf->Cell(10,6,$venta->cantidad * $venta->precioCompra,1,1,'L',0);
		$total=$total+($venta->cantidad * $venta->precioCompra); 

}  
$pdf->setX(10);
$pdf->Cell(10,6,"",0,0,'C',0);
$pdf->Cell(20,6,"",0,0,'C',0);
$pdf->Cell(60,6,"",0,0,'C',0);
$pdf->Cell(20,6,"",0,0,'C',0);
$pdf->Cell(20,6,"",0,0,'C',0);
$pdf->Cell(20,6,$cant,1,0,'C',1);
$pdf->Cell(20,6,$totalGanancia."bs",1,0,'C',1);
$pdf->Cell(20,6,$total."bs",1,1,'C',1);
$pdf->SetFont('Arial','B',10);
$pdf->setX(90);
$pdf->Cell(60,8,"TOTAL ".$total." Bolivianos",1,1,'C');
$pdf->Output();
?>
 