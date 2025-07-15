<?php
//Activamos el almacenamiento en el buffer
 
  include 'plantilla_de_todas_las_vendas.php';
	include_once "../base_de_datos.php";
	$inicio=date("Y-m-d", strtotime($_POST['inicio'])).' 00:00:00';
	$fin=date("Y-m-d", strtotime($_POST['fin'])).' 23:59:59';
// 	SELECT * FROM `ventas` WHERE fecha BETWEEN '2020-09-01 00:00:00' and '2020-09-04 23
// :59:59'
	// $sentencia = $base_de_datos->query("SELECT codigo , productos.descripcion,productos.nombre,SUM(cantidad) as cantidad, sum(productos.precioVenta) as monto,productos.precioVenta as precio,productos.precioCompra as precioCompra from productos_vendidos,productos  WHERE productos_vendidos.id_producto=productos.id and  productos_vendidos.id_venta IN (SELECT id FROM `ventas` WHERE fecha BETWEEN '$inicio' AND '$fin') GROUP by  productos_vendidos.id_producto");
	$sentencia = $base_de_datos->query("SELECT ventas.id,productos.codigo,ventas.fecha,ventas.hora, productos.nombre as nombre_producto,productos_vendidos.precio ,productos_vendidos.descuento, tipoVenta.nombre as tipo_venta, usuario.usuario FROM usuario, `ventas`,productos_vendidos ,productos,tipoVenta WHERE ventas.fecha BETWEEN '$inicio' AND '$fin' and  ventas.id=productos_vendidos.id_venta and productos.id=productos_vendidos.id_producto and tipoVenta.id=ventas.tipoDeVenta and usuario.id=ventas.idUsuario;	");
	//$ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);

	//$sentencia = $base_de_datos->query("SELECT codigo , productos.nombre,(cantidad) as cantidad, sum(productos.precioVenta) as monto,productos.precioVenta as precio,productos.precioCompra as precioCompra from productos_vendidos,productos  WHERE productos_vendidos.id_producto=productos.id and  productos_vendidos.id_venta IN (SELECT id FROM `ventas` WHERE fecha BETWEEN '$inicio' AND '$fin') GROUP by  productos_vendidos.id_producto");
	$ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);
	

	// $query = "SELECT e.estado, m.id_municipio, m.municipio FROM t_municipio AS m INNER JOIN t_estado AS e ON m.id_estado=e.id_estado";
	$venta="";
	date_default_timezone_set("America/La_Paz");
  
	// $hoy=date('Y-m-d');
	// $hoy=date('Y-m-d');
	// $id_usuario=$_SESSION['idusuario'];
	// $inicio='2019-04-01';
	// $fin='2019-04-28';
	// SELECT    id_producto , productos.descripcion,SUM(cantidad) as cantidad,sum(productos.precioVenta)  from productos_vendidos,productos  WHERE productos_vendidos.id_producto=productos.id and  productos_vendidos.id_venta IN (SELECT id FROM `ventas` WHERE fecha BETWEEN '2020-08-24 01:11:50' AND '2020-09-26 07:07:04') GROUP by  productos_vendidos.id_producto	
	// SELECT COUNT(id_producto) as idprod , SUM(cantidad) as cantidad, productos.descripcion from productos_vendidos,productos WHERE productos_vendidos.id_producto=productos.id and productos_vendidos.id_venta IN (SELECT id FROM `ventas` WHERE fecha BETWEEN '2020-08-24 01:11:50' AND '2020-09-26 07:07:04') GROUP by productos_vendidos.id_producto
  //  $query = "SELECT * FROM venta WHERE     condicion=1 and fecha_hora between '$inicio' AND '$fin' ORDER BY glosa asc";
  
    # code...
  //   $query = "SELECT * FROM venta WHERE (fecha_hora BETWEEN '$inicio' AND '$fin')  and estado='Aceptado'";
	// $resultado = ejecutarConsulta($query);
  
  //   $query = "SELECT * FROM venta WHERE (fecha_hora BETWEEN '$inicio' AND '$fin') and estado='Aceptado'";
	// $resultado = ejecutarConsulta($query);

 
	
	 
	//  SELECT detalle_venta.cantidad,articulo.nombre,detalle_venta.precio_venta FROM detalle_venta ,articulo WHERE detalle_venta.iddetalle_venta='16' AND articulo.idarticulo=detalle_venta.idarticulo

	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',12); 
	$pdf->setX(60);
	$pdf->Cell(40,8,"  TOTAL VENDIDO: DESDE ".date("d-m-Y", strtotime($inicio))." HASTA ".date("d-m-Y", strtotime($fin)),0,1,'L',0);
	$pdf->setX(10);
	$pdf->Cell(10,6,'#venta.',1,0,'L',1);
	$pdf->Cell(20,6,'Codigo',1,0,'L',1);
	$pdf->Cell(40,6,'fecha',1,0,'L',1);
	$pdf->Cell(40,6,'nombre',1,0,'L',1);
	$pdf->Cell(25,6,'Precio',1,0,'L',1);
	$pdf->Cell(25,6,'descuento',1,0,'L',1);
	$pdf->Cell(25,6,'nombre',1,0,'L',1);
	$pdf->Cell(25,6,'usuario',1,0,'L',1);
	$pdf->Cell(25,6,'TOTAL',1,1,'L',1);
	
	$pdf->SetFont('Arial','',10);
 $total=0;
 $totalGanancia=0;
 $numero=0;
 $VENTA=0;
 $cant=0;

	foreach($ventas as $venta){ 
		$pdf->setX(10);
		$numero++;
		//$pdf->Cell(10,6,$numero,1,0,'L',1);
		$pdf->Cell(20,6,$venta->id,1,0,'L',0);
		$pdf->Cell(20,6,$venta->codigo,1,0,'L',0);
	$pdf->SetFont('Arial','B',9); 

		$pdf->Cell(40,6, ($venta->fecha)." ".$venta->hora,1,0,'L',0);
		$pdf->Cell(40,6,utf8_decode($venta->nombre_producto),1,0,'L',0);
		$pdf->Cell(40,6,utf8_decode($venta->precio),1,0,'L',0);
		$pdf->Cell(40,6,utf8_decode($venta->descuento),1,0,'L',0);
		$pdf->Cell(40,6,utf8_decode($venta->tipo_venta),1,0,'L',0);
		$pdf->Cell(40,6, ($venta->precio *$venta->cantidad),1,0,'L',0);
	$pdf->SetFont('Arial','B',10); 

		// $pdf->Cell(25,6,$venta->precio ." Bs.",1,0,'L',0);
		// $pdf->Cell(25,6,$venta->cantidad ."",1,0,'L',0);
		//$pdf->Cell(20,6,"",1,0,'L',1);
		$cant=$cant+$venta->cantidad;
		$totalGanancia=$totalGanancia+$venta->cantidad * ($venta->precio-$venta->precioCompra);

		// $pdf->Cell(25,6, $venta->cantidad * ($venta->precio-$venta->precioCompra)." Bs.",1,0,'L',0);

		// $pdf->Cell(25,6,$venta->cantidad * $venta->precio." Bs.",1,1,'L',0);

		$total=$total+($venta->cantidad * $venta->precio); 

		$VENTA=$total-$totalGanancia;
	
}  
$pdf->setX(10);
//$pdf->Cell(10,6,"",0,0,'L',0);
$pdf->Cell(20,6,"",0,0,'L',0);
$pdf->Cell(40,6,"",0,0,'L',0);
$pdf->Cell(40,6,"",0,0,'L',0);
$pdf->Cell(25,6,"",0,0,'L',0);
$pdf->Cell(25,6,$cant."",1,0,'L',1);
//$pdf->Cell(20,6,"Bs",1,0,'L',1);
$pdf->Cell(25,6,$totalGanancia."bs",1,0,'L',1);
$pdf->Cell(25,6,$total."bs",1,1,'L',1);
$pdf->SetFont('Arial','B',10);
  $pdf->setX(90);


