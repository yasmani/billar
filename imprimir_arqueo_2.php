<?php
include_once "base_de_datos.php";
include "./fpdf181/fpdf.php";

date_default_timezone_set("America/La_Paz");

$fecha_inicio = $_POST['inicio'];
$fecha_fin = $_POST['fin'];

$pdf = new FPDF($orientation = 'P', $unit = 'mm', array(80, 600));
$pdf->AddPage();
$pdf->SetFont('Helvetica', 'B', 20);
$pdf->setX(5);
$pdf->Cell(40, 10, "REPORTE VENTAS", 0, 1, "L");

$pdf->SetFont('Courier', 'B', 10);
$pdf->setX(5);
$pdf->Cell(5, 5, "Desde : " . date("d/m/Y", strtotime($fecha_inicio)), 0, 1, 'L');
$pdf->setX(5);
$pdf->Cell(5, 5, "Hasta : " . date("d/m/Y", strtotime($fecha_fin)), 0, 1, 'L');
$pdf->Ln(5);

// === CONSULTA ===

$inicio_dt = new DateTime($fecha_inicio . ' 00:00:00');
$fin_dt = new DateTime($fecha_fin . ' 09:00:00');
$fin_dt->modify('+1 day'); // suma un día

// Convertir a formato Y-m-d H:i:s
$inicio_str = $inicio_dt->format('Y-m-d H:i:s');
$fin_str = $fin_dt->format('Y-m-d H:i:s');

/*$sentencia = $base_de_datos->prepare("
    SELECT 
        a.fecha,
        CASE 
            WHEN t.id_producto IN (23, 321) THEN 'BILLAR'
            WHEN t.id_producto IN (317, 330) THEN 'ATENCION'
            ELSE 'CONSUMO'
        END AS codigo_grupo,
        SUM(t.cantidad) AS cantidad,
        SUM(t.precio * t.cantidad) AS total
    FROM productos_vendidos_tienda t
    INNER JOIN apertura_tienda a ON a.id = t.apertura
    WHERE a.fecha BETWEEN :inicio AND :fin
    GROUP BY a.fecha,
             CASE 
                 WHEN t.id_producto IN (23, 321) THEN 'BILLAR'
                 WHEN t.id_producto IN (317, 330) THEN 'ATENCION'
                 ELSE 'CONSUMO'
             END
    ORDER BY a.fecha, t.id_producto;
");*/

