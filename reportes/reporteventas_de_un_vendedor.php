<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();

if (!isset($_SESSION["nombre"]))
{
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
}
else
{
if ($_SESSION['ventas']==1)
{
  include 'plantilla_socio_individual.php';
	require "../config/Conexion.php";
	

	// $query = "SELECT e.estado, m.id_municipio, m.municipio FROM t_municipio AS m INNER JOIN t_estado AS e ON m.id_estado=e.id_estado";
	date_default_timezone_set("America/La_Paz");
	// $hoy=date('Y-m-d');
	// $hoy=date('Y-m-d');
	$id_usuario=$_SESSION['idusuario'];
	$inicio=$_POST['inicio'];
	$fin=$_POST['fin'];
	// $inicio='2019-04-01';
	// $fin='2019-04-28';
	
	
  //  $query = "SELECT * FROM venta WHERE     condicion=1 and fecha_hora between '$inicio' AND '$fin' ORDER BY glosa asc";
  if ($_SESSION['acceso']==1) {
    # code...
    $query = "SELECT * FROM venta WHERE (fecha_hora BETWEEN '$inicio' AND '$fin')  and estado='Aceptado'";
	$resultado = ejecutarConsulta($query);
  }else{
    $query = "SELECT * FROM venta WHERE (fecha_hora BETWEEN '$inicio' AND '$fin') and idusuario='$id_usuario' and estado='Aceptado'";
	$resultado = ejecutarConsulta($query);

  }
	
	 
	//  SELECT detalle_venta.cantidad,articulo.nombre,detalle_venta.precio_venta FROM detalle_venta ,articulo WHERE detalle_venta.iddetalle_venta='16' AND articulo.idarticulo=detalle_venta.idarticulo

	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',12); 
	$querytt = "SELECT * FROM usuario WHERE idusuario='$id_usuario' ";
		$resultadott = ejecutarConsulta($querytt);
		while($rowtt = $resultadott->fetch_assoc())
	{ 
		 $pdf->setX(30);
		// $query2 = "SELECT * FROM venta WHERE (fecha_hora BETWEEN '$inicio' AND '$fin') and idusuario='$id_usuario'";
		$pdf->Cell(30,6,utf8_decode("Nombre del vendedor: ".$rowtt['nombre']),0,1,'C');
	}
	$pdf->setX(30);
	$pdf->Cell(50,6,'codigo de la venta',1,0,'C',1);
	$pdf->Cell(20,6,'cantidad',1,0,'C',1);
	$pdf->Cell(50,6,'productos',1,0,'C',1);
	 
	//$pdf->Cell(50,6,utf8_decode('fecha'),1,0,'C',1);
	$pdf->Cell(30,6,'PRECIO',1,1,'C',1);
	 
	// $pdf->Cell(25,6,'SUB-TOTAL',1,1,'C',1);
	
	$pdf->SetFont('Arial','',10);
	$var=0;
	$cantidad=0;
	$tarjeta=0;
	$apsocio=0;
	$total=0; 
	
	while($row = $resultado->fetch_assoc())
	{ 
		$iddventa=$row['idventa'];
		$fecha=$row['fecha_hora'];
		$total=$total+ $row['total_venta'];
		$queryt = "SELECT detalle_venta.idventa as idventa,detalle_venta.cantidad as cantidad,articulo.nombre as nombre,detalle_venta.precio_venta as precio_venta FROM detalle_venta ,articulo WHERE detalle_venta.idventa='$iddventa' AND articulo.idarticulo=detalle_venta.idarticulo";
    $resultadot = ejecutarConsulta($queryt);
    $total_ventas=0;
		while($rowt = $resultadot->fetch_assoc())
	  { 
		 $pdf->setX(30);
      $pdf->Cell(50,6,utf8_decode($rowt['idventa']),1,0,'C');
      $pdf->Cell(20,6,utf8_decode($rowt['cantidad']),1,0,'C');
      $pdf->Cell(50,6,utf8_decode($rowt['nombre']),1,0,'C');
      $pdf->Cell(30,6,utf8_decode($rowt['precio_venta']),1,1,'C');
      $total_ventas=$total_ventas+$rowt['precio_venta'];
    }
    $pdf->setX(150);
    $pdf->Cell(30,6,utf8_decode("Total bs".$total_ventas),0,1,'C');
	}
  
	$pdf->SetFont('Arial','B',10);
  $pdf->setX(60);
	$pdf->Cell(40,8,"                                  TOTAL VENDIDO: DESDE ".date("d/m/Y", strtotime($inicio))." HASTA ".date("d/m/Y", strtotime($fin)),0,1,'C',0);
  $pdf->setX(90);
  $pdf->Cell(30,6,$total." Bolivianos",1,1,'C');
	// $pdf->Cell(260,6,utf8_decode($var),1,1,'C',0);
	$pdf->Output();
?>
<?php
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>