$pdf->setX(10);
//$pdf->Cell(10,6,"",0,0,'L',0);
$pdf->Cell(20,6,"",0,0,'L',0);
$pdf->Cell(60,6,"",0,0,'L',0);
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
$pdf->Cell(30,6,$total."bs",1,1,'L',1);
$pdf->SetFont('Arial','B',10);
  $pdf->setX(90);

$pdf->setX(10);
//$pdf->Cell(10,6,"",0,0,'L',0);
$pdf->Cell(20,6,"",0,0,'L',0);
$pdf->Cell(60,6,"",0,0,'L',0);
$pdf->Cell(23,6,"",0,0,'L',0);
$pdf->Cell(23,6,"",0,0,'L',0);
$pdf->Cell(30,6,"TOTAL COSTO",1,0,'L',1);
$pdf->Cell(30,6,$VENTA."bs",1,1,'L',1);
$pdf->SetFont('Arial','B',10);
  $pdf->setX(90);

$pdf->setX(10);
//$pdf->Cell(10,6,"",0,0,'L',0);
$pdf->Cell(20,6,"",0,0,'L',0);
$pdf->Cell(60,6,"",0,0,'L',0);
$pdf->Cell(23,6,"",0,0,'L',0);
$pdf->Cell(23,6,"",0,0,'L',0);
$pdf->Cell(30,6,"UTILIDAD",1,0,'L',1);
$pdf->Cell(30,6,$totalGanancia."bs",1,1,'L',1);
$pdf->SetFont('Arial','B',10);
  $pdf->setX(90);



  $pdf->Cell(40,8,"TOTAL ".$total." Bolivianos",1,1,'L');
	// $pdf->Cell(260,6,utf8_decode($var),1,1,'L',0);
	$pdf->Output();
?>
 