$sentencia = $base_de_datos->prepare("
   SELECT 
        a.id,
        a.fecha
    FROM apertura_tienda a
    WHERE a.fecha BETWEEN :inicio  AND :fin
    ORDER BY a.fecha;
");


$sentencia->execute([
    ':inicio' => $inicio_str,
    ':fin' => $fin_str
]);


$aperturas = $sentencia->fetchAll(PDO::FETCH_OBJ);

// === AGRUPAR DATOS ===
/*$datosPorFecha = [];
$totalGeneral = 0;

foreach ($productos as $producto) {
    $fecha = $producto->fecha;
    $grupo = $producto->codigo_grupo;

    if (!isset($datosPorFecha[$fecha])) {
        $datosPorFecha[$fecha] = [
            'CONSUMO' => ['total' => 0],
            'BILLAR' => ['total' => 0],
            'ATENCION' => ['total' => 0],
        ];
    }

    $datosPorFecha[$fecha][$grupo]['total'] = $producto->total;
    $totalGeneral += $producto->total;
}

// === ORDENAR POR FECHA ===
ksort($datosPorFecha);*/

// === ENCABEZADO DE TABLA ===
$pdf->SetFont('Helvetica', 'B', 7);
$pdf->setX(2);
$pdf->Cell(11, 8, 'FECHA', 0, 0, 'L');
$pdf->Cell(16, 8, 'CONSUMO', 0, 0, 'R');
$pdf->Cell(15, 8, 'BILLAR', 0, 0, 'R');
$pdf->Cell(18, 8, 'ATENCION', 0, 0, 'R');
$pdf->Cell(11, 8, 'TOTAL', 0, 1, 'R');

// === DETALLES POR FECHA ===
$pdf->SetFont('Helvetica', '', 9);

/*foreach ($datosPorFecha as $fecha => $grupos) {
    $consumo = $grupos['CONSUMO']['total'] ?? 0;
    $billar = $grupos['BILLAR']['total'] ?? 0;
    $atencion = $grupos['ATENCION']['total'] ?? 0;
    $subtotal = $consumo + $billar + $atencion;

    $pdf->setX(2);
  $pdf->Cell(11, 8, date('m/d', strtotime($fecha)), 0, 0, 'L');
    $pdf->Cell(15, 8, number_format($consumo, 0, ".", ","), 0, 0, 'R');
    $pdf->Cell(13, 8, number_format($billar, 0, ".", ","), 0, 0, 'R');
    $pdf->Cell(15, 8, number_format($atencion, 0, ".", ","), 0, 0, 'R');
    $pdf->Cell(16, 8, number_format($subtotal, 0, ".", ","), 0, 1, 'R');
}*/


$totalGeneral = 0;
foreach ($aperturas as $ap) {
    $id = $ap->id;
    $fecha = $ap->fecha;
    
$sentencia = $base_de_datos->query("SELECT productos.codigo, productos.lote,ventastienda.tarjeta,ventastienda.transferencia,productos_vendidos_tienda.id_producto, productos_vendidos_tienda.id, productos_vendidos_tienda.id_producto, (productos_vendidos_tienda.descuento) as descuento , sum(productos_vendidos_tienda.cantidad) as cantidad,productos.nombre, productos_vendidos_tienda.precio as precioVenta , SUM(productos_vendidos_tienda.precio*productos_vendidos_tienda.cantidad)as total FROM ventastienda,productos_vendidos_tienda ,productos WHERE productos_vendidos_tienda.apertura='$id' and productos_vendidos_tienda.id_venta=ventastienda.id and productos.id=productos_vendidos_tienda.id_producto  GROUP by productos_vendidos_tienda.id_producto;");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);

$subtotal=0;
$billar =0;
$consumo = 0;
$atencion = 0;
 foreach($productos as $producto){
 

     if($producto->lote=='BILLAR'){
   $id_producto= $producto->id_producto;
 
$sentencia_billar = $base_de_datos->query("SELECT 
p.codigo,
p.lote,
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
WHERE v.apertura='$id'
and t.id_producto='$id_producto';");
$billar_query = $sentencia_billar->fetchAll(PDO::FETCH_OBJ);

   $total_billar = 0;
foreach($billar_query as $b){




   $total_billar = $total_billar + number_format($b->precioVenta - $b->descuento,0,".",",");


}




$billar = $billar + $total_billar;

}else{
    if($producto->id_producto==317 || $producto->id_producto==330){
        $atencion+=$producto->total;
    }else{
        $consumo += $producto->total;
    }



}
 
 }

 $subtotal = $billar + $consumo + $atencion;


    $pdf->setX(2);
    $pdf->Cell(11, 8, date('m/d', strtotime($fecha)), 0, 0, 'L');
    $pdf->Cell(15, 8, number_format($consumo, 0, ".", ","), 0, 0, 'R');
    $pdf->Cell(13, 8, number_format($billar, 0, ".", ","), 0, 0, 'R');
    $pdf->Cell(15, 8, number_format($atencion, 0, ".", ","), 0, 0, 'R');
    $pdf->Cell(16, 8, number_format($subtotal, 0, ".", ","), 0, 1, 'R');

    $totalGeneral = $totalGeneral +  $subtotal;
}





// === TOTAL GENERAL ===
$pdf->Ln(3);
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->setX(5);
$pdf->Cell(70, 8, 'TOTAL GENERAL: ' . number_format($totalGeneral, 0, ".", ",") . " Bs.", 0, 1, 'R');

// === OUTPUT PDF ===
$pdf->Output();
