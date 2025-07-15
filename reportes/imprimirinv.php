<?php
//Activamos el almacenamiento en el buffer
 
  include 'plantilla_de_todas_las_vendasinv.php';
  include_once "../base_de_datos.php";
  //$inicio=date("Y-m-d", strtotime($_POST['inicio'])).' 00:00:00';
  //$fin=date("Y-m-d", strtotime($_POST['fin'])).' 23:59:59';
//  SELECT * FROM `ventas` WHERE fecha BETWEEN '2020-09-01 00:00:00' and '2020-09-04 23
// :59:59'


$sentencia1=$base_de_datos->query("SELECT productos.tienda, precioVenta2,precioVenta3,lote,codigo,productos.nombre, descripcion,precioCompra,precioVenta,existencia FROM productos");



  

  $ventas1 = $sentencia1->fetchAll(PDO::FETCH_OBJ);
  // $query = "SELECT e.estado, m.id_municipio, m.municipio FROM t_municipio AS m INNER JOIN t_estado AS e ON m.id_estado=e.id_estado";

  $venta1="";
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
  //$pdf=new PDF('P', 'mm', '200, 300');  
  //$pdf=new FPDF('L','pt','Legal');



  $pdf->AliasNbPages();
  $pdf->AddPage();
  
  


$pdf->SetFillColor(232,232,232);
  $pdf->SetFont('Arial','B',8); 
  $pdf->setX(60);
  //$pdf->Cell(40,8,"                                  REPORTE DE INVENTARIO".date("d-m-Y", strtotime($inicio))." HASTA ".date("d-m-Y", strtotime($fin)),0,1,'C',0);
  $pdf->setX(10);
  //$pdf->Cell(10,6,'N.',1,0,'C',1);
  $pdf->Cell(30,6,'CODIGO',1,0,'C',1);
  $pdf->Cell(70,6,'NOMBRE',1,0,'C',1);
  $pdf->Cell(20,6,'P/ COMPRA',1,0,'C',1);
  $pdf->Cell(20,6,'P/ VENTA',1,0,'C',1);
//   $pdf->Cell(15,6,'Precio2',1,0,'C',1);
//   $pdf->Cell(15,6,'Precio3',1,0,'C',1);
//   $pdf->Cell(15,6,'ALMACEN',1,0,'C',1);
  $pdf->cell(15,6,'STOCK',1,0,'C',1);
  $pdf->cell(15,6,'TOTAL',1,1,'C',1);
   
  //$pdf->Cell(50,6,utf8_decode('fecha'),1,0,'C',1);

  
  $pdf->SetFont('Arial','',7);
 $total1=0;
 $totalGanancia1=0;
 $numero1=0;
 $cant1=0;
 $VENTA1=0;
 $total=0;
  foreach($ventas1 as $venta1){ 
    $pdf->setX(10);
    $numero1++;
  //  $pdf->Cell(10,6,$numero1,1,0,'C',1);
    $pdf->Cell(30,6,$venta1->codigo,1,0,'L',0);
    $pdf->Cell(70,6,utf8_decode($venta1->nombre),1,0,'L',0);
    $pdf->Cell(20,6,$venta1->precioCompra ,1,0,'L',0);
    $pdf->Cell(20,6,$venta1->precioVenta,1,0,'L',0);
    // $pdf->Cell(15,6,$venta1->precioVenta2,1,0,'L',0);
    // $pdf->Cell(15,6,$venta1->precioVenta3,1,0,'L',0);
    $pdf->Cell(15,6,$venta1->tienda,1,0,'L',0);
    $pdf->Cell(15,6,$venta1->precioVenta*$venta1->tienda,1,1,'L',0);
    // $pdf->MultiCell(15,6,$venta1->tienda,1,1);
$total+=$venta1->precioVenta*$venta1->tienda;
}  $pdf->SetFont('Arial','B',7);
$pdf->setX(150);
$pdf->Cell(30,6,'TOTAL: '.$total,1,0,'L',0);
$pdf->setX(10);



  ///////////////////////////////////////////////////////////////

  // $pdf->Cell(260,6,utf8_decode($var),1,1,'C',0);
  $pdf->Output();
?>
 