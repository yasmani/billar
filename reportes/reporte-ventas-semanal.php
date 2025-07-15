<?php
//Activamos el almacenamiento en el buffer
 
  include 'plantilla_de_todas_las_vendas.php';
	include_once "../base_de_datos.php";
	$inicio=date("Y-m-d", strtotime($_POST['inicio'])).' 00:00:00';
	$fin=date("Y-m-d", strtotime($_POST['fin'])).' 23:59:59';
	$sentencia = $base_de_datos->query("SELECT productos.precioCompra, ventas.id,productos.codigo,ventas.fecha,ventas.hora, productos.nombre as nombre_producto,productos_vendidos.precio ,productos_vendidos.descuento,productos_vendidos.cantidad, tipoVenta.nombre as tipo_venta, usuario.usuario,productos_vendidos.cantidad FROM usuario, `ventas`,productos_vendidos ,productos,tipoVenta WHERE ventas.fecha BETWEEN '$inicio' AND '$fin' and  ventas.id=productos_vendidos.id_venta and productos.id=productos_vendidos.id_producto and tipoVenta.id=ventas.tipoDeVenta and usuario.id=ventas.idUsuario;	");

	$ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);

	$venta="";
	date_default_timezone_set("America/La_Paz");
  
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',12);
	$pdf->setX(15);
	$pdf->Image('../files/imagenes/logo_boliviansoftware.png',15,10,20,0,'png');
	$pdf->setY(30);
	$pdf->setX(10);

	$pdf->Cell(35,10,'bolivian software',0,1,'L',1);

	$pdf->setX(60);
	$pdf->Cell(40,8,"  TOTAL VENDIDO: DESDE ".date("d-m-Y", strtotime($inicio))." HASTA ".date("d-m-Y", strtotime($fin)),0,1,'L',0);
	$pdf->setX(10);
	$pdf->Cell(10,6,'#.',1,0,'L',1);
	$pdf->Cell(10,6,'cod',1,0,'L',1);
	$pdf->Cell(25,6,'fecha',1,0,'L',1);
	$pdf->Cell(50,6,'nombre',1,0,'L',1);
	$pdf->Cell(15,6,'precio',1,0,'L',1);
	$pdf->Cell(15,6,'cant',1,0,'L',1);
	$pdf->Cell(15,6,'utilidad',1,0,'L',1);
	$pdf->Cell(15,6,'venta',1,0,'L',1);
	$pdf->Cell(25,6,'vendedor',1,0,'L',1);
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
 foreach($ventas as $venta){ 
	$total_capital+=$venta->precioCompra;
		$utilidad_por_producto=0;
		$pdf->setX(10);
		$numero++;
		$total=($venta->precio *$venta->cantidad)-$venta->descuento;
		$total_descuento+=$venta->descuento;
		$utilidad_por_producto=(($venta->precio-$venta->precioCompra) * $venta->cantidad )-$venta->descuento;
		$pdf->Cell(10,6,$venta->id,1,0,'L',0);
		$pdf->Cell(10,6,$venta->codigo,1,0,'L',0);
	    $pdf->SetFont('Arial','B',7); 
		$pdf->Cell(25,6, ($venta->fecha)." ".$venta->hora,1,0,'L',0);
		$pdf->Cell(50,6,utf8_decode($venta->nombre_producto),1,0,'L',0);
		$pdf->Cell(15,6,utf8_decode($venta->precio),1,0,'L',0);
		$pdf->Cell(15,6,utf8_decode($venta->cantidad),1,0,'L',0);
		$pdf->Cell(15,6, ($utilidad_por_producto),1,0,'L',0);
		$pdf->Cell(15,6,utf8_decode($venta->tipo_venta),1,0,'L',0);
		$pdf->Cell(25,6,utf8_decode($venta->usuario),1,0,'L',0);
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
$pdf->Cell(25,6,"",1,0,'L',1);
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
$pdf->Cell(30,6,"TOTAL VENTA",1,0,'L',1);
$pdf->Cell(30,6,$total_venta."bs",1,1,'L',1);
$pdf->SetFont('Arial','B',10);
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
$pdf->Cell(30,6,$total_utilidad_por_producto."bs",1,1,'L',1);
$pdf->SetFont('Arial','B',10);
  $pdf->setX(90);



  $pdf->Cell(40,8,"TOTAL ".$total_venta." Bolivianos",1,1,'L');
	// $pdf->Cell(260,6,utf8_decode($var),1,1,'L',0);
	$pdf->Output();
?>
 