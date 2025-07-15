<?php
//Activamos el almacenamiento en el buffer
 
  include 'plantilla_producto.php';
	include_once "../base_de_datos.php";
	$inicio=date("Y-m-d", strtotime($_POST['inicio'])).' 00:00:00';
	$fin=date("Y-m-d", strtotime($_POST['fin'])).' 23:59:59';
	$vendedor=0; 
	$idproducto=$_POST['idproducto']; 
	 

	$sentencia = $base_de_datos->query("SELECT   
	ventastienda.fecha, cliente.nombre as 
	cliente, productos.codigo,
	productos.nombre,
	productos_vendidos_tienda.cantidad,
	productos_vendidos_tienda.precio, 
	productos_vendidos_tienda.descuento, 
	productos.precioCompra as costo,
	productos_vendidos_tienda.precio*productos_vendidos_tienda.cantidad as total
	FROM cliente, productos, `ventastienda`,productos_vendidos_tienda
	WHERE  ventastienda.id=productos_vendidos_tienda.id_venta
    and productos_vendidos_tienda.id_producto='$idproducto'
    AND ventastienda.fecha BETWEEN '$inicio'  and '$fin' 
    and productos.id=productos_vendidos_tienda.id_producto
    and cliente.id=ventastienda.cliente; ;");

	$ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);

	$venta="";
	date_default_timezone_set("America/La_Paz");
  
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',12);
	$pdf->setX(15);
	//$pdf->Image('../files/imagenes/logo_boliviansoftware.png',15,10,20,0,'png');
	$pdf->setY(30);
	$pdf->setX(10);

	//$pdf->Cell(35,10,'bolivian software',0,1,'L',1);

	$pdf->setX(60);
	$pdf->Cell(40,8, "REPORTE DE VENTAS POR PRODUCTO",0,1,'L',0);
	$pdf->setX(60);
	$pdf->Cell(40,8,"  DESDE ".date("d-m-Y", strtotime($inicio))." HASTA ".date("d-m-Y", strtotime($fin)),0,1,'L',0);
	$pdf->setX(70);
	//$pdf->Cell(40,8,"CODIGO DE PRODUCTO ".$idproducto,0,1,'L',0);
	$pdf->setX(10);
	//$pdf->Cell(5,6,'#.',1,0,'L',1);
	$pdf->Cell(15,6,'fecha',1,0,'L',1);
	$pdf->Cell(40,6,'cliente',1,0,'L',1);
	$pdf->Cell(15,6,'codigo',1,0,'L',1);
	$pdf->Cell(25,6,'producto',1,0,'L',1);
	 $pdf->Cell(15,6,'costo',1,0,'L',1);
	$pdf->Cell(15,6,'venta',1,0,'L',1);
	$pdf->Cell(20,6,'descuento',1,0,'L',1);
	$pdf->Cell(15,6,'cantidad',1,0,'L',1);
	
	$pdf->Cell(20,6,'TOTAL',1,1,'L',1);
	
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
 $descuento=0;
 foreach($ventas as $venta){ 
	 
		$pdf->setX(10);
		 
	//	$pdf->Cell(5,6,$venta->id,1,0,'L',0);
		$pdf->SetFont('Arial','B',6);
		$cant+=$venta->cantidad;
	    $pdf->SetFont('Arial','B',7); 
		$pdf->Cell(15,6, ($venta->fecha) ,1,0,'L',0);
		$pdf->Cell(40,6,utf8_decode($venta->cliente),1,0,'L',0);
		$pdf->Cell(15,6,utf8_decode($venta->codigo),1,0,'L',0);
		$pdf->Cell(25,6,utf8_decode($venta->nombre),1,0,'L',0);
		// $pdf->Cell(15,6, ($utilidad_por_producto),1,0,'L',0);
		$pdf->Cell(15,6, ($venta->costo),1,0,'L',0);
		$pdf->Cell(15,6,utf8_decode($venta->precio),1,0,'L',0);
		$pdf->Cell(20,6,utf8_decode($venta->descuento),1,0,'L',0);
		$pdf->Cell(15,6,number_format($venta->cantidad,2,",",".") ,1,0,'L',0);
		$pdf->Cell(20,6,number_format($venta->total,2,",",".") ,1,1,'L',0);
		//$pdf->Cell(15,6, $total,1,1,'L',0);
		$total_venta+=$venta->total;
		$total_compra+=$venta->costo*$venta->cantidad;
		$descuento=$venta->descuento;
	$pdf->SetFont('Arial','B',10); 

	 
		 
 }  
$pdf->setX(105);
$pdf->Cell(15,6,$total_compra,1,0,'L',0);
$pdf->Cell(15,6,'',1,0,'L',0);
$pdf->Cell(20,6,$descuento,1,0,'L',0);
$pdf->Cell(15,6,$cant,1,0,'L',0);
//$pdf->Cell(20,6,"Bs",1,0,'L',1);
 
$pdf->Cell(20,6,$total_venta,1,1,'L',1);
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
$pdf->Cell(30,6,$total_compra."bs",1,1,'L',1);
$pdf->SetFont('Arial','B',10);
  $pdf->setX(90);

$pdf->setX(10);
//$pdf->Cell(10,6,"",0,0,'L',0);
$pdf->Cell(20,6,"",0,0,'L',0);
$pdf->Cell(60,6,"",0,0,'L',0);
$pdf->Cell(23,6,"",0,0,'L',0);
$pdf->Cell(23,6,"",0,0,'L',0);
$pdf->Cell(30,6,"UTILIDAD",1,0,'L',1);
$pdf->Cell(30,6,$total_venta-$total_compra,1,1,'L',1);
$pdf->SetFont('Arial','B',10);
  $pdf->setX(90);



//   $pdf->Cell(40,8,"TOTAL ".$total_venta." Bolivianos",1,1,'L');
	// $pdf->Cell(260,6,utf8_decode($var),1,1,'L',0);
	$pdf->Output();
?>
 